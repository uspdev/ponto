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

    public function compute($codpes, $in, $out){
        $period = CarbonPeriod::between($in, $out);
        $computes = [];
        
        foreach ($period as $day) {

            $dayName = $day->format('d') . ' - ' . ucfirst($day->locale('pt_Br')->shortDayName);

            $registros = Registro::whereDate('created_at', $day->toDateString())
                ->where('codpes', $codpes)
                ->where('status', 'válido')
                ->orderBy('created_at')
                ->get();

            // Dia sem registro de ponto
            if($registros->isEmpty()) {
                $computes[ $dayName ] = [];
                //array_push($computes, [$dayName => []]);
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
                    //array_push($computes, [$dayName => [$intervalo => $minutes]]);

                } else {
                    // entrada sem marcação de saída
                    if($current->type == 'in'){
                        $entrada = Carbon::parse($current->created_at);
                        $computes[ $dayName ][] = [$entrada->format('H:i').'-?' => 0];
                        //array_push($computes, [$dayName => [$entrada->format('H:i').'-?' => 0]]);
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
        return self::formatMinutes($minutes);
    }

    public function formatMinutes($minutes){
        $h = floor($minutes / 60);
        $m = $minutes -   floor($minutes / 60) * 60;
        if($h == 1 and $m == 1) return "{$h} hora e ${m} minuto";
        if($h == 1 and $m > 1) return "{$h} hora e ${m} minutos";
        if($h > 1 and $m == 1) return "{$h} horas e ${m} minuto";
        if($h > 1 and $m > 1) return "{$h} horas e ${m} minutos";
        if($h > 1 and $m == 0) return "{$h} horas";
        if($h == 1 and $m == 0) return "{$h} hora";
        if($h == 0 and $m == 1) return "{$m} minuto";
        if($h == 0 and $m > 1) return "{$m} minutos";
        if($h == 0 and $m == 0) return '';
        return "{$h} horas e ${m} minutos";
    }

    public function computeDayMinutes($computes, $day) {
        $minutos_do_dia = 0;
        $registros = '';

        if(array_key_exists($day, $computes)){
            $array = $computes[$day];
            foreach($array as $linhas){
                foreach($linhas as $registro=>$minutos){
                    if(empty($registros)) $registros = $registro;
                    else { $registros .= " e $registro";}
                    $minutos_do_dia += $minutos;
                }
            }
        }
        
        return [$day,$registros, self::formatMinutes($minutos_do_dia)];
    }
}