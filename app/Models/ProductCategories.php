<?php

namespace App\Models;

use App\Traits\FileQueryCacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    use HasFactory;
    use FileQueryCacheable;

    protected $fillable = ['name', 'parent_id'];

    public int $cacheFor = 31557600;
    public array $cacheTags = ['product_categories'];
    public string $cachePrefix = 'product_categories_';

    protected function getCacheBaseTags(): array
    {
        return [
            'product_categories',
        ];
    }

    protected static bool $flushCacheOnUpdate = true;
}
