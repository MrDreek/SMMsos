<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function balance()
    {
        return \Response::json(User::getBalance(), 200);
    }
}
