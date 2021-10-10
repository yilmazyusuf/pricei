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
    #[ArrayShape(['id' => "int", 'name' => "string", 'parent' => "string"])]
    public function transform(ProductCategories $productCategories): array
    {

        return [
            'id' => $productCategories->id,
            'name' => $productCategories->name,
            'parent' => [
                'name' => $productCategories->parent->name ?? null
            ],

        ];
    }
}
