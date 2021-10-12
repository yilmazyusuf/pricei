<?php

namespace App\Http\Controllers;

use App\DataTables\ProductCategoriesDataTable;
use App\Http\Requests\StoreProductCategoriesRequest;
use App\Http\Requests\UpdateProductCategoriesRequest;
use App\Models\ProductCategories;
use App\Utils\Ajax;
use App\View\Components\Alert;
use App\View\Components\Form\SelectProductCategories;
use App\View\Composers\FlashMessageViewComposer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(ProductCategoriesDataTable $dataTable): mixed
    {
        return $dataTable->render('products_categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('products_categories.create')->with(
            [
                'categoriesComponent' => new SelectProductCategories()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductCategoriesRequest $request
     * @param ProductCategories $productCategories
     * @param Ajax $ajax
     * @return JsonResponse
     */
    public function store(StoreProductCategoriesRequest $request, ProductCategories $productCategories, Ajax $ajax): JsonResponse
    {
        $productCategories->query()->create($request->all());

        Alert::flashAlert(Alert::MESSAGE_SUCCESS, 'Category Created');
        return $ajax->redirect(route('products_categories.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id): Application|Factory|\Illuminate\Contracts\View\View
    {
        $productCategory = ProductCategories::query()->find($id);
        if (!$productCategory) {
            abort(404);
        }

        $categoriesComponent = new SelectProductCategories();
        $categoriesComponent->except(['id' => [$id]]);

        return view('products_categories.edit')->with(
            [
                'categoriesComponent' => $categoriesComponent,
                'productCategory' => $productCategory,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateProductCategoriesRequest $request, Ajax $ajax, $id)
    {
        $productCategory = ProductCategories::query()->find($id);
        if (!$productCategory) {
            abort(404);
        }

        $productCategory->fill($request->all())->save();

        Alert::flashAlert(Alert::MESSAGE_SUCCESS, 'Category Updated');
        return $ajax->redirect(route('products_categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
