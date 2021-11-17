<?php

namespace App\Http\Transformers;

use App\Models\ProductCategories;
use App\Models\Products;
use JetBrains\PhpStorm\ArrayShape;
use League\Fractal\TransformerAbstract;

class ProductsTransformer extends TransformerAbstract
{

    /**
     *
     * @param ProductCategories $productCategories
     * @return  array
     */
    public function transform(Products $productCategories): array
    {

        return [
            'id' => $productCategories->id,
            'name' => $productCategories->name,
            'urls' => [
                'edit' => route('products_categories.edit',$productCategories->id),
                'destroy' => route('products_categories.destroy',$productCategories->id)
            ],
            'parent' => [
                'name' => $productCategories->parent->name ?? null
            ],

        ];
    }
}
