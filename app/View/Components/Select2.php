<?php

namespace App\View\Components;

use App\Utils\Select2Builder;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use ReflectionClass;
use ReflectionProperty;

class Select2 extends Component
{

    public Select2Builder $select2Builder;

    public function __construct(Select2Builder $selectItem)
    {
        $this->select2Builder = $selectItem;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.select2');
    }

}
