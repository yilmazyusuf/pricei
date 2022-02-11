<?php

namespace App\Scraper;

use App\Models\Platforms;
use App\Scraper\Adapters\HasCompetingVendors;
use App\Scraper\Adapters\HasDisplayPrice;
use App\Scraper\Adapters\HasRealPrice;
use App\Scraper\Adapters\HasSellerId;
use App\Scraper\Adapters\HasSellerName;
use App\Scraper\Adapters\HasSellerShopUrl;
use App\Scraper\Adapters\HasSku;
use App\Scraper\Adapters\N11Adapter;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use voku\helper\HtmlDomParser;

class Scraper
{
    public static function scrape(string $url): HtmlDomParser
    {
        return HtmlDomParser::file_get_html($url);
    }

    public static function getPlatformAdapter(Platforms $platform, string $url): Adapter
    {
        $adapters = [
            'N11' => N11Adapter::class
        ];

        $html = self::scrape($url);

        return new $adapters[$platform->name]($html);
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
        $dtoParams['imageUrl'] = $adapter->getImageUrl();
        $dtoParams['price']['price'] = getAmount($adapter->getPrice());



        if ($adapter instanceof HasRealPrice) {
            $dtoParams['price']['realPrice'] = getAmount($adapter->getRealPrice());
        }


        if ($adapter instanceof HasSellerName) {
            $dtoParams['seller']['name'] = $adapter->getSellerName();
        }


        if ($adapter instanceof HasCompetingVendors) {
            $dtoParams['competingVendors']= $adapter->getCompetingVendors();
        }

        return new ScrapedProduct($dtoParams);
    }
}
