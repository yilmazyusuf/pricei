<?php

namespace App\Models;

use App\Traits\FileQueryCacheable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $platform_id
 * @property string $name
 * @property string $url
 * @property string $productId
 * @property string $imageUrl
 * @property float $price
 * @property float $realPrice
 * @property float $sellingPrice
 * @property string $currency
 * @property string $sellerId
 * @property string $sellerName
 * @property string $sellerShopLink
 * @property boolean $isJobLocked
 * @property boolean $isJobActive
 * @property integer $jobTries
 * @property boolean $lasJobStatus
 * @property string $lasJobErrorMessage
 * @property string $lastJobDate
 * @property string $nextJobDate
 *
 * @property ?Platforms $platform
 */
class Products extends Model
{
    use HasFactory;
    use FileQueryCacheable;
    use SoftDeletes;

    protected $guarded = [];
    public int $cacheFor = 31557600;
    public array $cacheTags = ['products'];
    public string $cachePrefix = 'products_';
    protected static bool $flushCacheOnUpdate = true;

    protected function getCacheBaseTags(): array
    {
        return [
            'products',
        ];
    }

    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platforms::class);
    }

    public function vendors(): HasMany
    {
        return $this->hasMany(ProductVendors::class);
    }

    public function priceHistory(): HasMany
    {
        return $this->hasMany(PriceHistories::class);
    }

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getLastPriceUpdateAttribute()
    {
        return $this->priceHistory()
            ->whereNotNull('pricePreviousDiff')
            ->orderBy('id', 'desc')
            ->first();
    }
}
