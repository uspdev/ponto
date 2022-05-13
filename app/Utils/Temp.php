<?php

namespace App\Utils;

use Uspdev\Replicado\Pessoa;

use App\Models\Place;
use App\Models\registro;

class Temp
{    
    public static function presentes(Place $place){
        $registros = Registro::where('created_at', '>=', Carbon::today())
            ->where('place_id',$place->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}