<?php

namespace App\Scraper\Adapters;

interface HasSellerLink
{
    public function getSellerLink(): ?string;
}
