<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('platforms')->insert(

            [
                [
                    'name' => 'HEPSİBURADA',
                    'url' => 'https://www.hepsiburada.com',
                    'domains' => 'hepsiburada.com',
                    'logo_url' => '/storage/images/platforms/hepsi.png',
                ],
                [
                    'name' => 'TRENDYOL',
                    'url' => 'https://www.trendyol.com/',
                    'domains' => 'trendyol.com',
                    'logo_url' => '/storage/images/platforms/Trendyol_online.png',
                ],
                [
                    'name' => 'N11',
                    'url' => 'https://www.n11.com',
                    'domains' => 'n11.com,urun.n11.com',
                    'logo_url' => '/storage/images/platforms/n11.png',
                ],
                [
                    'name' => 'AMAZON',
                    'url' => 'https://www.amazon.com.tr',
                    'domains' => 'amazon.com.tr',
                    'logo_url' => '/storage/images/platforms/Amazon.com_.tr_Logo.jpg',
                ],
                [
                    'name' => 'A101',
                    'url' => 'https://www.a101.com.tr/',
                    'domains' => 'a101.com.tr',
                    'logo_url' => '/storage/images/platforms/Amazon.com_.tr_Logo.jpg',
                ],
                [
                    'name' => 'BİM',
                    'url' => 'https://www.bim.com.tr/',
                    'domains' => 'bim.com.tr',
                    'logo_url' => '/storage/images/platforms/Bim_(company)-Logo.wine.png',
                ],
            ]
        );
    }
}
