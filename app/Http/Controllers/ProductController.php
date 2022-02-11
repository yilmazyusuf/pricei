<?php

namespace App\Http\Controllers;

use App\DataTables\ProductsDataTable;
use App\Http\Requests\ScrapeProductRequest;
use App\Http\Requests\StoreProductCategoriesRequest;
use App\Http\Requests\UpdateProductCategoriesRequest;
use App\Models\Products;
use App\Repositories\PlatformsRepository;
use App\Scraper\ScrapedProduct;
use App\Utils\Ajax;
use voku\helper\HtmlDomParser;
use Illuminate\Support\Facades\Cache;

class ProductController extends ResourceController
{
    protected string $indexDataTable = ProductsDataTable::class;
    protected string $storeRequest = StoreProductCategoriesRequest::class;
    protected string $updateRequest = UpdateProductCategoriesRequest::class;
    protected string $resourceName = 'products';
    protected string $model = Products::class;

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    protected function scrape(ScrapeProductRequest $request, Ajax $ajax)
    {
        $url = $request->get('scrape_url');
        $host = parseUrlHost($url);
        $decoded = md5($url);

        $platform = PlatformsRepository::platformByHost($host);
        if (is_null($platform)) {
            return;
        }
        //12 hour cache (43200)
        $product = Cache::remember('scraped_'.$decoded, 43200, function () use ($url) {
            $product = [];
            $html = HtmlDomParser::file_get_html($url);

            $product['name'] = $html->findOne('h1.proName')->innertext;
            $product['id'] = $html->findOne('input#prodId')->getAttribute('value');
            $product['sku_id'] = $html->findOne('input#skuId')->getAttribute('value');
            $product['seller']['id'] = $html->findOne('input#sellerId')->getAttribute('value');

            $shopTag = $html->findOne('a.main-seller-name');
            $product['seller']['shop_url'] = $shopTag->getAttribute('href');
            $product['seller']['name'] = $shopTag->getAttribute('title');

            $product['image_url'] = $html->findOne('div.imgObj > a > img')->getAttribute('src');

            $priceScrapeUrl = "https://www.n11.com/component/render/newProductDiscountAndStockArea?skuId={$product['sku_id']}&productId={$product['id']}";
            $priceHtml = HtmlDomParser::file_get_html($priceScrapeUrl);
            $product['price']['real_price'] = $priceHtml->findOne('input#productRealPrice')->getAttribute('value');
            $product['price']['display_price'] = $priceHtml->findOne('input#productDisplayPrice')->getAttribute('value');
            $product['price']['price'] = $priceHtml->findOne('input#productPrice')->getAttribute('value');

            $otherShops = $html->find('div.unf-cmp-body');
            $product['stores'] = [];
            foreach ($otherShops as $otherShop) {
                $store = [];
                $otherShopTag = $otherShop->findOne('a.b-n-title');
                $store['price']['realPrice'] = getAmount($otherShop->findOne('span.b-p-old')->innertext);
                $store['price']['price'] = getAmount($otherShop->findOne('span.b-p-new')->innertext);

                $store['seller']['shopUrl'] = $otherShopTag->getAttribute('href');
                $store['seller']['name'] = $otherShopTag->getAttribute('title');
                $store['url'] = $otherShop->findOne('input.sellerUrl')->getAttribute('value');

                $competingVendors = new ScrapedProduct(
                    url:$store['url'],
                    price : [
                        'price' => getAmount($store['price']['price']),
                        'realPrice' => getAmount($store['price']['realPrice'])
                    ],
                    seller:[
                        'name' => $store['seller']['name'],
                        'shopUrl' => $store['seller']['shopUrl'],
                    ],
                );

                $product['stores'][] = $competingVendors;
            }

            return $product;
        });

        $scrapedProduct = new ScrapedProduct(
            name:$product['name'],
            url:$url,
            productId:$product['id'],
            sku:$product['sku_id'],
            imageUrl:$product['image_url'],
            seller:[
                'id' => $product['seller']['id'],
                'name' => $product['seller']['name'],
                'shopUrl' => $product['seller']['shop_url'],
            ],
            price : [
                'price' => getAmount($product['price']['price']),
                'realPrice' => getAmount($product['price']['real_price']),
                'displayPrice' => getAmount($product['price']['display_price']),
            ],
            competingVendors : $product['stores']
        );




        return $ajax->runJavascript("$('#product_scraped_preview_modal').modal('show')")
            ->redrawSection('modal_section')
            ->view('partials.product_scraped_preview_modal', ['product' => $scrapedProduct]);
    }
}
