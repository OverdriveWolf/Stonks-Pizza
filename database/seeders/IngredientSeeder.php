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
            ['naam' => 'Paprika', 'prijs' => 1.00],
            ['naam' => 'Olijven', 'prijs' => 1.30],
            ['naam' => 'Ananas', 'prijs' => 1.00],
            ['naam' => 'Ham', 'prijs' => 1.50],
            ['naam' => 'Tonijn', 'prijs' => 2.00],
            ['naam' => 'Garnalen', 'prijs' => 2.50],
            ['naam' => 'Kip', 'prijs' => 1.80],
            ['naam' => 'Spinazie', 'prijs' => 1.20],
            ['naam' => 'Parmezaanse kaas', 'prijs' => 2.00],
            ['naam' => 'Basilicum', 'prijs' => 0.80],
            ['naam' => 'Aubergine', 'prijs' => 1.00],
            ['naam' => 'Courgette', 'prijs' => 1.00],
            ['naam' => 'Knoflook', 'prijs' => 0.50],
            ['naam' => 'Pepperoni', 'prijs' => 1.50],
            ['naam' => 'Bacon', 'prijs' => 1.80],
            ['naam' => 'Gorgonzola', 'prijs' => 2.00],
            ['naam' => 'Ricotta', 'prijs' => 1.80],
            ['naam' => 'Truffelolie', 'prijs' => 2.50],
            ['naam' => 'Koriander', 'prijs' => 0.80],
            ['naam' => 'Mosterd', 'prijs' => 0.50],
            ['naam' => 'Sesamzaadjes', 'prijs' => 0.50],
            ['naam' => 'Augurken', 'prijs' => 1.00],
            ['naam' => 'Ketchup', 'prijs' => 0.50],
            ['naam' => 'Mayonaise', 'prijs' => 0.50],
            ['naam' => 'Barbecuesaus', 'prijs' => 0.50],
            ['naam' => 'Guacamole', 'prijs' => 1.50],
            ['naam' => 'Chili saus', 'prijs' => 0.80],
            ['naam' => 'Teriyaki saus', 'prijs' => 1.00],
            ['naam' => 'Sojasaus', 'prijs' => 0.50],
            ['naam' => 'rode ui', 'prijs' => 0.80],
            ['naam' => 'BBQ saus', 'prijs' => 1.50],
            ['naam' => 'mais', 'prijs' => 1.00],
        ];

        foreach ($ingredients as $data) {
            Ingredient::create($data);
        }
    }
}

