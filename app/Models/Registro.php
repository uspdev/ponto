<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Place;

class Registro extends Model
{
    use HasFactory;

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
