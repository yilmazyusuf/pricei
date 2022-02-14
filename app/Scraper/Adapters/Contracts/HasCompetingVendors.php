<?php

namespace App\Scraper\Adapters\Contracts;

interface HasCompetingVendors
{
    public function getCompetingVendors(): array;
}
