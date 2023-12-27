<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert(
            [
                [
                    'user_id' => 1,
                    'platform_id' => 1,
                    'name' => 'Reeder P13 Blue 16 GB 3 GB RAM (Reeder Türkiye Garantili)',
                    'url' => 'https://www.hepsiburada.com/reeder-p13-blue-16-gb-3-gb-ram-reeder-turkiye-garantili-p-HBV00000KJI11',
                    'shopProductId' => 'HB00000KJI10',
                    'imageUrl' => 'https://productimages.hepsiburada.net/s/103/500/110000046587853.jpg',
                    'price' => 1649,
                    'realPrice' => 1329,
                    'sellingPrice' => null,
                    'currency' => 'TRY',
                    'sellerId' => '7356bb48-f012-4322-ad84-ef7436cc9aa1',
                    'sellerName' => 'KimSatar',
                    'sellerShopLink' => 'https://www.hepsiburada.com//magaza/kimsatar',
                    'isJobLocked' => false,
                    'isJobActive' => true,
                    'jobTries' => 0,
                    'lasJobStatus' => null,
                    'lasJobErrorMessage' => null,
                    'lastJobDate' => null,
                    'nextJobDate' => now()->addHours(12),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => 1,
                    'platform_id' => 3,
                    'name' => 'Lenovo V14-ADA 82C600GQTX Athlon Gold 3150U 4 GB 256 GB SSD 14" Free Dos Dizüstü Bilgisayar',
                    'url' => 'https://www.n11.com/urun/lenovo-v14-ada-82c600gqtx-athlon-gold-3150u-4-gb-256-gb-ssd-14-free-dos-dizustu-bilgisayar-1747850?magaza=victory',
                    'shopProductId' => '499739699',
                    'imageUrl' => 'https://n11scdn.akamaized.net/a1/640/elektronik/dizustu-bilgisayar/lenovo-v14-82c600gqtx-athlon-gold-3150u-4-gb-256-gb-ssd-14-free-dos-dizustu-bilgisayar__1358374695258320.jpg',
                    'price' => 10873.89,
                    'realPrice' => 10873.89,
                    'sellingPrice' => null,
                    'currency' => 'TRY',
                    'sellerId' => null,
                    'sellerName' => 'victory',
                    'sellerShopLink' => null,
                    'isJobLocked' => false,
                    'isJobActive' => true,
                    'jobTries' => 0,
                    'lasJobStatus' => null,
                    'lasJobErrorMessage' => null,
                    'lastJobDate' => null,
                    'nextJobDate' => now()->addHours(12),
                    'updated_at' => now(),
                ]
            ]
        );
        DB::table('product_vendors')->insert(
            [
                [
                    'products_id' => 1,
                    'url' => 'https://www.n11.com/urun/lenovo-v14-ada-82c600gqtx-athlon-gold-3150u-4-gb-256-gb-ssd-14-free-dos-dizustu-bilgisayar-1747850?magaza=pcyazici',
                    'shopProductId' => null,
                    'price' => 8299,
                    'realPrice' => 0,
                    'sellerId' => null,
                    'sellerName' => 'pcyazıcı',
                    'sellerShopLink' => 'https://www.n11.com/magaza/pcyazici',
                    'isVendorActive' => true
                ],
                [
                    'products_id' => 1,
                    'url' => 'https://www.n11.com/urun/lenovo-v14-ada-82c600gqtx-athlon-gold-3150u-4-gb-256-gb-ssd-14-free-dos-dizustu-bilgisayar-1747850?magaza=birnumara',
                    'shopProductId' => null,
                    'price' => 10269,
                    'realPrice' => 0,
                    'sellerId' => null,
                    'sellerName' => 'birnumara',
                    'sellerShopLink' => 'https://www.n11.com/magaza/birnumara',
                    'isVendorActive' => true
                ],
                [
                    'products_id' => 2,
                    'url' => 'https://www.hepsiburada.com/reeder-p13-blue-16-gb-3-gb-ram-reeder-turkiye-garantili-p-HBV00000KJI11?magaza=GREEN%20.%20BLUE',
                    'shopProductId' => null,
                    'price' => 1833.5,
                    'realPrice' => 1930,
                    'sellerId' => 'd5b0e344-650f-4389-b05a-39eaa866d6e0',
                    'sellerName' => 'GREEN . BLUE',
                    'sellerShopLink' => 'https://www.hepsiburada.com/magaza/green-blue',
                    'isVendorActive' => true
                ],
                [
                    'products_id' => 2,
                    'url' => 'https://www.hepsiburada.com/reeder-p13-blue-16-gb-3-gb-ram-reeder-turkiye-garantili-p-HBV00000KJI11?magaza=misevim-avm',
                    'shopProductId' => null,
                    'price' => 1851.55,
                    'realPrice' => 1949,
                    'sellerId' => '8079a03e-b361-43f5-828d-dbd07c5b6ce2',
                    'sellerName' => 'misevim-avm',
                    'sellerShopLink' => 'https://www.hepsiburada.com/magaza/misevim-avm',
                    'isVendorActive' => true
                ],
                [
                    'products_id' => 2,
                    'url' => 'https://www.hepsiburada.com/reeder-p13-blue-16-gb-3-gb-ram-reeder-turkiye-garantili-p-HBV00000KJI11?magaza=BA%C5%9EARAN%20T%C4%B0CARET',
                    'shopProductId' => null,
                    'price' => 1899.05,
                    'realPrice' => 1999,
                    'sellerId' => '4ef865b2-d668-481f-a87d-4627d25ba673',
                    'sellerName' => 'BAŞARAN TİCARET',
                    'sellerShopLink' => 'https://www.hepsiburada.com/magaza/basaran-ticaret',
                    'isVendorActive' => true
                ],
                [
                    'products_id' => 2,
                    'url' => 'https://www.hepsiburada.com/reeder-p13-blue-16-gb-3-gb-ram-reeder-turkiye-garantili-p-HBV00000KJI11?magaza=CEP%20TEKNOLOJ%C4%B0M',
                    'shopProductId' => null,
                    'price' => 1899.05,
                    'realPrice' => 1999,
                    'sellerId' => '3887e362-a4b5-4ad7-abda-b3ff2bd81f3e',
                    'sellerName' => 'CEP TEKNOLOJİM',
                    'sellerShopLink' => 'https://www.hepsiburada.com/magaza/cep-teknolojim',
                    'isVendorActive' => true
                ],
                [
                    'products_id' => 2,
                    'url' => 'https://www.hepsiburada.com/reeder-p13-blue-16-gb-3-gb-ram-reeder-turkiye-garantili-p-HBV00000KJI11?magaza=Mert%20Teknoloji%20Market',
                    'shopProductId' => null,
                    'price' => 2089.05,
                    'realPrice' => 2199,
                    'sellerId' => 'f43894af-5ed4-4642-a87a-dcaeb8986241',
                    'sellerName' => 'Mert Teknoloji Market',
                    'sellerShopLink' => 'https://www.hepsiburada.com/magaza/mert-teknoloji-market',
                    'isVendorActive' => true
                ],
                [
                    'products_id' => 2,
                    'url' => 'https://www.hepsiburada.com/reeder-p13-blue-16-gb-3-gb-ram-reeder-turkiye-garantili-p-HBV00000KJI11?magaza=ottomannwatch',
                    'shopProductId' => null,
                    'price' => 3315.4,
                    'realPrice' => 3489.89,
                    'sellerId' => '0a238099-61d0-4e04-8498-e1e768719365',
                    'sellerName' => 'ottomannwatch',
                    'sellerShopLink' => 'https://www.hepsiburada.com/magaza/ottomannwatch',
                    'isVendorActive' => true
                ]
            ],
        );

        DB::table('price_histories')->insert(

            [
                [
                    'products_id' => 1,
                    'product_vendors_id' => null,
                    'price' => 10873.89,
                    'realPrice' => 10873.89,
                    'trackedDate' => Carbon::now(),
                ],
                [
                    'products_id' => 2,
                    'product_vendors_id' => null,
                    'price' => 1649,
                    'realPrice' => 1329,
                    'trackedDate' => Carbon::now(),
                ],
                [
                    'products_id' => null,
                    'product_vendors_id' => 1,
                    'price' => 8299,
                    'realPrice' => 0,
                    'trackedDate' => Carbon::now(),
                ],
                [
                    'products_id' => null,
                    'product_vendors_id' => 2,
                    'price' => 10269,
                    'realPrice' => 0,
                    'trackedDate' => Carbon::now(),
                ],
                [
                    'products_id' => null,
                    'product_vendors_id' => 3,
                    'price' => 1833.5,
                    'realPrice' => 1930,
                    'trackedDate' => Carbon::now(),
                ],
                [
                    'products_id' => null,
                    'product_vendors_id' => 4,
                    'price' => 1851.55,
                    'realPrice' => 1949,
                    'trackedDate' => Carbon::now(),
                ],
                [
                    'products_id' => null,
                    'product_vendors_id' => 5,
                    'price' => 1899.05,
                    'realPrice' => 1999,
                    'trackedDate' => Carbon::now(),
                ],
                [
                    'products_id' => null,
                    'product_vendors_id' => 6,
                    'price' => 1899.05,
                    'realPrice' => 1999,
                    'trackedDate' => Carbon::now(),
                ],
                [
                    'products_id' => null,
                    'product_vendors_id' => 7,
                    'price' => 2089.05,
                    'realPrice' => 2199,
                    'trackedDate' => Carbon::now(),
                ],
                [
                    'products_id' => null,
                    'product_vendors_id' => 8,
                    'price' => 3315.4,
                    'realPrice' => 3489.89,
                    'trackedDate' => Carbon::now(),
                ]
            ]

        );

        $priceOld = 10873.89;

        for ($day = 1; $day <= 30; $day++) {


            $priceNew = $priceOld + rand(-200, 500);
            $priceNewReal = $priceNew + rand(100, 200);
            DB::table('price_histories')->insert(
                [
                    'products_id' => 2,
                    'product_vendors_id' => null,
                    'price' => $priceNew,
                    'realPrice' => $priceNewReal,
                    'pricePreviousDiff' => ($priceNew - $priceOld),
                    'pricePreviousPercentDiff' => priceDiffPercent($priceOld, $priceNew),
                    'trackedDate' => Carbon::now()->addDays($day),
                ]
            );
            $vendorPriceOld = 11873.89;
            for ($vendors = 3; $vendors <= 8; $vendors++) {
                $vendorPriceNew = $vendorPriceOld + rand(-200, 500);
                $vendorPriceNewReal = $vendorPriceNew + rand(100, 200);
                DB::table('price_histories')->insert(
                    [
                        'products_id' => null,
                        'product_vendors_id' => $vendors,
                        'price' => $vendorPriceNew,
                        'realPrice' => $vendorPriceNewReal,
                        'pricePreviousDiff' => ($vendorPriceNew - $vendorPriceOld),
                        'pricePreviousPercentDiff' => priceDiffPercent($vendorPriceOld, $vendorPriceNew),
                        'trackedDate' => Carbon::now()->addDays($day),
                    ]
                );
                $vendorPriceOld = $vendorPriceNew;
            }

            $priceOld = $priceNew;

        }
    }
}
