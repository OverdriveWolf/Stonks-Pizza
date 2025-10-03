<?php

namespace Database\Factories;

use App\Models\Bestelregel;
use App\Models\Order;
use App\Models\Pizza;
use Illuminate\Database\Eloquent\Factories\Factory;

class BestelregelFactory extends Factory
{
    protected $model = Bestelregel::class;

    public function definition()
    {
        return [
            'order_id' => Order::factory(),
            'pizza_id' => Pizza::factory(),
            'aantal' => $this->faker->numberBetween(1, 3),
            'afmeting' => $this->faker->randomElement(['klein', 'normaal', 'groot']),
            'prijs' => $this->faker->randomFloat(2, 6, 25),
        ];
    }
}
