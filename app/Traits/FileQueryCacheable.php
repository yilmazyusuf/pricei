<?php

namespace App\Traits;

use Rennokki\QueryCache\Traits\QueryCacheable;

trait FileQueryCacheable {

    use QueryCacheable;

    protected static bool $flushCacheOnUpdate = true;

    protected function getCacheBaseTags() : array
    {
        return [];
    }

}
