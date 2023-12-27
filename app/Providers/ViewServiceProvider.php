<?php

namespace App\Providers;

use App\View\Components\Form\SelectProductCategories;
use App\View\Composers\CategoriesComponentComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['products_categories.create','products.create'],
            CategoriesComponentComposer::class
        );


        View::composer('products_categories.edit', function ($view) {
            $productCategoryID = request()->route('products_category');
            $categoriesComponent = new SelectProductCategories();
            $categoriesComponent->except(['id' => [$productCategoryID]]);
            $view->with('categoriesComponent', $categoriesComponent);
        });
    }
}
