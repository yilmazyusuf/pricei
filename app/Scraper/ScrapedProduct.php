<?php

namespace App\Scraper;

use Spatie\DataTransferObject\DataTransferObject;

class ScrapedProduct extends DataTransferObject
{

    public ?string $name;
    public ?string $url;
    public ?int $productId;
    public ?string $sku;
    public ?ScrapedProductSeller $seller;
    public ?string $imageUrl;
    public ScrapedProductPrice $price;
    /** @var ScrapedProduct[] */
    public ?array $competingVendors;


}
