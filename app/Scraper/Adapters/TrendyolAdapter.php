<?php

namespace App\Scraper\Adapters;

use App\Scraper\Adapter;
use App\Scraper\ScrapedProduct;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class TrendyolAdapter extends Adapter implements
    HasSellerName,
    HasRealPrice,
    HasSellingPrice,
    HasSellerId,
    HasSellerLink,
    HasCompetingVendors
{
    public function __construct(protected string $url)
    {
        parent::__construct($url);
        $this->readJsonPattern();
    }

    public function setScrapedContent()
    {
        $client = new Client();

        $cookieJar = CookieJar::fromArray([
            'countryCode' => 'TR',
            'language' => 'tr',
            'storefrontId' => 1,
            'userid' => 'undefined'
        ], 'trendyol.com');

        $request = $client->request(
            'GET',
            $this->url,
            ['cookies' => $cookieJar]
        );

        $this->htmlContent = $request->getBody()->getContents();
    }

    private function readJsonPattern()
    {
        preg_match('/{"product":{(.*?)"}}/', $this->htmlContent, $matches);

        $decodedJson = json_decode($matches[0]);
        $this->json = $decodedJson;
    }

    public function getName(): string
    {

        return $this->json->product->name;
    }

    public function getImageUrl(): string
    {
        $cdnUrl = $this->json->configuration->cdnUrl;
        return $cdnUrl . $this->json->product->images[0];
    }

    public function getId(): string
    {
        return $this->json->product->id;
    }

    public function getPrice(): string
    {
        return $this->json->product->price->discountedPrice->value;
    }

    public function getCurrency(): string
    {
        return 'TRY';
    }

    public function getRealPrice(): string
    {
        return $this->json->product->price->originalPrice->value;
    }

    public function getSellingPrice(): string
    {
        return $this->json->product->price->sellingPrice->value;
    }


    public function getSellerName(): string
    {
        return $this->json->product->merchant->name;
    }

    public function getSellerId(): string
    {
        return $this->json->product->merchant->id;
    }

    public function getSellerLink(): string
    {
        return 'https://www.trendyol.com'.$this->json->product->merchant->sellerLink;
    }

    /**
     * @throws UnknownProperties
     */
    public function getCompetingVendors(): array
    {
        $vendors = [];
        $otherShops = $this->json->product->otherMerchants;

        foreach ($otherShops as $otherShop) {

            $productUrl = 'https://www.trendyol.com'.$otherShop->url;

            $realPrice = getAmount($otherShop->price->originalPrice->value);
            $sellingPrice = getAmount($otherShop->price->sellingPrice->value);
            $price = getAmount($otherShop->price->discountedPrice->value);
            $sellerShopUrl = 'https://www.trendyol.com/sr?mid='.$otherShop->merchant->id;
            $sellerId= $otherShop->merchant->id;
            $sellerName = $otherShop->merchant->name;

            $competingVendor = new ScrapedProduct(
                url: $productUrl,
                currency: 'TRY',
                price: [
                    'price' => getAmount($price),
                    'realPrice' => getAmount($realPrice),
                    'sellingPrice' => getAmount($sellingPrice)
                ],
                seller: [
                    'id' => $sellerId,
                    'name' => $sellerName,
                    'link' => $sellerShopUrl,
                ],
            );

            $vendors[] = $competingVendor;
        }
        return $vendors;
    }
}
