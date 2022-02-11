<?php

namespace App\Http\Controllers;

use App\DataTables\PlatformsDataTable;
use App\Http\Requests\StorePlatformsRequest;
use App\Http\Requests\UpdatePlatformsRequest;
use App\Models\Platforms;

class PlatformsController extends ResourceController
{
    protected string $indexDataTable = PlatformsDataTable::class;
    protected string $storeRequest = StorePlatformsRequest::class;
    protected string $updateRequest = UpdatePlatformsRequest::class;
    protected string $model = Platforms::class;
    protected string $resourceName = 'platforms';


}
