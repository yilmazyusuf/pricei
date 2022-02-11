<?php

namespace App\Scraper;

use Spatie\DataTransferObject\DataTransferObject;

class ScrapedProductSeller extends DataTransferObject
{

    public ?int $id;
    public ?string $name;
    public ?string $shopUrl;


}
