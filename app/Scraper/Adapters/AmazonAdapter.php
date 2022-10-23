<?php

namespace App\Scraper\Adapters;

use App\Scraper\Adapter;
use App\Scraper\Adapters\Contracts\HasCompetingVendors;
use App\Scraper\Adapters\Contracts\HasSellerLink;
use App\Scraper\Adapters\Contracts\HasSellerName;
use App\Scraper\Dto\ScrapedProduct;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use voku\helper\HtmlDomParser;
use voku\helper\SimpleHtmlDom;

class AmazonAdapter extends Adapter implements
    HasSellerName,
    HasSellerLink,
    HasCompetingVendors
{
    private string $id;
    private bool|SimpleHtmlDom $pinnedHasPrice;

    public function scrape()
    {
        $re = '/\/dp\/([^\/]*)[\/|?]/m';
        preg_match_all($re, $this->url, $matches, PREG_SET_ORDER, 0);

        $this->id = $matches[0][1];
        $modalUrl = 'https://www.amazon.com.tr/gp/product/ajax/ref=auto_load_aod?asin=' . $this->getId() . '&pc=dp&experienceId=aodAjaxMain';
        $this->html = HtmlDomParser::file_get_html($modalUrl);
        $this->htmlContent = $this->html->html();

        $this->pinnedHasPrice = $this->pinnedHasPrice();

    }

    public function getName(): string
    {
        return $this->html->findOne('h5#aod-asin-title-text')->innerText();
    }

    public function getImageUrl(): string
    {
        return $this->html->findOne('img#aod-asin-image-id')->getAttribute('src');
    }

    public function getId(): string
    {
        return $this->id;
    }

    private function pinnedHasPrice(): bool|SimpleHtmlDom
    {

        return $this->html->findOne('div#aod-pinned-offer')->findOneOrFalse('span.a-offscreen');
    }

    public function getPrice(): string
    {
        if ($this->pinnedHasPrice === false) {
            return $this->html->findOne('div#aod-offer')->findOne('span.a-offscreen')->innerText();
        }
        return $this->pinnedHasPrice->innerText();
    }

    public function getCurrency(): string
    {
        return 'TRY';
    }


    public function getSellerName(): string
    {
        $soldBy = $this->html->findOne('div#aod-offer-soldBy');
        $hasSellerLink = $soldBy->findOneOrFalse('a');
        if ($hasSellerLink) {
            $sellerName = $hasSellerLink->innerText();
        } else {
            $sellerName = $soldBy->find('span')[1]->innerText();
        }

        return $sellerName;
    }

    public function getSellerLink(): string
    {
        return $this->html->findOne('div#aod-offer-soldBy')->findOne('a')->getAttribute('href');
    }

    /**
     * @throws UnknownProperties
     */
    public function getCompetingVendors(): array
    {
        $vendors = [];
        $otherShops = $this->html->findOne('div#aod-offer-list')->find('div#aod-offer');
        //Fiyatı olmayan ana ürün kabul ediliyor, fiyat yok ise birinciyi ekleme



        foreach ($otherShops as $otherShop) {
            if ($this->pinnedHasPrice === false && count($vendors) == 0) {
                continue;
            }
            $price = getAmount($otherShop->findOne('span.a-offscreen'));

            $sellerShopUrl = $otherShop->findOne('div#aod-offer-soldBy')->findOne('a')->getAttribute('href');
            $soldBy = $otherShop->findOne('div#aod-offer-soldBy');
            $hasSellerLink = $soldBy->findOneOrFalse('a');
            if ($hasSellerLink) {
                $sellerName = $hasSellerLink->innerText();
            } else {
                $sellerName = $soldBy->find('span')[1]->innerText();
            }

            $competingVendor = new ScrapedProduct(
                url: null,
                currency: 'TRY',
                price: [
                    'price' => getAmount($price),
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
