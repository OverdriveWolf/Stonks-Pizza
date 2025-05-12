<?php

namespace Database\Seeders;
use App\Models\Order;
use App\Models\Pizza;
use App\Models\Bestelregel;
use Illuminate\Database\Seeder;

class BestelregelSeeder extends Seeder
{
    public function run(): void
    {
        $bestelling = Order::first();
        $pizza = Pizza::first();

        Bestelregel::create([
            'Order_id' => $bestelling->id,
            'pizza_id' => $pizza->id,
            'aantal' => 2,
        ]);
    }
}

