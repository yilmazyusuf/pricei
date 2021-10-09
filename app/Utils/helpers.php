<?php

use Illuminate\Support\Facades\Schema;

if (!function_exists('settings')) {
    /**
     * @param null $key
     * @param null $default
     *
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

}
