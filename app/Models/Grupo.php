<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Uspdev\Replicado\DB;

class Grupo extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public static function gruposWithPessoas(){
        $grupos = Grupo::all();

        foreach($grupos as $grupo){
            $pessoas = DB::fetchAll($grupo->query);
            $grupo->pessoas = empty($pessoas) ? []: array_column($pessoas,'codpes');
        }
        return  $grupos;
    }

    public static function allowedCodpes(){
        $grupos = Grupo::all();

        $codpes = [];
        foreach($grupos as $grupo){
            $pessoas = DB::fetchAll($grupo->query);
            foreach($pessoas as $pessoa){
                $codpes[] = $pessoa['codpes'];
            }
            
        }
        return $codpes;
    }

    public static function getGroup($codpes){
        $grupos = Grupo::all();

        foreach($grupos as $grupo){
            $pessoas = DB::fetchAll($grupo->query);
            foreach($pessoas as $pessoa){
                if($codpes == $pessoa['codpes']) return $grupo;
            }
        }
        return null;
    }
}
