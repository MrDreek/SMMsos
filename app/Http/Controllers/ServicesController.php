<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryNameRequest;
use App\Http\Resources\ServiceCollection;
use App\Service;
use Illuminate\Routing\Controller;

class ServicesController extends Controller
{
    public function getServices(CategoryNameRequest $request)
    {
        return new ServiceCollection(Service::where('category', $request->categoryName)->get());
    }
}
