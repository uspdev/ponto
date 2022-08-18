<?php

namespace Database\Seeders;

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
        \App\Models\Ocorrencia::factory(5)->create();
    }
}
