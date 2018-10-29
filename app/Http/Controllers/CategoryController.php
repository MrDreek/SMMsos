<?php

namespace App\Http\Controllers;


use App\Category;
use App\Http\Resources\CategoryCollection;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    public function getCategories()
    {
        return new CategoryCollection(Category::all());
    }
}
