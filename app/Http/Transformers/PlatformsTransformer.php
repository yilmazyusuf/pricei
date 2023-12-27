<?php

namespace App\Http\Transformers;

use App\Models\Platforms;
use League\Fractal\TransformerAbstract;

class PlatformsTransformer extends TransformerAbstract
{

    /**
     *
     * @param Platforms $platform
     * @return  array
     */
    public function transform(Platforms $platform): array
    {

        return [
            'id' => $platform->id,
            'name' => $platform->name,
            'domains' => $platform->domains,
            'url' => '<a href="' . $platform->url . '" target="_blank">' . $platform->url . '</a>',
            'logo_url' => "<img src='" . asset($platform->logo_url) . "' height=36>",
            'urls' => [
                'edit' => route('platforms.edit', $platform->id),
                'destroy' => route('platforms.destroy', $platform->id)
            ]

        ];
    }
}
