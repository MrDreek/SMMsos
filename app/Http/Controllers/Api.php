<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Routing\Controller;

class Api extends Controller
{
    public function getData()
    {
        return response()->json(['message' => Service::saveServicesFromApi()], 200);
    }
}
