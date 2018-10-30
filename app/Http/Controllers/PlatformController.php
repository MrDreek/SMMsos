<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlatformCollection;
use App\Platform;
use Illuminate\Routing\Controller;

class PlatformController extends Controller
{
    public function getPlatform()
    {
        return new PlatformCollection(Platform::select(['name'])->orderBy('name')->get());
    }
}
