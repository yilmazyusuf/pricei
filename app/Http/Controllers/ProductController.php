<?php

namespace App\Http\Controllers;

use App\DataTables\ProductsDataTable;
use App\Http\Requests\ScrapeProductRequest;
use App\Http\Requests\StoreProductCategoriesRequest;
use App\Http\Requests\UpdateProductCategoriesRequest;
use App\Models\Platforms;
use App\Models\Products;
use App\Repositories\PlatformsRepository;
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
    protected function scrape(ScrapeProductRequest $request, Ajax $ajax, Products $productsModel)
    {
        $url = $request->get('scrape_url');
        $host = parseUrlHost($url);

        $platform = PlatformsRepository::platformByHost($host);

        if (is_null($platform)) {
            return;
        }

        $product = $this->cacheScrapedProduct($url, $platform);

        $productData = [
            'user_id' => 1, //@todo user_id
            'platform_id' => $platform->id,
            'name' => $product->name,
            'url' => $product->url,
            'productId' => $product->productId,
            'imageUrl' => $product->imageUrl,
            'price' => $product->price->price,
            'realPrice' => $product->price->realPrice,
            'sellingPrice' => $product->price->sellingPrice,
            'currency' => $product->currency,
            'sellerId' => $product->seller->id,
            'sellerName' => $product->seller->name,
            'sellerShopLink' => $product->seller->link,
            'isTracked' => false,
            'status' => false,
        ];

        $savedProduct = $productsModel::query()->updateOrCreate(
            [
                'user_id' => $productData['user_id'],
                'platform_id' => $platform->id,
                'productId' => $product->productId
            ],
            $productData,
        );

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

        $product->isTracked = true;
        $product->status = true;
        $product->save();

        Alert::success('Ürünün fiyatını takip etmeye başladınız.');
        return $ajax->redirect(route('products.index'));
    }

    private function cacheScrapedProduct(string $url, Platforms $platform): ScrapedProduct
    {
        //12 hour cache (43200)
        $decoded = md5($url);
        return Cache::remember('scraped_' . $decoded, 43200, function () use ($url, $platform) {
            $adapter = Scraper::getPlatformAdapter($platform, $url);
            return Scraper::buildProductDto($adapter, $url);
        });
    }
}
