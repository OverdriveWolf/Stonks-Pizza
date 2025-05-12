<?php

namespace Database\Seeders; 
use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            ['naam' => 'Kaas', 'prijs' => 1.00],
            ['naam' => 'Tomatensaus', 'prijs' => 0.50],
            ['naam' => 'Salami', 'prijs' => 1.50],
            ['naam' => 'Champignons', 'prijs' => 1.20],
        ];

        foreach ($ingredients as $data) {
            Ingredient::create($data);
        }
    }
}

