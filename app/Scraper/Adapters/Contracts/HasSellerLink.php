<?php

namespace App\Scraper\Adapters\Contracts;

interface HasSellerLink
{
    public function getSellerLink(): ?string;
}
