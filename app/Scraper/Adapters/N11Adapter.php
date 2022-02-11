<?php

namespace App\Scraper\Adapters;

use App\Scraper\Adapter;
use App\Scraper\ScrapedProduct;
use voku\helper\HtmlDomParser;

class N11Adapter extends Adapter implements
    HasSellerName,
    HasRealPrice,
    HasCompetingVendors
{
    private HtmlDomParser $priceContent;
    private $json;

    public function __construct(protected HtmlDomParser $html)
    {
        parent::__construct($html);
        $this->readJsonPattern();
    }


    private function readJsonPattern()
    {
        preg_match('/dataLayer.push\({"pBrand"(.*)}\)/', $this->html->html(), $matches, PREG_OFFSET_CAPTURE);
        $jsonString = '{"pBrand"' . $matches[1][0] . '}';
        $decodedJson = json_decode($jsonString);
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

    public function getSellerName(): string
    {
        return $this->json->sellerNickname;
    }

    public function getPrice(): string
    {
        return $this->json->pDiscountedPrice;

    }

    public function getRealPrice(): string
    {
        return $this->json->pOriginalPrice;
    }


    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
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
                    'shopUrl' => $sellerShopUrl,
                ],
            );

            $vendors[] = $competingVendor;
        }
        return $vendors;
    }
}
