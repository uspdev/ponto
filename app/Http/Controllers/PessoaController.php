<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Replicado\Pessoa;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Requests\pessoaRequest;
use Carbon\CarbonInterval;

use App\Models\Registro;
use App\Models\Grupo;

use App\Utils\Util;


class PessoaController extends Controller
{
    public function index()
    {
        $this->authorize('admin');

        return view('pessoas.index',[
            'grupos' => Grupo::gruposWithPessoas()
        ]);
    }

    public function show(Request $request, $codpes)
    {   
        $this->authorize('admin');
        $pessoa['codpes'] = $codpes;
        $pessoa['nompes'] = Pessoa::obterNome($pessoa['codpes']);

        $emails = Pessoa::emails($pessoa['codpes']);
        $telefones = Pessoa::telefones($pessoa['codpes']);
        
        if(!empty($request->in) and !empty($request->out)){
            $request->validate([
                'in' => 'required|date_format:d/m/Y',
                'out' => 'required|date_format:d/m/Y'
            ]);
        } else {
            $request->in = "21/" . date("m/Y",strtotime("-1 month"));
            $request->out = "20/" . date("m/Y");
        }

        $in = Carbon::createFromFormat('d/m/Y',$request->in);
        $out = Carbon::createFromFormat('d/m/Y',$request->out);

        $computes = Util::compute($codpes, $in, $out);
        
        if(count($computes) > 31) {
            $request->session()->flash('alert-danger',$request->in . ' e ' . $request->out . 
            ' inválidos. Selecione intervalo com até 31 dias.');
            return redirect('/pessoas/' . $codpes);
        }
        
        $registros = Registro::where('created_at', '>=', $in)
            ->where('created_at', '<=', $out)
            ->where('codpes', '=', $pessoa['codpes'])
            ->get();

        
        return view('pessoas.show',[
            'pessoa' => $pessoa,
            'emails' => $emails,
            'telefones' => $telefones,
            'registros' => $registros,
            'computes'  => $computes,
            'total'     => Util::computeTotal($computes)
        ]);
     }
}
