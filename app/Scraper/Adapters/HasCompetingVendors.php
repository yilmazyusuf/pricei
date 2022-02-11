<?php

namespace App\Scraper\Adapters;

interface HasCompetingVendors
{
    public function getCompetingVendors(): array;
}
