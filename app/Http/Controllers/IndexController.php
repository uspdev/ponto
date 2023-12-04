<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Place;
use App\Models\Grupo;

class IndexController extends Controller
{
    public function index()
    {   
        return view('index',[
            // Retorna somente os lugares com para monitores das salas Pró-Aluno ou Próaluno
            'places' => Place::where('name', 'like', '%pro-aluno%')->orWhere('name', 'like', '%proaluno%')->get(),
        ]);
    }
}
