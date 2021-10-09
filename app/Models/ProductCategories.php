<?php

namespace App\Models;

use App\Traits\FileQueryCacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    use HasFactory;
    use FileQueryCacheable;
}
