<?php

use Illuminate\Support\Facades\Schema;

if (!function_exists('settings')) {
    /**
     * @param null $key
     * @return string|null
     */
    function settings($key = null)
    {
        if (Schema::hasTable('settings')) {
            $settingValue = \Illuminate\Support\Facades\DB::table('settings')
                ->where('key', $key)
                ->pluck('value')
                ->first();

            return $settingValue;
        }

        return false;
    }

    if (!function_exists('parseUrlHost')) {
        function parseUrlHost(string $url): string
        {
            $url = parse_url($url);
            $host = $url['host'];
            return str_replace('www.', '', $host);
        }
    }
    if (!function_exists('getAmount')) {
        function getAmount($money)
        {
            $cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
            $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);

            $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

            $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
            $removedThousandSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '', $stringWithCommaOrDot);

            return (float)str_replace(',', '.', $removedThousandSeparator);
        }
    }

    if (!function_exists('priceDiffPercent')) {
        function priceDiffPercent(float $priceA, float $priceB): float|int
        {
            return ($priceB - $priceA) * 100 / $priceA;
        }
    }


    if (!function_exists('upDownIcon')) {
        function upDownIcon(float $value): string
        {
            if ($value > 0) {
                return '<i class="i-Up1 text-14 text-danger font-weight-700"></i>';
            }
            if ($value < 0) {
                return '<i class="i-Down1 text-14 text-success font-weight-700"></i>';
            }
            return '';

        }

    }

    if (!function_exists('priceWithCurrency')) {
        function priceWithCurrency(?float $price): string
        {
            if (!$price) {
                return '';
            }
            return $price. ' TL';

        }

    }

}
