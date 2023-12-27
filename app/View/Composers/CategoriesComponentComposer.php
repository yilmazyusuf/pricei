<?php

namespace App\View\Composers;

use App\View\Components\Form\SelectProductCategories;
use Illuminate\View\View;

class CategoriesComponentComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('categoriesComponent', new SelectProductCategories());
    }
}
