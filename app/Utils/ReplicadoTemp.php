<?php

namespace App\Utils;

use Uspdev\Replicado\DB;

class ReplicadoTemp
{    
    public static function listarMonitores()
    {
        $query = "SELECT DISTINCT t1.codpes
                
                FROM BENEFICIOALUCONCEDIDO t1
                INNER JOIN BENEFICIOALUNO t2
                ON t1.codbnfalu = t2.codbnfalu
                               
                AND t1.dtafimccd > GETDATE()
                AND t1.dtacanccd IS NULL
                AND t2.codbnfalu = 32
                AND t1.codslamon = 22
                ";

        $result = DB::fetchAll($query);
        if(!empty($result)) return array_column($result,'codpes');
        return [];
    }
}