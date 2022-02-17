<?php

namespace App\Http\Filters;

use App\Filter\Filter;

class ProductsFilter extends Filter
{

    public function filters(): array
    {
        return [
            [
                FILTER::PARAM_NAME => 'isJobActive',
                FILTER::PARAM_METHOD => FILTER::METHOD_EQUAL,
                FILTER::PARAM_RULES => 'required|numeric',
            ],
            [
                FILTER::PARAM_NAME => 'platform_id',
                FILTER::PARAM_METHOD => FILTER::METHOD_WHEREIN,
                FILTER::PARAM_RULES => 'required',
                FILTER::PARAM_FORMAT_VALUE => function ($value) {

                    return implode(',', $value);
                },
            ]


        ];
    }
}
