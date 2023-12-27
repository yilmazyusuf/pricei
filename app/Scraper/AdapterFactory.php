<?php

namespace App\Scraper;

use App\Scraper\Adapters\A101Adapter;
use App\Scraper\Adapters\AmazonAdapter;
use App\Scraper\Adapters\BimAdapter;
use App\Scraper\Adapters\HepsiBuradaAdapter;
use App\Scraper\Adapters\N11Adapter;
use App\Scraper\Adapters\TrendyolAdapter;

class AdapterFactory
{
    public static function getAdapterInstance(string $platformName, string $url): Adapter
    {
        $adapters = [
            'N11' => N11Adapter::class,
            'TRENDYOL' => TrendyolAdapter::class,
            'HEPSİBURADA' => HepsiBuradaAdapter::class,
            'AMAZON' => AmazonAdapter::class,
            'A101' => A101Adapter::class,
            'BİM' => BimAdapter::class
        ];

        return new $adapters[$platformName]($url);
    }
}
