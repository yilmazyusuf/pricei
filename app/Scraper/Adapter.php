<?php

namespace App\Scraper;

use voku\helper\HtmlDomParser;

abstract class Adapter
{
    public function __construct(
        protected HtmlDomParser $html
    ) {

    }
    abstract public function getName();
    abstract public function getId();
    abstract public function getImageUrl();
    abstract public function getPrice();
}
