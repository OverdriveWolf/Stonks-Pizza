<?php

namespace Database\Factories;

use App\Models\Pizza;
use Illuminate\Database\Eloquent\Factories\Factory;

class PizzaFactory extends Factory
{
    protected $model = Pizza::class;

    public function definition()
    {
        return [
            'naam' => $this->faker->word(),
            'prijs' => $this->faker->randomFloat(2, 5, 20),
            'afmeting' => $this->faker->randomElement(['klein', 'normaal', 'groot']), // ✅ required
        ];
    }
}
