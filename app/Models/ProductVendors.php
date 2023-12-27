<?php

namespace App\Models;

use App\Traits\FileQueryCacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property int $products_id
 * @property string $url
 * @property string $shopProductId
 * @property float $price
 * @property float $realPrice
 * @property string $sellerId
 * @property string $sellerName
 * @property string $sellerShopLink
 * @property bool $isVendorActive
*/
class ProductVendors extends Model
{
    use HasFactory;
    use FileQueryCacheable;
    use SoftDeletes;

    protected $guarded = [];
    public int $cacheFor = 31557600;
    public array $cacheTags = ['product_vendors_'];
    public string $cachePrefix = 'product_vendors';
    protected static bool $flushCacheOnUpdate = true;

    protected function getCacheBaseTags(): array
    {
        return [
            'product_vendors',
        ];
    }

    public function priceHistory(): HasMany
    {
        return $this->hasMany(PriceHistories::class);
    }
}
