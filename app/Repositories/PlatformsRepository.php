<?php

namespace App\Repositories;

use App\Models\Platforms;
use Illuminate\Database\Eloquent\Collection;

class PlatformsRepository
{

    public static function get(): Collection
    {
        return Platforms::query()
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * @param string $host
     * @return Platforms|null
     */
    public static function platformByHost(string $host) :Platforms |null
    {
        return Platforms::query()
            ->where('domains', 'like', '%' . $host . '%')
            ->first();
    }
}
