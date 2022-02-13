<?php

namespace App\Jobs;

use App\Models\Products;
use App\Repositories\ProductsRepository;
use App\Scraper\AdapterFactory;
use App\Scraper\Scraper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ScrapeProductJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public int $tries = 5;
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
        $platform = $this->product->platform;
        $adapter = AdapterFactory::getAdapterInstance($platform->name, $this->product->url);
        $scraper = new Scraper($adapter);
        $scrapedProduct = $scraper->scrape()->buildProductDto();
        ProductsRepository::createOrUpdate($platform, $scrapedProduct);

        $repeatItSelf = new ScrapeProductJob($this->product);
        $toDispatch = $this->product->status && $this->product->isTracked;
        $repeatItSelf->dispatchIf($toDispatch, $this->product)->delay(now()->addHours(6));
    }

    public function uniqueId(): int
    {
        return $this->product->id;
    }
}
