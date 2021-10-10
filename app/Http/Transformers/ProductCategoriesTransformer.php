<?php

namespace App\Http\Transformers;

use App\Models\ProductCategories;
use League\Fractal\TransformerAbstract;

class ProductCategoriesTransformer extends TransformerAbstract {

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
            'parent' => $productCategories->name,
        ];
    }
}
