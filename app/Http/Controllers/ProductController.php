<?php

namespace App\Http\Controllers;

use App\DataTables\ProductsDataTable;
use App\Http\Requests\ScrapeProductRequest;
use App\Http\Requests\StoreProductCategoriesRequest;
use App\Http\Requests\UpdateProductCategoriesRequest;
use App\Jobs\ScrapeProductJob;
use App\Models\Platforms;
use App\Models\Products;
use App\Repositories\PlatformsRepository;
use App\Repositories\ProductsRepository;
use App\Scraper\AdapterFactory;
use App\Scraper\ScrapedProduct;
use App\Scraper\Scraper;
use App\Utils\Ajax;
use App\View\Components\Alert;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class ProductController extends ResourceController
{
    protected string $indexDataTable = ProductsDataTable::class;
    protected string $storeRequest = StoreProductCategoriesRequest::class;
    protected string $updateRequest = UpdateProductCategoriesRequest::class;
    protected string $resourceName = 'products';
    protected string $model = Products::class;

    /**
     * @param ScrapeProductRequest $request
     * @param Ajax $ajax
     * @param Products $productsModel
     * @return View|JsonResponse|void
     */
    protected function scrape(ScrapeProductRequest $request, Ajax $ajax)
    {
        $url = $request->get('scrape_url');
        $host = parseUrlHost($url);

        $platform = PlatformsRepository::platformByHost($host);

        if (is_null($platform)) {
            return;
        }

        $product = $this->cacheScrapedProduct($url, $platform);
        $savedProduct = ProductsRepository::createOrUpdate($platform, $product);

        $viewData = ['product' => $product, 'savedProduct' => $savedProduct];

        return $ajax->runJavascript("$('#product_scraped_preview_modal').modal('show')")
            ->redrawSection('modal_section')
            ->view('partials.product_scraped_preview_modal', $viewData);
    }

    protected function track($id, Ajax $ajax): JsonResponse|RedirectResponse
    {
        //@todo user_id
        $product = Products::query()
            ->where('user_id', 1)
            ->where('id', $id)
            ->first();

        if (!$product) {
            abort(404);
        }

        if ($product->queueStatus == 0) {
            $nextJobDate = now()->addSeconds(10);
            $product->queueStatus = 2;
            $product->nextJobDate = $nextJobDate;
            $product->save();
            ScrapeProductJob::dispatch($product)->delay($nextJobDate);
        }



        Alert::success('Ürünün fiyatını takip etmeye başladınız.');
        return $ajax->redirect(route('products.index'));
    }

    private function cacheScrapedProduct(string $url, Platforms $platform): ScrapedProduct
    {
        //12 hour cache (43200)
        $decoded = md5($url);
        return Cache::remember('scraped_' . $decoded, 43200, function () use ($url, $platform) {
            $adapter = AdapterFactory::getAdapterInstance($platform->name, $url);
            $scraper = new Scraper($adapter);
            return $scraper->scrape()->buildProductDto();
        });
    }
}
