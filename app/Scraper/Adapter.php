<?php

namespace App\Scraper;

use voku\helper\HtmlDomParser;

abstract class Adapter
{
    protected object $json;
    protected HtmlDomParser $html;
    protected string $htmlContent;

    public function __construct(
        protected string $url
    ) {

    }

    public function getUrl(): string
    {
        return $this->url;
    }

    abstract public function getName();

    abstract public function getId();

    abstract public function getImageUrl();

    abstract public function getPrice();

    abstract public function getCurrency();

    abstract public function scrape();
}
