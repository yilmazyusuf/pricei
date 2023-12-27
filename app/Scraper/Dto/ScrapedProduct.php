<?php

namespace App\Scraper\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class ScrapedProduct extends DataTransferObject
{

    public ?string $name;
    public ?string $url;
    public ?string $shopProductId;
    public ?string $currency;

    public ?ScrapedProductSeller $seller;
    public ?string $imageUrl;
    public ScrapedProductPrice $price;
    /** @var ScrapedProduct[] */
    public ?array $competingVendors;
}
