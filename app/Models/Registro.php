<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Place;

class Registro extends Model
{
    use HasFactory;

    public static $status = ['válido','inválido','análise'];

    public static $motivos = [
        'Esquecimento',
        'Graduação',
        'Férias',
        'Consulta Médica',
        'Licença Médica',
        'Doação de Sangue',
        'Falha no Sistema de Ponto',
        'Ponte/Recesso/Feriado',
    ];

    protected $fillable = [
        'codpes',
        'type',
        'image',
        'place_id',
        'status'
    ];

    public function place(){
        return $this->belongsTo(Place::class);
    }
}
