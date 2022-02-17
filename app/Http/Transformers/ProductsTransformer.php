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
        $isJobActive = $products->isJobActive ? 'checked' :'';
        return [
            'id' => $products->id,
            'name' => $products->name,
            'imageUrl' => "<img src='{$products->imageUrl}' width='50'>",
            'realPrice' => $products->realPrice. ' TL',
            'price' => $products->price. ' TL',
            'changeRatio' => '',
            'changeDiff' => '',
            'updated_at' => date('d.m.Y  H:i', strtotime($products->updated_at)),
            'urls' => [
                'destroy' => route('products.destroy', $products->id)
            ],
            'platform' => [
                'name' => $products->platform->name ?? null
            ],
            'status' => ' <input class="switch-size" data-size="xs" data-on="Aktif" data-off="Pasif" '.$isJobActive.' type="checkbox" data-content="'.$products->id.'" id="pr_'.$products->id.'">',
            'actions' => view('partials.datatable_action_buttons_products',['product' => $products])->render()

        ];

    }
}
