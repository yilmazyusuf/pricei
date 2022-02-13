<?php

namespace App\Models;

use App\Traits\FileQueryCacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property boolean $isTracked
 * @property boolean $status
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
        return $this->belongsTo(Platforms::class,);
    }
}
