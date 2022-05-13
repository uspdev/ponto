<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Place;

class IndexController extends Controller
{
    public function index()
    {
        return view('index',[
            'places' => Place::all(),
        ]);
    }
}
