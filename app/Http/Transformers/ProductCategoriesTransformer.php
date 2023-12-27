<?php

namespace App\Http\Transformers;

use App\Models\ProductCategories;
use JetBrains\PhpStorm\ArrayShape;
use League\Fractal\TransformerAbstract;

class ProductCategoriesTransformer extends TransformerAbstract
{

    /**
     *
     * @param ProductCategories $productCategories
     * @return  array
     */
    public function transform(ProductCategories $productCategories): array
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
