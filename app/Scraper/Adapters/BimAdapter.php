<?php

namespace App\Scraper\Adapters;

use App\Scraper\Adapter;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use voku\helper\HtmlDomParser;

class BimAdapter extends Adapter
{
    public function scrape()
    {
        $client = new Client();

        $request = $client->request(
            'GET',
            $this->url
        );
        $this->html = HtmlDomParser::str_get_html($request->getBody()->getContents());

    }

    public function getName(): string
    {
        return $this->html->findOne('div.detailArea div.titleArea h2.title')->innerText();
    }

    public function getImageUrl(): string
    {
        $domain = 'https://www.bim.com.tr';
        $imageSrc = $this->html->findOne('div.detailArea a.imageArea img')->getAttribute('src');

        return $domain.$imageSrc;
    }

    public function getId(): string
    {
        return $this->html->findOne('div.detailArea div.titleArea div.shareArea a')->getAttribute('data-id');
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        $price = $this->html->findOne('div.detailArea div.priceArea div.quantify')->innerText();
        $priceFloat = $this->html->findOne('div.detailArea div.priceArea div.kusurArea span.number')->innerText();
        return $price.$priceFloat;

    }

    public function getCurrency(): string
    {
        return 'TRY';
    }
}
