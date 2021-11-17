<?php

namespace App\Repositories;

use App\Models\ProductCategories;
use App\Models\Products;
use Illuminate\Database\Eloquent\Collection;

class ProductsRepository
{

    public static function get() : Collection
    {
        return Products::query()
            ->orderBy('name', 'asc')
            ->get();
    }
}
