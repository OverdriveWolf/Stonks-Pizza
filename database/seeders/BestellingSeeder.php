<?php

namespace Database\Seeders;
use App\Models\Order;
use App\Models\customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BestellingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $klant = customer::first();

        order::create([
            'Customer_id' => $klant->id,
            'datum' => now(),
            'status' => 'Initieel',
        ]);
    }
}
