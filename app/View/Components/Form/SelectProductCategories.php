<?php

namespace App\View\Components\Form;

use App\Repositories\ProductCategoriesRepository;
use App\Utils\iSelect2Builder;
use App\Utils\Select2Builder;

class SelectProductCategories extends Select2Builder implements iSelect2Builder
{

    public function build() : self
    {
        $this->setId('parent_category')
            ->setName('parent_category')
            ->setSource(ProductCategoriesRepository::get())
            ->setSourceMapping(
                [
                    self::SOURCE_MAPPING_VALUE => 'id',
                    self::SOURCE_MAPPING_LABEL => 'name'
                ]
            );

        return $this;

    }
}
