<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Registro;

class Place extends Model
{
    use HasFactory;

    public function registros()
    {
        return $this->hasMany(Registro::class);
    }
}
