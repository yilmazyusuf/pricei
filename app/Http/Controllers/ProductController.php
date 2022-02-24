<?php

namespace App\Http\Controllers;

use App\DataTables\ProductsDataTable;
use App\DataTables\ProductsPriceHistoryDataTable;
use App\Http\Filters\PriceHistoryFilter;
use App\Http\Filters\ProductsPriceHistoryChartFilter;
use App\Http\Requests\ScrapeProductRequest;
use App\Http\Requests\StoreProductCategoriesRequest;
use App\Http\Requests\UpdateProductCategoriesRequest;
use App\Models\Platforms;
use App\Models\PriceHistories;
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

        try {
            $product = $this->cacheScrapedProduct($url, $platform);
        } catch (\Exception $exception) {
            //@todo log exception
            return $ajax->runJavascript("toasterError('Ürün bilgileri okunamadı.');")
                ->jsonResponse();
        }

        $savedProduct = ProductsRepository::createOrUpdate(
            $platform,
            $product,
            null,
            date('Y-m-d')
        );

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
            ->with('vendors',)
            ->where('user_id', 1)
            ->where('id', $id)
            ->first();

        if (!$product) {
            abort(404);
        }

        $productVendorIds = $product->vendors->pluck('id')->toArray();
        $priceHistory = PriceHistories::query()
            ->with(['vendor', 'product'])
            ->where('products_id', $product->id)
            ->orWhereIn('product_vendors_id', $productVendorIds)
            ->orderBy('id', 'desc');

        $chartFilter = new PriceHistoryFilter($priceHistory);
        $filteredHistory = $chartFilter->filter()->get();

        $productHistoryDataTable = new ProductsPriceHistoryDataTable($filteredHistory);

        //dd($this->getProductPriceHistoryChartData($filteredHistory));
        if (request()->has('priceHistoryDataTable')) {
            return $productHistoryDataTable->render('');
        }

        return view('products.detail')->with(
            [
                'product' => $product,
                'productPriceChart' => $this->getProductPriceHistoryChartData($filteredHistory),
                'lastPriceUpdate' => $product->lastPriceUpdate,
                'productHistoryDataTable' => $productHistoryDataTable
            ]
        );
    }

    private function getProductPriceHistoryChartData($productChart)
    {

        $grouped = $productChart->sortBy('trackedDate')->groupBy('trackedDate');
        $vendors = [];
        $dimensions = ['date'];
        $series = [];
        foreach ($grouped as $date => $histories) {
            $vendor = [];
            $vendor['date'] = $date;
            foreach ($histories as $history) {
                if ($history->product_vendors_id) {
                    $vendor[$history->vendor->sellerName] = $history->price;
                    array_push($dimensions, $history->vendor->sellerName);
                }

                if ($history->products_id) {
                    $vendor[$history->product->sellerName] = $history->price;
                    array_push($dimensions, $history->product->sellerName);
                }

                array_push($series, ['type' => 'line','smooth' => true]);
            }
            $vendors[] = $vendor;
        }


        return [
            'source' => collect($vendors)->toJson(),
            'dimensions' => collect($dimensions)->unique()->toJson(),
            'series' => collect($series)->toJson(),
        ];
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
