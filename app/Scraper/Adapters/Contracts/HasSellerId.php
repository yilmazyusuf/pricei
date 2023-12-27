<?php

namespace App\Scraper\Adapters\Contracts;

interface HasSellerId
{
    public function getSellerId(): string;
}
