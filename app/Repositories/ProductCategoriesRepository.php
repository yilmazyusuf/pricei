<?php

namespace App\Repositories;

use App\Models\ProductCategories;
use Illuminate\Database\Eloquent\Collection;

class ProductCategoriesRepository
{

    public static function get() : Collection
    {
        return ProductCategories::query()
            ->orderBy('name', 'asc')
            //->cacheFor(now()->addDays(30))
            ->get();
    }
}
