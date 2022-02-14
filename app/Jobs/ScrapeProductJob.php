<?php

namespace App\Jobs;

use App\Models\Products;
use App\Repositories\ProductsRepository;
use App\Scraper\AdapterFactory;
use App\Scraper\Scraper;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Throwable;

class ScrapeProductJob implements ShouldQueue //, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private Products $product)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws UnknownProperties
     */
    public function handle()
    {
        if ($this->product->isQueueDisabled == 1) {
            $this->delete();
        }

        //https://laracasts.com/discuss/channels/laravel/queue-job-retry-after-x-minutes-if-failed

        $this->product->queueStatus = 3;
        $this->product->save();

        $platform = $this->product->platform;
        $adapter = AdapterFactory::getAdapterInstance($platform->name, $this->product->url);
        $scraper = new Scraper($adapter);
        $scrapedProduct = $scraper->scrape()->buildProductDto();
        $productParams = [
            'hasQueueError' => false,
            'queueErrorCount' => 0,
            'totalQueueCount' => $this->product->totalQueueCount + 1,
            'lastJobDate' => now(),
            'queueStatus' => 1,
        ];

        ProductsRepository::createOrUpdate($platform, $scrapedProduct, $productParams);
        $repeatItSelf = new ScrapeProductJob($this->product);
        $nextJobDate = now()->addHours(1);
        $repeatItSelf->dispatch($this->product)->delay($nextJobDate);

        $this->product->queueStatus = 2;
        $this->product->nextJobDate = $nextJobDate;
        $this->product->save();
    }



}
