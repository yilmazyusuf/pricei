<?php

namespace App\Scraper;

use App\Models\Platforms;
use App\Scraper\Adapters\HasCompetingVendors;
use App\Scraper\Adapters\HasDisplayPrice;
use App\Scraper\Adapters\HasRealPrice;
use App\Scraper\Adapters\HasSellerId;
use App\Scraper\Adapters\HasSellerLink;
use App\Scraper\Adapters\HasSellerName;
use App\Scraper\Adapters\HasSellerShopUrl;
use App\Scraper\Adapters\HasSellingPrice;
use App\Scraper\Adapters\HasSku;
use App\Scraper\Adapters\HepsiBuradaAdapter;
use App\Scraper\Adapters\N11Adapter;
use App\Scraper\Adapters\TrendyolAdapter;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class Scraper
{

    public static function getPlatformAdapter(Platforms $platform, string $url): Adapter
    {
        $adapters = [
            'N11' => N11Adapter::class,
            'TRENDYOL' => TrendyolAdapter::class,
            'HEPSİBURADA' => HepsiBuradaAdapter::class
        ];

        return new $adapters[$platform->name]($url);
    }

    /**
     * @throws UnknownProperties
     */
    public static function buildProductDto(Adapter $adapter, string $url): ScrapedProduct
    {
        $dtoParams = [];
        $dtoParams['url'] = $url;
        $dtoParams['name'] = $adapter->getName();
        $dtoParams['productId'] = $adapter->getId();
        $dtoParams['currency'] = $adapter->getCurrency();
        $dtoParams['imageUrl'] = $adapter->getImageUrl();
        $dtoParams['price']['price'] = getAmount($adapter->getPrice());

        if ($adapter instanceof HasRealPrice) {
            $dtoParams['price']['realPrice'] = getAmount($adapter->getRealPrice());
        }

        if ($adapter instanceof HasSellingPrice) {
            $dtoParams['price']['sellingPrice'] = getAmount($adapter->getSellingPrice());
        }

        if ($adapter instanceof HasSellerId) {
            $dtoParams['seller']['id'] = $adapter->getSellerId();
        }

        if ($adapter instanceof HasSellerLink) {
            $dtoParams['seller']['link'] = $adapter->getSellerLink();
        }

        if ($adapter instanceof HasSellerName) {
            $dtoParams['seller']['name'] = $adapter->getSellerName();
        }

        if ($adapter instanceof HasCompetingVendors) {
            $dtoParams['competingVendors'] = $adapter->getCompetingVendors();
        }

        return new ScrapedProduct($dtoParams);
    }
}
