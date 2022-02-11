<?php

namespace App\Scraper;

use App\Repositories\PlatformsRepository;

class Scraper
{
    /**
     * @param string $url
     * @param PlatformsRepository $platform
     */
    public function __construct(
        private string              $url,
        private PlatformsRepository $platform
    ) {
    }

    public function scrape()
    {

    }
}
