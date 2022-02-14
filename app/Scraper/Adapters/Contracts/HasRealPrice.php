<?php

namespace App\Scraper\Adapters\Contracts;

interface HasRealPrice
{
    public function getRealPrice(): string;
}
