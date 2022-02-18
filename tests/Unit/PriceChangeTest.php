<?php

namespace Tests\Unit;

use App\Models\PriceHistories;
use App\Models\Products;
use Tests\CreatesApplication;
use Tests\TestCase;

class PriceChangeTest extends TestCase
{
    use CreatesApplication;

    //use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_price_last_increased()
    {
        $priceList = [
            10, 10, 15, 20, 25,30,30,35,35,35,40,50,50,50,55,60
        ];
        $prices = PriceHistories::factory()
            ->count(count($priceList))
            ->sequence(fn ($sequence) => [
                'price' => $priceList[$sequence->index],
                'trackedDate' => now()->subDays((count($priceList) - $sequence->index - 1)),

            ])
            ->create();

        $product = Products::query()->find(1);
        //dd($product->priceHistory()->orderBy('id', 'desc')->skip(1)->first());
    }
}
