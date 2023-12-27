<?php

namespace App\Scraper\Adapters;

use App\Scraper\Adapter;
use App\Scraper\Adapters\Contracts\HasCompetingVendors;
use App\Scraper\Adapters\Contracts\HasRealPrice;
use App\Scraper\Adapters\Contracts\HasSellerName;
use App\Scraper\Dto\ScrapedProduct;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use voku\helper\HtmlDomParser;

class N11Adapter extends Adapter implements
    HasSellerName,
    HasRealPrice,
    HasCompetingVendors
{


    public function scrape()
    {
        $this->html =  HtmlDomParser::file_get_html($this->url);
        $this->htmlContent =  $this->html->html();
        $this->readJsonPattern();
    }


    private function readJsonPattern()
    {
        //preg_match('/dataLayer.push\({"pBrand"(.*)}\)/', $this->htmlContent, $matches, PREG_OFFSET_CAPTURE);
        preg_match('/var obj = (.*);/', $this->htmlContent, $matches, PREG_OFFSET_CAPTURE);
        $decodedJson = json_decode($matches[1][0]);
        $this->json = $decodedJson;
    }

    public function getName(): string
    {
        return $this->json->title;
    }

    public function getImageUrl(): string
    {
        return $this->json->pImageUrl;
    }

    public function getId(): string
    {
        return $this->json->pId;
    }

    public function getPrice(): string
    {
        return $this->json->pDiscountedPrice;
    }

    public function getRealPrice(): string
    {
        return $this->json->pOriginalPrice;
    }

    public function getCurrency(): string
    {
        return 'TRY';
    }

    public function getSellerName(): string
    {
        return $this->json->sellerNickname;
    }

    /**
     * @throws UnknownProperties
     */
    public function getCompetingVendors(): array
    {
        $vendors = [];
        $otherShops = $this->html->find('div.unf-cmp-body');
        foreach ($otherShops as $otherShop) {
            $otherShopTag = $otherShop->findOne('a.b-n-title');
            $realPrice = getAmount($otherShop->findOne('span.b-p-old')->innertext);
            $price = getAmount($otherShop->findOne('span.b-p-new')->innertext);
            $sellerShopUrl = $otherShopTag->getAttribute('href');
            $sellerName = $otherShopTag->getAttribute('title');
            $vendorUrl = $otherShop->findOne('input.sellerUrl')->getAttribute('value');

            $competingVendor = new ScrapedProduct(
                url: $vendorUrl,
                price: [
                    'price' => getAmount($price),
                    'realPrice' => getAmount($realPrice)
                ],
                seller: [
                    'name' => $sellerName,
                    'link' => $sellerShopUrl,
                ],
            );

            $vendors[] = $competingVendor;
        }
        return $vendors;
    }
}
