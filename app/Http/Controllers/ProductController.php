<?php

namespace App\Http\Controllers;

use App\DataTables\ProductsDataTable;
use App\Http\Requests\ScrapeProductRequest;
use App\Http\Requests\StoreProductCategoriesRequest;
use App\Http\Requests\UpdateProductCategoriesRequest;
use App\Models\Products;
use App\Repositories\PlatformsRepository;
use App\Scraper\Scraper;
use App\Utils\Ajax;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

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
     * @return View|JsonResponse|void
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    protected function scrape(ScrapeProductRequest $request, Ajax $ajax)
    {
        $url = $request->get('scrape_url');
        $host = parseUrlHost($url);

        $platform = PlatformsRepository::platformByHost($host);

        if (is_null($platform)) {
            return;
        }

        //12 hour cache (43200)
        $decoded = md5($url);
        //$product = Cache::remember('scraped_' . $decoded, 43200, function () use ($url, $platform) {
        $adapter = Scraper::getPlatformAdapter($platform, $url);
        $product = Scraper::buildProductDto($adapter, $url);


        //});


        return $ajax->runJavascript("$('#product_scraped_preview_modal').modal('show')")
            ->redrawSection('modal_section')
            ->view('partials.product_scraped_preview_modal', ['product' => $product]);
    }
}
