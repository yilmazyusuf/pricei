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


}
