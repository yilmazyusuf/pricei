<?php

namespace App\Repositories;

use App\Models\Platforms;
use App\Models\PriceHistories;
use App\Models\Products;
use App\Scraper\Dto\ScrapedProduct;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductsRepository extends Products
{
    public static function get(): Collection
    {
        return Products::query()
            ->orderBy('id', 'desc')
            ->get();
    }

    public static function createOrUpdate(Platforms $platform, ScrapedProduct $product, ?array $params = null): Builder|Model
    {
        $trackedDate = date('Y-m-d');
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
            'sellerId' => $product->seller->id,
            'sellerName' => $product->seller->name,
            'sellerShopLink' => $product->seller->link
        ];

        if ($params && is_array($params) && count($params) > 0) {
            $productData = array_merge($productData, $params);
        }

        /* @var $savedProduct Products */
        $savedProduct = Products::query()->updateOrCreate(
            [
                'user_id' => $productData['user_id'],
                'platform_id' => $platform->id,
                'shopProductId' => $product->shopProductId
            ],
            $productData,
        );

        //Price History for Product
        $savedProduct->priceHistory()->updateOrCreate(
            [
                'products_id' => $savedProduct->id,
                'trackedDate' => $trackedDate,
            ],
            [
                'price' => $productData['price'],
                'realPrice' => $productData['realPrice'],
                'trackedDate' => $trackedDate,
            ]
        );

        /* @var $vendor ScrapedProduct */
        //@todo silinmiş satıcıları bulup işaretle
        foreach ($product->competingVendors as $vendor) {
            $vendorParams = [
                'url' => $vendor->url,
                'shopProductId' => $vendor->shopProductId,
                'price' => $vendor->price->price,
                'realPrice' => $vendor->price->realPrice,
                'sellerId' => $vendor->seller->id,
                'sellerName' => $vendor->seller->name,
                'sellerShopLink' => $vendor->seller->link,
            ];

            $updateConditions = [];
            if ($vendor->seller->id) {
                $updateConditions['sellerId'] = $vendor->seller->id;
            }

            if ($vendor->seller->name) {
                $updateConditions['sellerName'] = $vendor->seller->name;
            }

            if (count($updateConditions) > 0) {
                $savedVendor = $savedProduct->vendors()->updateOrCreate(
                    $updateConditions,
                    $vendorParams
                );

                //Price History for Vendor
                $savedVendor->priceHistory()->updateOrCreate(
                    [
                        'product_vendors_id' => $savedVendor->id,
                        'trackedDate' => $trackedDate,
                    ],
                    [
                        'price' => $vendorParams['price'],
                        'realPrice' => $vendorParams['realPrice'],
                        'trackedDate' => $trackedDate,
                    ]
                );
            }
        }

        return $savedProduct;
    }

    public static function getForScrapeJob(): Collection|array
    {
        //@todo platform job için aktif ise kuralını ekle
        return Products::query()
            ->with('platform')
            ->where('isJobActive', 1)
            ->where('isJobLocked', 0)
            ->where('jobTries', '<=', 3)
            ->where('nextJobDate', '<=', now())
            ->take(10)
            ->get();
    }
}
