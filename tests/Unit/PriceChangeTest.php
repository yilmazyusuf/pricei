<?php

namespace Tests\Unit;

use App\Models\Platforms;
use App\Models\PriceHistories;
use App\Models\Products;
use App\Repositories\ProductsRepository;
use App\Scraper\Dto\ScrapedProduct;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\CreatesApplication;
use Tests\TestCase;

class PriceChangeTest extends TestCase
{
    use CreatesApplication;
    use WithFaker;

    //use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_price_last_increased()
    {
        $priceList = [
            10, 10, 15, 20, 25, 30, 30, 35, 35, 35, 40, 50, 50, 50, 55, 60
        ];
        $prices = PriceHistories::factory()
            ->count(count($priceList))
            ->sequence(fn($sequence) => [
                'price' => $priceList[$sequence->index],
                'trackedDate' => now()->subDays((count($priceList) - $sequence->index - 1)),

            ])
            ->create();

        $product = Products::query()->find(1);
        //dd($product->priceHistory()->orderBy('id', 'desc')->skip(1)->first());
    }

    public function test_price_history_changed_price_increase()
    {
        $platform = Platforms::factory()->create();
        $shopProductId = $this->faker->uuid();
        $selllerId = $this->faker->uuid();
        $productData = [
            'name' => $this->faker->name(),
            'url' => $this->faker->url(),
            'imageUrl' => $this->faker->url(),
            'currency' => 'TRY',
            'shopProductId' => $shopProductId,
            'price' => [
                'price' => 20,
            ],
            'seller' => [
                'id' => $selllerId
            ],
            'competingVendors' => [

            ]

        ];
        $product = new ScrapedProduct(
            $productData
        );

        ProductsRepository::createOrUpdate($platform, $product, null, now());

        $productData['price']['price'] = 30;
        $product = new ScrapedProduct(
            $productData
        );

        $lastProduct = ProductsRepository::createOrUpdate($platform, $product, null, now()->addDay());
        $lastPrice = PriceHistories::where('products_id', $lastProduct->id)->orderBy('id', 'desc')->first();

        $this->assertEquals($lastPrice->pricePreviousDiff, 10);
        $this->assertEquals($lastPrice->pricePreviousPercentDiff, 50);

    }

    public function test_price_history_changed_price_decrease()
    {
        $platform = Platforms::factory()->create();
        $shopProductId = $this->faker->uuid();
        $selllerId = $this->faker->uuid();
        $vendorSelllerId = $this->faker->uuid();
        $productData = [
            'name' => $this->faker->name(),
            'url' => $this->faker->url(),
            'imageUrl' => $this->faker->url(),
            'currency' => 'TRY',
            'shopProductId' => $shopProductId,
            'price' => [
                'price' => 30,
            ],
            'seller' => [
                'id' => $selllerId
            ],
            'competingVendors' => [
                new ScrapedProduct(['price' => ['price' => 50], 'seller' => ['id' => $vendorSelllerId]])
            ]

        ];
        $product = new ScrapedProduct(
            $productData
        );

        ProductsRepository::createOrUpdate($platform, $product, null, now());

        $productData['price']['price'] = 25;
        $productData['competingVendors'][0] = new ScrapedProduct(['price' => ['price' => 18], 'seller' => ['id' => $vendorSelllerId]]);
        $product = new ScrapedProduct(
            $productData
        );

        $lastProduct = ProductsRepository::createOrUpdate($platform, $product, null, now()->addDay());
        $lastPrice = PriceHistories::where('products_id', $lastProduct->id)->orderBy('id', 'desc')->first();

        $lastVendorPrice = $lastProduct->vendors()->where('sellerId', $vendorSelllerId)->first()->priceHistory()->orderBy('id', 'desc')->first();

        $this->assertEquals($lastPrice->pricePreviousDiff, -5);
        $this->assertEquals($lastPrice->pricePreviousPercentDiff, -16.67);

        $this->assertEquals($lastVendorPrice->pricePreviousDiff, -32);
        $this->assertEquals($lastVendorPrice->pricePreviousPercentDiff, -64);

    }
}
