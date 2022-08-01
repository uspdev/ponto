<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OcorrenciaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
                'ocorrencia' => $this->faker->sentence(3),
                'codpes'   => $this->faker->ean13(),
                // 'place_id' => $this->faker->id(), ??
        ];
    }
}
