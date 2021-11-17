<?php

namespace App\Http\Controllers;

use App\DataTables\ProductsDataTable;
use App\Http\Requests\StoreProductCategoriesRequest;
use App\Http\Requests\UpdateProductCategoriesRequest;
use App\Models\Products;

class ProductController extends ResourceController
{
    protected string $indexDataTable = ProductsDataTable::class;
    protected string $storeRequest = StoreProductCategoriesRequest::class;
    protected string $updateRequest = UpdateProductCategoriesRequest::class;
    protected string $resourceName = 'products';
    protected string $model = Products::class;

}
