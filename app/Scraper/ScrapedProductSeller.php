<?php

namespace App\Scraper;

use Spatie\DataTransferObject\DataTransferObject;

class ScrapedProductSeller extends DataTransferObject
{
    public ?string $name;
    public ?string $id;
    public ?string $link;


}
