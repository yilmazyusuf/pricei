<?php

namespace App\Http\Filters;

use App\Filter\Filter;
use Illuminate\Support\Carbon;

class PriceHistoryFilter extends Filter
{

    public function filters(): array
    {
        return [
            [
                FILTER::PARAM_NAME => 'productPriceChartStart',
                FILTER::PARAM_PREFIX => 'trackedDate',
                FILTER::PARAM_METHOD => FILTER::METHOD_GREATER_THAN,
                FILTER::PARAM_RULES => 'required|date_format:d.m.Y',
                FILTER::PARAM_FORMAT_VALUE => function ($value) {
                    return Carbon::createFromFormat('d.m.Y', $value)->format('Y-m-d');
                }
            ],
            [
                FILTER::PARAM_NAME => 'productPriceChartEnd',
                FILTER::PARAM_PREFIX => 'trackedDate',
                FILTER::PARAM_METHOD => FILTER::METHOD_SMALLER_THAN,
                FILTER::PARAM_RULES => 'required|date_format:d.m.Y',
                FILTER::PARAM_FORMAT_VALUE => function ($value) {
                    return Carbon::createFromFormat('d.m.Y', $value)->format('Y-m-d');
                }
            ]


        ];
    }
}
