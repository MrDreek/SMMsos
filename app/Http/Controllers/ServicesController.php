<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryName;
use App\Http\Requests\ServiceIdRequest;
use App\Http\Resources\ServiceCollection;
use App\Platform;
use App\Service;
use App\ServiceOptions;
use Illuminate\Routing\Controller;

class ServicesController extends Controller
{
    public function loadServiceFromApi()
    {
        $response = Service::saveServicesFromApi();
        return response()->json($response, $response['code']);
    }


    public function clearAll()
    {
        Category::truncate();
        Category::truncate();
        Platform::truncate();
        return response()->json(['Очищено!']);
    }

    public function getServiceOption(ServiceIdRequest $request)
    {
        return response()->json(ServiceOptions::loadOptionFromApi($request->id), 200);
    }

    public function getServices(CategoryName $request)
    {
        return new ServiceCollection(Service::filteredCategory($request));
    }
}
