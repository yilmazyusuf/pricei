<?php

namespace App\Scraper\Adapters;

interface HasSellerId
{
    public function getSellerId(): string;
}
