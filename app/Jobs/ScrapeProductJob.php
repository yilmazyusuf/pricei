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

    /**
     * Handle a job failure.
     *
     * @param Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        $this->product->hasQueueError = true;
        $this->product->queueErrorCount = $this->product->queueErrorCount + 1;
        $this->product->lastQueueErrorMsg = $exception->getMessage();
        $this->product->lastQueueErrorDate = now();
        $this->product->lastJobDate = now();

        if ($this->product->queueErrorCount == 3) {
            $this->product->isQueueDisabled = true;
            $this->product->queueDisabledReason = 1;
        }
        $this->product->save();
    }

    public function uniqueId(): int
    {
        return $this->product->id;
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        return [
            (new WithoutOverlapping('scraped_product'))->releaseAfter(600),
            (new ThrottlesExceptions(50, 10))->backoff(10)
        ];
    }

    /**
     * Determine the time at which the job should timeout.
     *
     * @return DateTime
     */
    public function retryUntil()
    {
        return now()->addHours(12);
    }
}
