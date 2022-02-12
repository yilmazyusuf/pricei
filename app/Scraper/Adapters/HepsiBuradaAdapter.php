<?php

namespace App\Scraper\Adapters;

use App\Scraper\Adapter;
use App\Scraper\ScrapedProduct;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\RequestException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use voku\helper\HtmlDomParser;

class HepsiBuradaAdapter extends Adapter implements
    HasSellerName,
    HasRealPrice,
    HasSellerId,
    HasSellerLink
{
    public function __construct(protected string $url)
    {
        parent::__construct($url);
        $this->readJsonPattern();
    }

    public function setScrapedContent()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $this->htmlContent = $response;
    }

    private function readJsonPattern()
    {
        preg_match('/{"product":(.*)}/', $this->htmlContent, $matches);
        $cleanTags = strip_tags($matches[0]);
        $decodedJson = json_decode($cleanTags);

        $this->json = $decodedJson;
    }

    public function getName(): string
    {

        return $this->json->product->name;
    }

    public function getImageUrl(): string
    {
        return $this->json->product->mediaResources[0]->imageUrl;
    }

    public function getId(): string
    {
        return $this->json->product->productId;
    }

    public function getPrice(): string
    {
        return $this->json->product->currentListing->currentPrice->value;
    }

    public function getCurrency(): string
    {
        return 'TRY';
    }

    public function getRealPrice(): string
    {
        return $this->json->product->marketPrice;
    }


    public function getSellerName(): string
    {
        return $this->json->product->currentListing->merchantName;
    }

    public function getSellerId(): string
    {
        return $this->json->product->currentListing->merchantId;
    }

    public function getSellerLink(): ?string
    {
        return $this->json->product->currentListing->merchantPageUrl ?
            'https://www.hepsiburada.com/'.$this->json->product->currentListing->merchantPageUrl : null;
    }

    /**
     * @throws UnknownProperties
     */
    public function getCompetingVendors(): array
    {
        $vendors = [];
        $otherShops = $this->json->product->otherMerchants;

        foreach ($otherShops as $otherShop) {

            $productUrl = 'https://www.trendyol.com' . $otherShop->url;

            $realPrice = getAmount($otherShop->price->originalPrice->value);
            $sellingPrice = getAmount($otherShop->price->sellingPrice->value);
            $price = getAmount($otherShop->price->discountedPrice->value);
            $sellerShopUrl = 'https://www.trendyol.com/sr?mid=' . $otherShop->merchant->id;
            $sellerId = $otherShop->merchant->id;
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
