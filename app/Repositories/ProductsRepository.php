<?php

namespace App\Repositories;

use App\Models\Notifications;
use App\Models\Platforms;
use App\Models\PriceHistories;
use App\Models\Products;
use App\Notifications\PriceChanged;
use App\Scraper\Dto\ScrapedProduct;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ProductsRepository extends Products
{
    public static function list(): Builder
    {
        return Products::query()
            ->orderBy('isJobActive', 'desc')
            ->orderBy('id', 'desc');
    }

    public static function createOrUpdate(
        Platforms      $platform,
        ScrapedProduct $product,
        ?array         $params,
        string         $trackedDate
    ): Builder|Model {
        $productData = [
            'user_id' => 1, //@todo user_id
            'platform_id' => $platform->id,
            'name' => $product->name,
            'url' => $product->url,
            'shopProductId' => $product->shopProductId,
            'imageUrl' => $product->imageUrl,
            'price' => $product->price->price,
            'realPrice' => $product->price->realPrice,
            'sellingPrice' => $product->price->sellingPrice,
            'currency' => $product->currency,
            'sellerId' => $product->seller->id ?? null,
            'sellerName' => $product->seller->name ?? null,
            'sellerShopLink' => $product->seller->link ?? null,
            'deleted_at' => null,
        ];

        if ($params && is_array($params) && count($params) > 0) {
            $productData = array_merge($productData, $params);
        }


        /* @var $savedProduct Products */
        $savedProduct = Products::query()->withTrashed()->updateOrCreate(
            [
                'user_id' => $productData['user_id'],
                'platform_id' => $platform->id,
                'shopProductId' => $product->shopProductId
            ],
            $productData,
        );

        //Price History for Product
        $productPriceData = [
            'price' => $productData['price'],
            'realPrice' => $productData['realPrice'],
            'trackedDate' => $trackedDate,
        ];

        //Check Price Changed
        /* @var $lastProductHistory Products */
        $lastProductHistory = $savedProduct->priceHistory()
            ->latest('trackedDate')
            ->first();
        $priceChanged = false;
        if ($lastProductHistory) {
            if ($lastProductHistory->price != $productData['price'] && $lastProductHistory->price > 0) {
                $productPriceData['pricePreviousDiff'] = ($productData['price'] - $lastProductHistory->price);
                $productPriceData['pricePreviousPercentDiff'] = priceDiffPercent($lastProductHistory->price, $productData['price']);
                $priceChanged = true;
            }
        }
        /**
         * @var $priceHistory PriceHistories
         */
        $priceHistory = $savedProduct->priceHistory()->updateOrCreate(
            [
                'products_id' => $savedProduct->id,
                'trackedDate' => $trackedDate,
            ],
            $productPriceData
        );
        if($priceChanged === true){
            $notification = $priceHistory->notifications()->save(new Notifications());
            $n = $notification->notify(new PriceChanged($notification));
            dd($n);


        }

        /* @var $vendor ScrapedProduct */
        //@todo silinmiş satıcıları bulup işaretle
        if ($product->competingVendors && count($product->competingVendors) > 0) {
            foreach ($product->competingVendors as $vendor) {
                $vendorParams = [
                    'url' => $vendor->url ?? null,
                    'shopProductId' => $vendor->shopProductId ?? null,
                    'price' => $vendor->price->price,
                    'realPrice' => $vendor->price->realPrice ?? null,
                    'sellerId' => $vendor->seller->id ?? null,
                    'sellerName' => $vendor->seller->name ?? null,
                    'sellerShopLink' => $vendor->seller->link ?? null,
                ];

                $updateConditions = [];
                if ($vendor->seller->id) {
                    $updateConditions['sellerId'] = $vendor->seller->id;
                }

                if ($vendor->seller->name) {
                    $updateConditions['sellerName'] = $vendor->seller->name;
                }

                if (count($updateConditions) > 0) {
                    /* @var $savedVendor Products */
                    $savedVendor = $savedProduct->vendors()->updateOrCreate(
                        $updateConditions,
                        $vendorParams
                    );

                    $vendorPriceData = [
                        'price' => $vendorParams['price'],
                        'realPrice' => $vendorParams['realPrice'],
                        'trackedDate' => $trackedDate,
                    ];

                    //Check Price Changed
                    /* @var $lastVendorHistory Products */
                    $lastVendorHistory = $savedVendor->priceHistory()
                        ->latest('trackedDate')
                        ->first();

                    if ($lastVendorHistory) {
                        if ($lastVendorHistory->price != $productData['price']) {
                            $vendorPriceData['pricePreviousDiff'] = ($vendorParams['price'] - $lastVendorHistory->price);
                            $vendorPriceData['pricePreviousPercentDiff'] = priceDiffPercent($lastVendorHistory->price, $vendorParams['price']);
                        }
                    }

                    //Price History for Vendor
                    $savedVendor->priceHistory()->updateOrCreate(
                        [
                            'product_vendors_id' => $savedVendor->id,
                            'trackedDate' => $trackedDate,
                        ],
                        $vendorPriceData
                    );
                }
            }
        }


        return $savedProduct;
    }

    /**
     * @return Collection|static[]
     */
    public static function getForScrapeJob(): Collection|array
    {
        //@todo platform job için aktif ise kuralını ekle
        return Products::query()
            ->with('platform')
            ->where('isJobActive', true)
            ->where('isJobLocked', false)
            ->where('jobTries', '<=', 3)
            ->where('nextJobDate', '<=', now())
            ->take(10)
            ->get();
    }
}
