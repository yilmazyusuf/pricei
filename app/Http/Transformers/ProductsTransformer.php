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
    public function transform(Products $products): array
    {

        return [
            'id' => $products->id,
            'name' => $products->name,
            'imageUrl' => "<img src='{$products->imageUrl}' width='50'>",
            'realPrice' => $products->realPrice. ' TL',
            'price' => $products->price. ' TL',
            'changeRatio' => '<p class="text-success"><i class="nav-icon i-Up"></i> 20 % </p>
                    <h4 class="text-danger"><i class="nav-icon i-Down"></i></h4>
                    <h4 class="text-warning"><i class="nav-icon i-Circular-Point"></i></h4>
                    <h4 class=""><i class="nav-icon i-Sand-watch"></i></h4>
                    ',
            'changeDiff' => '<p class="text-success"><i class="nav-icon i-Up"></i> 20 % </p>
                    <h4 class="text-danger"><i class="nav-icon i-Down"></i></h4>
                    <h4 class="text-warning"><i class="nav-icon i-Circular-Point"></i></h4>
                    <h4 class=""><i class="nav-icon i-Sand-watch"></i></h4>
                    ',
            'updated_at' => date('d/m/Y H:i',strtotime($products->updated_at)),
            'urls' => [
                'edit' => '',
                'destroy' => ''
            ],
            'platform' => [
                'name' => $products->platform->name ?? null
            ],

        ];
    }
}
