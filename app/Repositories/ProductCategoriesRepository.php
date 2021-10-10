<?php

namespace App\Repositories;

use App\Models\ProductCategories;
use Illuminate\Database\Eloquent\Collection;

class ProductCategoriesRepository
{

    public static function get() : Collection
    {
        return ProductCategories::query()
            ->with('parent')
            ->orderBy('name', 'asc')
            ->get();
    }
}
