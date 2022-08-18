<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Place;

class OcorrenciaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();

        return [
            'user_id' => $user->id,
            'place_id' => $place->id,
            'ocorrencia' => $this->faker->sentence(3),
        ];
    }
}
