<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PriceHistoriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'products_id' => 1,
            'product_vendors_id' => 1,
            'price' => 20,
            'realPrice' => 10,
            'trackedDate' => date('Y-m-d')
        ];
    }

}
