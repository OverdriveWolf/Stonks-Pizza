<?php

namespace Database\Factories;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    public function definition()
    {
        return [
            'naam' => $this->faker->word(),
            'prijs' => $this->faker->randomFloat(2, 0.5, 5), // price between €0.50 - €5.00
        ];
    }
}
