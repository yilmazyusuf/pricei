<?php

namespace App\Models;

use App\Traits\FileQueryCacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property int $id
 * @property string $name
 */
class ProductCategories extends Model
{
    use HasFactory;
    use FileQueryCacheable;
    use SoftDeletes;

    protected $fillable = ['name', 'parent_id'];

    public int $cacheFor = 31557600;
    public array $cacheTags = ['product_categories'];
    public string $cachePrefix = 'product_categories_';
    protected static bool $flushCacheOnUpdate = true;

    protected function getCacheBaseTags(): array
    {
        return [
            'product_categories',
        ];
    }


    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductCategories::class);
    }


}
