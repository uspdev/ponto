<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Replicado\Pessoa;
use App\Models\Registro;
use App\Utils\Util;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Carbon\CarbonInterval;
use App\Http\Requests\pessoaRequest;


class PontoController extends Controller
{
    public function show(Request $request, $codpes){

        $pessoa = \Auth::user();
        
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
        
        $registros = Registro::where('created_at', '>=', $in)
            ->where('created_at', '<=', $out)
            ->where('codpes', '=', $pessoa['codpes'])
            ->get();

        
        return view('ponto.index',[
            'pessoa' => $pessoa,
            'emails' => $emails,
            'telefones' => $telefones,
            'registros' => $registros,
            'computes'  => $computes,
            'total'     => Util::computeTotal($computes),
        ]);

    }
}
