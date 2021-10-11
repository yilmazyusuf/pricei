<?php

namespace App\Http\Controllers;

use App\DataTables\ProductCategoriesDataTable;
use App\Http\Requests\StoreProductCategoriesRequest;
use App\Models\ProductCategories;
use App\Utils\Ajax;
use App\View\Components\Alert;
use App\View\Components\Form\SelectProductCategories;
use App\View\Composers\FlashMessageViewComposer;
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
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id)
    {
        return view('products_categories.create')->with(
            [
                'categoriesComponent' => new SelectProductCategories()
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
    public function update(Request $request, $id)
    {
        //
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
