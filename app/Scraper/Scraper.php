<?php

namespace App\Scraper;

use App\Scraper\Adapters\HasCompetingVendors;
use App\Scraper\Adapters\HasRealPrice;
use App\Scraper\Adapters\HasSellerId;
use App\Scraper\Adapters\HasSellerLink;
use App\Scraper\Adapters\HasSellerName;
use App\Scraper\Adapters\HasSellingPrice;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class Scraper
{
    public function __construct(private Adapter $adapter)
    {
    }

    public function scrape(): self
    {
        $this->adapter->scrape();
        return $this;
    }

    /**
     * @return ScrapedProduct
     * @throws UnknownProperties
     */
    public function buildProductDto(): ScrapedProduct
    {
        $dtoParams = [];
        $dtoParams['url'] = $this->adapter->getUrl();
        $dtoParams['name'] = $this->adapter->getName();
        $dtoParams['productId'] = $this->adapter->getId();
        $dtoParams['currency'] = $this->adapter->getCurrency();
        $dtoParams['imageUrl'] = $this->adapter->getImageUrl();
        $dtoParams['price']['price'] = getAmount($this->adapter->getPrice());

        if ($this->adapter instanceof HasRealPrice) {
            $dtoParams['price']['realPrice'] = getAmount($this->adapter->getRealPrice());
        }

        if ($this->adapter instanceof HasSellingPrice) {
            $dtoParams['price']['sellingPrice'] = getAmount($this->adapter->getSellingPrice());
        }

        if ($this->adapter instanceof HasSellerId) {
            $dtoParams['seller']['id'] = $this->adapter->getSellerId();
        }

        if ($this->adapter instanceof HasSellerLink) {
            $dtoParams['seller']['link'] = $this->adapter->getSellerLink();
        }

        if ($this->adapter instanceof HasSellerName) {
            $dtoParams['seller']['name'] = $this->adapter->getSellerName();
        }

        if ($this->adapter instanceof HasCompetingVendors) {
            $dtoParams['competingVendors'] = $this->adapter->getCompetingVendors();
        }

        return new ScrapedProduct($dtoParams);
    }
}
