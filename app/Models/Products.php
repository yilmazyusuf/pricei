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
class Products extends Model
{
    use HasFactory;
    use FileQueryCacheable;
    use SoftDeletes;

    protected $fillable = ['name', 'parent_id'];

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


    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategories::class);
    }


}
