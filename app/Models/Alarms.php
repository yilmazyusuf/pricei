<?php

namespace App\Models;

use App\Traits\FileQueryCacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alarms extends Model
{
    use HasFactory;
    use FileQueryCacheable;
    use SoftDeletes;

    const ALARM_PRODUCT_ALL = 'ALARM_PRODUCT_ALL';
    const ALARM_PRODUCT_INCREASE = 'ALARM_PRODUCT_INCREASE';
    const ALARM_PRODUCT_DROP = 'ALARM_PRODUCT_DROP';
    const ALARM_PRODUCT_GREATER_THAN = 'ALARM_PRODUCT_GREATER_THAN';
    const ALARM_PRODUCT_LESS_THAN = 'ALARM_PRODUCT_LESS_THAN';
    const ALARM_PRODUCT_PERCENTAGE_GREATER_THAN = 'ALARM_PRODUCT_PERCENTAGE_GREATER_THAN';
    const ALARM_PRODUCT_PERCENTAGE_LESS_THAN = 'ALARM_PRODUCT_PERCENTAGE_LESS_THAN';
    const ALARM_VENDORS_AVERAGE_GREATER_THAN = 'ALARM_VENDORS_AVERAGE_GREATER_THAN';
    const ALARM_VENDORS_AVERAGE_LESS_THAN  = 'ALARM_VENDORS_AVERAGE_LESS_THAN';
    const ALARM_VENDORS_AVERAGE_PERCENTAGE_GREATER_THAN = 'ALARM_VENDORS_AVERAGE_PERCENTAGE_GREATER_THAN';
    const ALARM_VENDORS_AVERAGE_PERCENTAGE_LESS_THAN = 'ALARM_VENDORS_AVERAGE_PERCENTAGE_LESS_THAN';


    public int $cacheFor = 31557600;
    public array $cacheTags = ['alarms'];
    public string $cachePrefix = 'alarms_';
    protected static bool $flushCacheOnUpdate = true;

    protected function getCacheBaseTags(): array
    {
        return [
            'platforms',
        ];
    }
}
