<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\ReplicadoTemp;
use Uspdev\Replicado\Pessoa;

class MonitorController extends Controller
{
    public function index()
    {
        $this->authorize('admin');
        $bolsistas = ReplicadoTemp::listarMonitores(config('ponto.codslamon'));
        foreach ($bolsistas as $bolsista) {
            $monitores[$bolsista] = Pessoa::obterNome($bolsista);
        }
        return view('monitores.index',[
            'monitores' => $monitores
        ]);
    }

    public function show()
    {
        $this->authorize('admin');
        $monitor['codpes'] = explode('/', url()->current())[4];
        $monitor['nompes'] = Pessoa::obterNome($monitor['codpes']);
        return view('monitores.show',[
            'monitor' => $monitor
        ]);
    }
}
