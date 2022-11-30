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

        $computes = $this->compute($codpes, $in, $out);
        dd($this->computeTotal($computes));

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

            $dayName = $day->format('d') . ' - ' . $day->locale('pt_Br')->shortDayName;

            $registros = Registro::whereDate('created_at', $day->toDateString())
                ->where('codpes', $codpes)
                ->orderBy('created_at')
                ->get();

            // Dia sem registro de ponto
            if($registros->isEmpty()) {
                $computes[ $dayName ] = [];
                continue;
            }

            foreach($registros->values() as $index=>$current){
                
                $next = $registros->get(++$index);

                if($current->type == 'in' && $next && $next->type == 'out'){
                    $entrada = Carbon::parse($current->created_at);
                    $saida = Carbon::parse($next->created_at);

                    $intervalo = $entrada->format('H:i') . '-' . $saida->format('H:i');
                    $minutes = $entrada->diffInMinutes($saida);

                    $computes[ $dayName ][] = [$intervalo => $minutes];
                } else {
                    // entrada sem marcação de saída
                    if($current->type == 'in'){
                        $entrada = Carbon::parse($current->created_at);
                        $computes[ $dayName ][] = [$entrada->format('H:i').'-?' => 0];
                    }
                }
            }
            
        }
        return $computes;
    }

    private function computeTotal($computes){
        $minutes = 0;
        foreach($computes as $day){
            foreach($day as $entries){
                foreach($entries as $entry){
                    $minutes += $entry;
                }
            }
        }
        return CarbonInterval::minutes($minutes)->cascade()->locale('pt_Br')->forHumans();
    }
}
