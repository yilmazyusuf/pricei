<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property integer $products_id
 * @property integer $product_vendors_id
 * @property float $price
 * @property float $realPrice
 * @property float $pricePreviousDiff
 * @property float $pricePreviousPercentDiff
 * @property string $trackedDate
 */
class PriceHistories extends Model
{
    use HasFactory;

    //use FileQueryCacheable;
    public $timestamps = false;
    protected $casts = [
        'trackedDate' => 'datetime:Y-m-d',
    ];

    protected $guarded = [];
    public int $cacheFor = 31557600;
    public array $cacheTags = ['price_histories_'];
    public string $cachePrefix = 'price_histories';
    protected static bool $flushCacheOnUpdate = true;

    public function getTrackedDateAttribute($value): string
    {
        return Carbon::parse($value)->format('d.m.Y');
    }

    public function vendor()
    {
        return $this->belongsTo(ProductVendors::class, 'product_vendors_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'products_id');
    }


    public function getSellerNameAttribute()
    {

        if ($this->vendor) {
            return $this->vendor->sellerName;
        }
        if ($this->product) {
            return $this->product->sellerName ? $this->product->sellerName. ' (Ana Ürün)' : 'Ana Ürün';
        }
    }



    public static function collectedPriceDiff($collection)
    {
        $diffTotal = number_format($collection->sum('pricePreviousDiff') / $collection->count(),2);

        return abs($diffTotal)  > 0 ? upDownIcon($diffTotal).' '.priceWithCurrency($diffTotal) :'-';
    }

    public static function collectedPriceDiffPercent($collection)
    {

        $diffTotal = number_format($collection->sum('pricePreviousPercentDiff') / $collection->count(),2);

        return abs($diffTotal) > 0 ? upDownIcon($diffTotal).' '.$diffTotal.' % ' :'-';
    }

    public function getPriceDiffPercentWithIconAttribute()
    {
        if (!$this->pricePreviousPercentDiff) {
            return;
        }

        return upDownIcon($this->pricePreviousPercentDiff) .
            ' ' . $this->pricePreviousPercentDiff . ' %';

    }

    public function getRealPriceComparedAttribute(){
        return $this->realPrice > 0 && $this->price != $this->realPrice ? $this->realPrice : null;
    }

    public function getPriceDiffWithIconAttribute()
    {
        if (!$this->pricePreviousDiff) {
            return;
        }
        return upDownIcon($this->pricePreviousDiff) .
            ' ' . priceWithCurrency($this->pricePreviousDiff);

    }

    protected function getCacheBaseTags(): array
    {
        return [
            'price_histories',
        ];
    }
}
