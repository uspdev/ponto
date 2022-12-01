<?php

namespace App\Utils;

use Uspdev\Replicado\Pessoa;

use App\Models\Place;
use App\Models\Registro;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Carbon\CarbonInterval;

class Util
{    
    /* esta função não está sendo usada...
    public static function presentes(Place $place){
        $registros = Registro::where('created_at', '>=', Carbon::today())
            ->where('place_id',$place->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    */

    public function compute($codpes, $in, $out){
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

    public function computeTotal($computes){
        $minutes = 0;
        foreach($computes as $day){
            foreach($day as $entries){
                foreach($entries as $entry){
                    $minutes += $entry;
                }
            }
        }
        return CarbonInterval::minutes($minutes)->cascade()->locale('pt_Br')->forHumans('H i');
    }
}