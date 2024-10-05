<?php

namespace App\Scraper\Adapters;

use App\Scraper\Adapter;
use App\Scraper\Adapters\Contracts\HasRealPrice;
use GuzzleHttp\Client;

class A101Adapter extends Adapter implements HasRealPrice
{
    private \stdClass $priceContent;

    public function scrape()
    {
        $client = new Client();
        preg_match('/_p-(\d+)/', $this->url, $matches);

        $productId = $matches[1];

        $priceContentUrl = 'https://rio.a101.com.tr/dbmk89vnr/CALL/Store/getProductBySku/C078?sku=' . $productId . '';
        $priceRequest = $client->request(
            'GET',
            $priceContentUrl
        );

        $priceContent = $priceRequest->getBody()->getContents();
        $this->priceContent = json_decode($priceContent);

        $productInfoUrl = 'https://rio.a101.com.tr/dbmk89vnr/CALL/Product/get/' . $productId . '';

        $productInfoRequest = $client->request(
            'GET',
            $productInfoUrl
        );
        $productContent = $productInfoRequest->getBody()->getContents();
        $this->json = json_decode($productContent);
    }

    public function getName(): string
    {
        return $this->json->attributes->name;
    }

    public function getImageUrl(): string
    {
        return $this->json->images[0]->url;
    }

    public function getId(): string
    {
        return $this->json->id;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->priceContent->product->price->discountedStr;
    }

    public function getRealPrice(): string
    {
        return $this->priceContent->product->price->normalStr;
    }

    public function getCurrency(): string
    {
        return 'TRY';
    }
}
