<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PlatformName;
use App\Http\Resources\CategoryCollection;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    public function getCategories(PlatformName $request)
    {
        return new CategoryCollection(Category::filteredCategories($request->name));
    }
}
