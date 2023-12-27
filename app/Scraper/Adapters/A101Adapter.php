<?php

namespace App\Scraper\Adapters;

use App\Scraper\Adapter;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use voku\helper\HtmlDomParser;

class A101Adapter extends Adapter
{
    public function scrape()
    {
        $client = new Client();
        $cookieJar = CookieJar::fromArray([
            'countryCode' => 'TR',
            'language' => 'tr',
            'storefrontId' => 1,
            'userid' => 'undefined'
        ], 'a101.com.tr');

        $request = $client->request(
            'GET',
            $this->url,
            ['cookies' => $cookieJar]
        );
        $this->html = HtmlDomParser::str_get_html($request->getBody()->getContents());

    }

    public function getName(): string
    {
        return $this->html->findOne('span.js-page-name-placeholder')->innerText();
    }

    public function getImageUrl(): string
    {
        return $this->html->findOne('img.js-product-image')->getAttribute('src');
    }

    public function getId(): string
    {
        return $this->html->findOne('section.page-product')->getAttribute('data-pk');
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        foreach ($this->html->find('meta') as $meta) {
            if ($meta->getAttribute('property') === 'product:price:amount') {
                return $meta->getAttribute('content');
            }
        }

    }

    public function getCurrency(): string
    {
        return 'TRY';
    }
}
