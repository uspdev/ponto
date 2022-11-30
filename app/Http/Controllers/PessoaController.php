<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\ReplicadoTemp;
use Uspdev\Replicado\Pessoa;
use App\Models\Registro;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Requests\pessoaRequest;
use Carbon\CarbonInterval;

class PessoaController extends Controller
{
    public function index()
    {
        $this->authorize('admin');
        $bolsistas = ReplicadoTemp::listarMonitores(config('ponto.codslamon'));
        foreach ($bolsistas as $bolsista) {
            $pessoas[$bolsista] = Pessoa::obterNome($bolsista);
        }
        return view('pessoas.index',[
            'pessoas' => $pessoas
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

        $this->compute($codpes, $in, $out);

        $registros = Registro::where('created_at', '>=', $in)
            ->where('created_at', '<=', $out)
            ->where('codpes', '=', $pessoa['codpes'])
            ->get();

        
        return view('pessoas.show',[
            'pessoa' => $pessoa,
            'emails' => $emails,
            'telefones' => $telefones,
            'registros' => $registros,
        ]);
     }

     private function compute($codpes, $in, $out){
        $period = CarbonPeriod::between($in, $out);
        $computes = [];
        
        foreach ($period as $day) {

            $registros = Registro::whereDate('created_at', $day->toDateString())
                ->where('codpes', $codpes)
                ->orderBy('created_at')
                ->get();

            // Dias sem registro de ponto
            if($registros->isEmpty()) {
                $arraykey = $day->format('d');
                $arraykey .= ' - ' . $day->locale('pt_Br')->shortDayName;
                $computes[$arraykey] = [
                    'formatted' => '',
                    'minutes'   => ''
                ];
            }

            foreach($registros->values() as $index=>$current){
                $next = $registros->get(++$index);

                if($next){
                    $entrada = Carbon::parse($current->created_at);
                    $saida = Carbon::parse($next->created_at);

                    $arraykey = $day->format('d');
                    $arraykey .= ' - ' . $day->locale('pt_Br')->shortDayName;
                    $arraykey .= ' ' . $entrada->format('H:i') . '-' . $saida->format('H:i');

                    $minutes = $entrada->diffInMinutes($saida);

                    $computes[$arraykey] = [
                        'formatted' => CarbonInterval::minutes($minutes)->cascade()->locale('pt_Br')->forHumans(),
                        'minutes'   => $entrada->diffInMinutes($saida)
                    ];

                } /* else {
                    $entrada = Carbon::parse($current->created_at);
                    $chave = $entrada->format('H:i');
                    $x[$day->format('d')] = [
                        $index => [
                            $chave => 'sem saída'
                        ]
                    ]; 
                } */
            }
            
        }
        dd($computes);

     }

}
