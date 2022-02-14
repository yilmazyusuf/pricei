<?php

namespace App\Repositories;

use App\Models\Platforms;
use App\Models\Products;
use App\Scraper\ScrapedProduct;
use Illuminate\Database\Eloquent\Collection;

class ProductsRepository extends Products
{
    public static function get(): Collection
    {
        return Products::query()
            ->orderBy('name', 'asc')
            ->get();
    }

    public static function createOrUpdate(Platforms $platform, ScrapedProduct $product, ?array $params = null): Products
    {
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
            'sellerShopLink' => $product->seller->link
        ];
        if ($params) {
            $productData = array_merge($productData, $params);
        }
        return Products::query()->updateOrCreate(
            [
                'user_id' => $productData['user_id'],
                'platform_id' => $platform->id,
                'productId' => $product->productId
            ],
            $productData,
        );
    }


    public static function getForScrape(): Collection|array
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
