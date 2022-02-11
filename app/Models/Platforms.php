<?php

namespace App\Models;

use App\Traits\FileQueryCacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $domains
 * @property string $logo_url
 */
class Platforms extends Model
{
    use HasFactory;
    use FileQueryCacheable;
    use SoftDeletes;

    protected $fillable = ['name', 'url', 'logo_url','domains'];

    public int $cacheFor = 31557600;
    public array $cacheTags = ['platforms'];
    public string $cachePrefix = 'platforms_';
    protected static bool $flushCacheOnUpdate = true;

    protected function getCacheBaseTags(): array
    {
        return [
            'platforms',
        ];
    }


}
