<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\ReplicadoTemp;

class MonitorController extends Controller
{
    public function index()
    {
        $monitores = ReplicadoTemp::listarMonitores(config('ponto.codslamon'));
        return view('monitores.index',[
            'monitores' => $monitores
        ]);
    }
}
