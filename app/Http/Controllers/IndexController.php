<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Place;
use Auth;
use App\Models\Grupo;

class IndexController extends Controller
{
    public function index()
    {   
        if (Auth::check()) {
            $places = Place::all();
        } else {
            $places = Place::where('name', 'like', '%pro-aluno%')->orWhere('name', 'like', '%proaluno%')->get();
        }
        return view('index',[
            'places' => $places,
        ]);
    }
}
