<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
   public function user_index()
    {
        return view('welcome');
    }

   public function about()
    {
        return view('about');
    }
}
