<?php

namespace App\Models;

use App\Traits\FileQueryCacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property integer $products_id
 * @property integer $product_vendors_id
 * @property float $price
 * @property float $realPrice
 * @property string $trackedDate
 */
class PriceHistories extends Model
{
    use HasFactory;
    use FileQueryCacheable;
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

    protected function getCacheBaseTags(): array
    {
        return [
            'price_histories',
        ];
    }
}
