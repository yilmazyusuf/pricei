<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Notifications extends Model
{
    use HasFactory, Notifiable;

    public function priceHistory(): BelongsTo
    {
        return $this->belongsTo(PriceHistories::class, 'price_histories_id');
    }

}
