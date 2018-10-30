<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryName;
use App\Http\Requests\ServiceIdRequest;
use App\Http\Resources\ServiceCollection;
use App\Service;
use App\ServiceOptions;
use Illuminate\Routing\Controller;

class ServicesController extends Controller
{
    public function getServices(): ServiceCollection
    {
        return new ServiceCollection(Service::get());
    }

    public function loadServiceFromApi()
    {
        $response = Service::saveServicesFromApi();
        return response()->json($response, $response['code']);
    }

    public function getServiceOption(ServiceIdRequest $request)
    {
        return response()->json(ServiceOptions::loadOptionFromApi($request->id), 200);
    }

    public function getServiceNameList(CategoryName $request)
    {
        return response()->json(Service::serviceName($request->name), 200);
    }
}
