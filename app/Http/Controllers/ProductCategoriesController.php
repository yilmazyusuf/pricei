<?php

namespace App\Http\Controllers;

use App\DataTables\ProductCategoriesDataTable;
use App\Http\Requests\StoreProductCategoriesRequest;
use App\Http\Requests\UpdateProductCategoriesRequest;
use App\Models\ProductCategories;
use App\View\Components\Form\SelectProductCategories;
use Illuminate\Database\Eloquent\Model;

class ProductCategoriesController extends ResourceController
{
    protected string $indexDataTable = ProductCategoriesDataTable::class;
    protected string $storeRequest = StoreProductCategoriesRequest::class;
    protected string $updateRequest = UpdateProductCategoriesRequest::class;
    protected string $model = ProductCategories::class;
    protected string $resourceName = 'products_categories';


}
