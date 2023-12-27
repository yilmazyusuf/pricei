<?php

namespace App\Scraper\Adapters\Contracts;

interface HasSellingPrice
{
    public function getSellingPrice(): string;
}
