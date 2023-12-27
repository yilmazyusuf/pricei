<?php

namespace App\Scraper\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class ScrapedProductSeller extends DataTransferObject
{
    public ?string $name;
    public ?string $id;
    public ?string $link;


}
