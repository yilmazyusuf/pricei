<?php

namespace App\Scraper\Adapters;

interface HasRealPrice
{
    public function getRealPrice(): string;
}
