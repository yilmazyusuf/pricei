<?php

namespace App\Scraper\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class ScrapedProductPrice extends DataTransferObject
{
    public float $price;
    public ?float $realPrice;
    public ?float $sellingPrice;


}
