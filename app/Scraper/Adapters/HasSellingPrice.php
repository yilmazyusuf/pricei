<?php

namespace App\Scraper\Adapters;

interface HasSellingPrice
{
    public function getSellingPrice(): string;
}
