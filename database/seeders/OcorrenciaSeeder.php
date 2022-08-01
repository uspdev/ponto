<?php

namespace Database\Seeders;

use App\Models\Ocorrencia;
use Illuminate\Database\Seeder;

class OcorrenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ocorrencia = [
            'codpes' => "12785424",
            'ocorrencia' => "Computador quebrou",
            'place_id' => "5"
        ];
        \App\Models\Ocorrencia::create($ocorrencia);
        \App\Models\Ocorrencia::factory(5)->create();
    }
}
