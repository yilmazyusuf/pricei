<?php

namespace App\Http\Controllers;

use App\Utils\Ajax;
use App\View\Components\Alert;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;

abstract class ResourceController extends Controller
{
    protected string $indexDataTable;
    protected string $storeRequest;
    protected string $updateRequest;
    protected string $model;
    protected string $resourceName;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): mixed
    {
        $dataTable = new $this->indexDataTable();
        return $dataTable->render($this->resourceName . '.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view($this->resourceName . '.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Ajax $ajax
     * @return JsonResponse
     */
    public function store(Ajax $ajax): JsonResponse
    {
        $request = App::make($this->storeRequest);
        /* @var $model Model */
        $model = App::make($this->model);
        $model->query()->create($request->all());

        Alert::success('Created');
        return $ajax->redirect(route($this->resourceName . '.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        /* @var $model Model */
        $model = App::make($this->model);
        $row = $model::query()->find($id);
        if (!$row) {
            abort(404);
        }

        return view($this->resourceName . '.edit')->with(
            ['collection' => $row]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Ajax $ajax
     * @param int $id
     * @return JsonResponse|RedirectResponse
     */
    public function update(Ajax $ajax, int $id): JsonResponse|RedirectResponse
    {
        /* @var $model Model */
        $model = App::make($this->model);
        $row = $model::query()->find($id);
        if (!$row) {
            abort(404);
        }
        $request = App::make($this->updateRequest);
        $row->fill($request->all())->save();

        Alert::success('Updated');
        return $ajax->redirect(route($this->resourceName . '.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param Ajax $ajax
     * @return JsonResponse|RedirectResponse
     */
    public function destroy(int $id, Ajax $ajax): JsonResponse|RedirectResponse
    {
        /* @var $model Model */
        $model = App::make($this->model);
        $row = $model::query()->find($id);
        if (!$row) {
            abort(404);
        }

        $row->delete();

        Alert::success('Deleted');
        return $ajax->redirect(route($this->resourceName . '.index'));
    }
}
