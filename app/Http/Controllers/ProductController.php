<?php

namespace App\Http\Controllers;

use App\DataTables\ProductsDataTable;
use App\Http\Requests\ScrapeProductRequest;
use App\Http\Requests\StoreProductCategoriesRequest;
use App\Http\Requests\UpdateProductCategoriesRequest;
use App\Models\Platforms;
use App\Models\Products;
use App\Repositories\PlatformsRepository;
use App\Repositories\ProductsRepository;
use App\Scraper\AdapterFactory;
use App\Scraper\Dto\ScrapedProduct;
use App\Scraper\Scraper;
use App\Utils\Ajax;
use App\View\Components\Alert;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Psr\Container\NotFoundExceptionInterface;

class ProductController extends ResourceController
{
    protected string $indexDataTable = ProductsDataTable::class;
    protected string $storeRequest = StoreProductCategoriesRequest::class;
    protected string $updateRequest = UpdateProductCategoriesRequest::class;
    protected string $resourceName = 'products';
    protected string $model = Products::class;

    //@todo https://colorlib.com/polygon/gentelella/other_charts.html ürün listesinde fiyat değişimleri grafiği
    //@todo ürün getir için yeni modal box
    //@todo diğer mağaza fiyatlarının kaydedilmesi
    //@todo magazların toplam fiyat ortalaması
    //@todo mağazalardaki en düşük ve en yüksek fiyatın gösterimi
    //@todo ürün listesi filitreler (Fiyatı artan azalan ürünler, bugün,dün,buhafta bu ay,son 20 gün)
    /**
     * @param ScrapeProductRequest $request
     * @param Ajax $ajax
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

        $viewData = ['product' => $savedProduct];

        $modal = 'partials.product_scraped_preview_modal';
        if ($savedProduct->vendors()->count() > 0) {
            $modal = 'partials.product_scraped_preview_vendors_modal';
        }

        return $ajax->runJavascript("$('#product_scraped_preview_modal').modal('show')")
            ->redrawSection('modal_section')
            ->view($modal, $viewData);
    }

    protected function showDetail(int $id)
    {

        //@todo user_id
        $product = Products::query()
            ->where('user_id', 1)
            ->where('id', $id)
            ->first();

        if (!$product) {
            abort(404);
        }
        return view('products.detail')->with(
            ['product' => $product]
        );
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function updateStatus(Ajax $ajax)
    {
        $productId = request()->get('productId');
        $productStatus = request()->get('status');
        //@todo user_id
        $product = Products::query()
            ->where('user_id', 1)
            ->where('id', $productId)
            ->first();

        if (!$product) {
            abort(404);
        }

        $product->isJobActive = (boolean)json_decode(strtolower($productStatus));
        $product->save();
        return $ajax->jsonResponse();
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

        $nextJobDate = now()->addHours(12);

        $product->nextJobDate = $nextJobDate;
        $product->isJobActive = true;
        $product->save();

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
