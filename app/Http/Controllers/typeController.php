<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class typeController extends Controller
{
    public function index()
    {
        return view('directory.type.index');

    }
}
