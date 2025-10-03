<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'naam' => $this->faker->name(),
            'woonplaats' => $this->faker->city(),
            'adres' => Crypt::encrypt($this->faker->streetAddress()),
            'email' => Crypt::encrypt($this->faker->safeEmail()),
            'telefoon' => Crypt::encrypt($this->faker->e164PhoneNumber()),
        ];
    }
}
