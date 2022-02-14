<?php

namespace App\Scraper\Adapters;

use App\Scraper\Adapter;
use App\Scraper\Adapters\Contracts\HasCompetingVendors;
use App\Scraper\Adapters\Contracts\HasRealPrice;
use App\Scraper\Adapters\Contracts\HasSellerId;
use App\Scraper\Adapters\Contracts\HasSellerLink;
use App\Scraper\Adapters\Contracts\HasSellerName;
use App\Scraper\Dto\ScrapedProduct;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class HepsiBuradaAdapter extends Adapter implements
    HasSellerName,
    HasRealPrice,
    HasSellerId,
    HasSellerLink,
    HasCompetingVendors
{
    public function scrape()
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
        $this->readJsonPattern();
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
            'https://www.hepsiburada.com/' . $this->json->product->currentListing->merchantPageUrl : null;
    }

    /**
     * @throws UnknownProperties
     */
    public function getCompetingVendors(): array
    {
        $vendors = [];
        $otherShops = $this->json->product->listings;
        unset($otherShops[0]);
        foreach ($otherShops as $otherShop) {

            $productUrl = 'https://www.hepsiburada.com' . $otherShop->merchantVariantUrl;

            $realPrice = getAmount($otherShop->originalPriceText);
            $price = getAmount($otherShop->sortPriceText);
            $sellerShopUrl = 'https://www.hepsiburada.com' . $otherShop->merchantPageUrl;
            $sellerId = $otherShop->merchantId;
            $sellerName = $otherShop->merchantName;

            $competingVendor = new ScrapedProduct(
                url: $productUrl,
                currency: 'TRY',
                price: [
                    'price' => getAmount($price),
                    'realPrice' => getAmount($realPrice)
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
