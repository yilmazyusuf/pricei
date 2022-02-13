<?php

namespace App\Scraper;

use Spatie\DataTransferObject\DataTransferObject;

class ScrapedProduct extends DataTransferObject
{

    public ?string $name;
    public ?string $url;
    public ?string $productId;
    public ?string $currency;

    public ?ScrapedProductSeller $seller;
    public ?string $imageUrl;
    public ScrapedProductPrice $price;
    /** @var ScrapedProduct[] */
    public ?array $competingVendors;
}
