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
        $this->authorize('boss');

        return view('pessoas.index',[
            'grupos' => Grupo::gruposWithPessoas()
        ]);
    }

    public function show(Request $request, $codpes = 'my')
    {
        if($codpes != 'my') {
            $this->authorize('boss');
            $pessoa['codpes'] = $codpes;
        } else {
            $this->authorize('logado');
            $pessoa['codpes'] = auth()->user()->codpes;
        }

        $pessoa['nompes'] = Pessoa::obterNome($pessoa['codpes']);

        $emails = Pessoa::emails($pessoa['codpes']);
        $telefones = Pessoa::telefones($pessoa['codpes']);

        if(!empty($request->in) and !empty($request->out)){
            $request->validate([
                'in' => 'required|date_format:d/m/Y',
                'out' => 'required|date_format:d/m/Y'
            ]);
        } else {
	        // Se o dia corrente é dia 31, não estava subtraindo 1 mês em $request->in
            // https://stackoverflow.com/questions/9058523/php-date-and-strtotime-return-wrong-months-on-31st Answer #31
            $base = strtotime(date('Y-m',time()) . '-01 00:00:01');
            $request->in = '21/' . date('m/Y', strtotime('-1 month', $base));
            $request->out = "20/" . date("m/Y");
        }

        $in = Carbon::createFromFormat('d/m/Y H:i:s', $request->in . ' 00:00:00');
        $out = Carbon::createFromFormat('d/m/Y H:i:s', $request->out . ' 23:59:59');

        $computes = Util::compute($pessoa['codpes'], $in, $out);

        if(count($computes) > 31) {
            $request->session()->flash('alert-danger',
            'O intervalo de '
            . $request->in . ' até ' . $request->out
            . ' é inválido. Selecione intervalo com no máximo 31 dias.');
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
