<?php

namespace App\Http\Transformers;

use App\Models\PriceHistories;
use League\Fractal\TransformerAbstract;

class ProductsPriceHistoryTransformer extends TransformerAbstract
{

    /**
     *
     * @param PriceHistories $histories
     * @return  array
     */
    public function transform(PriceHistories $histories): array
    {

        return [
            'trackedDate' => $histories->trackedDate,
            'realPrice' => priceWithCurrency($histories->realPrice),
            'price' => priceWithCurrency($histories->price),
            'changeDiff' => $histories->priceDiffWithIcon,
            'changePercent' => $histories->priceDiffPercentWithIcon,
        ];

    }
}
