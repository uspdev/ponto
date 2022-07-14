<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\ReplicadoTemp;
use Uspdev\Replicado\Pessoa;
use App\Models\Registro;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Requests\MonitorRequest;

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

    public function show(Request $request)
    {   
        $this->authorize('admin');
        $monitor['codpes'] = explode('/', url()->current())[4];
        $monitor['nompes'] = Pessoa::obterNome($monitor['codpes']);
        $emails = Pessoa::emails($monitor['codpes']);
        $telefones = Pessoa::telefones($monitor['codpes']);
        
        if(!empty($request->in) and !empty($request->out)){
            
            $request->validate([
                'in' => 'required|date_format:d/m/Y',
                'out' => 'required|date_format:d/m/Y'
            ]);

            $in = Carbon::createFromFormat('d/m/Y',$request->in);
            $out = Carbon::createFromFormat('d/m/Y',$request->out);

            $registros = Registro::where('created_at', '>=', $in)
                ->where('created_at', '<=', $out)
                ->where('codpes', '=', $monitor['codpes'])
                ->get();

            } 
            else {
            $registros = Registro::all()
                ->where('created_at', '>=', Carbon::today())
                ->where('codpes', '=', $monitor['codpes']);
             }
        
             return view('monitores.show',[
            'monitor' => $monitor,
            'emails' => $emails,
            'telefones' => $telefones,
            'registros' => $registros,
              ]);
     }

}
