<?php

namespace Database\Seeders;

use App\Models\Alarms;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlarmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('alarms')->insert(

            [
                [
                    'key' => Alarms::ALARM_PRODUCT_ALL,
                    'description' => 'Tüm fiyat değişimlerini bildir.',
                    'repeat' => true,
                ],
                [
                    'key' => Alarms::ALARM_PRODUCT_INCREASE,
                    'description' => 'Fiyat artışı olduğunda bildir.',
                    'repeat' => true,
                ],
                [
                    'key' => Alarms::ALARM_PRODUCT_DROP,
                    'description' => 'Fiyat düşüşü olduğunda bildir.',
                    'repeat' => true,
                ],
                [
                    'key' => Alarms::ALARM_PRODUCT_GREATER_THAN,
                    'description' => 'Ürünün Fiyatı {PRICE} TL yi geçince bildir.',
                    'repeat' => false,
                ],
                [
                    'key' => Alarms::ALARM_PRODUCT_LESS_THAN,
                    'description' => 'Ürünün Fiyatı {PRICE} TL nin altına düşerse bildir.',
                    'repeat' => false,
                ],
                [
                    'key' => Alarms::ALARM_PRODUCT_PERCENTAGE_GREATER_THAN,
                    'description' => 'Ürünün Fiyatı % {PERCENTAGE} oranından fazla artarsa bildir.',
                    'repeat' => false,
                ],
                [
                    'key' => Alarms::ALARM_PRODUCT_PERCENTAGE_LESS_THAN,
                    'description' => 'Ürünün Fiyatı % {PERCENTAGE} oranından fazla düşerse bildir.',
                    'repeat' => false,
                ],

                [
                    'key' => Alarms::ALARM_VENDORS_AVERAGE_GREATER_THAN,
                    'description' => 'Ortalama Mağaza Fiyatı {PRICE} TL yi geçince bildir.',
                    'repeat' => false,
                ],
                [
                    'key' => Alarms::ALARM_VENDORS_AVERAGE_LESS_THAN,
                    'description' => 'Ortalama Mağaza Fiyatı {PRICE} TL nin altına düşerse bildir.',
                    'repeat' => false,
                ],
                [
                    'key' => Alarms::ALARM_VENDORS_AVERAGE_PERCENTAGE_GREATER_THAN,
                    'description' => 'Ortalama Mağaza Fiyatı % {PERCENTAGE} oranından fazla artarsa bildir.',
                    'repeat' => false,
                ],
                [
                    'key' => Alarms::ALARM_VENDORS_AVERAGE_PERCENTAGE_LESS_THAN,
                    'description' => 'Ortalama Mağaza Fiyatı % {PERCENTAGE} oranından fazla düşerse bildir.',
                    'repeat' => false,
                ],
            ]
        );
    }
}
