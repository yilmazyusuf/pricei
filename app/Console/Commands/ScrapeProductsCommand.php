<?php

namespace App\Console\Commands;

use App\Models\Products;
use App\Repositories\ProductsRepository;
use App\Scraper\AdapterFactory;
use App\Scraper\Scraper;
use Illuminate\Console\Command;

class ScrapeProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = ProductsRepository::getForScrapeJob();

        /* @var $product Products */
        foreach ($products as $product) {
            try {

                $adapter = AdapterFactory::getAdapterInstance($product->platform->name, $product->url);
                $scraper = new Scraper($adapter);
                $scrapedProduct = $scraper->scrape()->buildProductDto();
                $nextJobDate = now()->addHours(12);
                $productParams['lasJobStatus'] = true;
                $productParams['lastJobDate'] = now();
                $productParams['nextJobDate'] = $nextJobDate;

                ProductsRepository::createOrUpdate($product->platform, $scrapedProduct, $productParams, date('Y-m-d'));

            } catch (\Exception $exception) {
                $product->lasJobStatus = false;
                $product->jobTries++;
                $nextJobDate = now()->addHours(1);
                $product->nextJobDate = $nextJobDate;
                if ($product->jobTries == 3) {
                    $product->isJobLocked = true;
                }
                $product->lasJobErrorMessage = $exception->getMessage();
                //@todo platforma ait son 10 cron başarısız ize platformu durdur
                $product->save();
            }
            sleep(6);
        }
        return 0;
    }
}
