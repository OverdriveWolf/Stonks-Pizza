<?php

namespace Database\Seeders;
use App\Models\Pizza;
use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

        public function run(): void
        {
            $margherita = Pizza::create(['naam' => 'Margherita', 'prijs' => 1.50]);
            $margherita->ingredients()->attach([
                Ingredient::where('naam', 'Kaas')->first()->id,
                Ingredient::where('naam', 'Tomatensaus')->first()->id,
                Ingredient::where('naam', 'Basilicum')->first()->id,
            ]);
    
            $salami = Pizza::create(['naam' => 'Salami', 'prijs' => 1.80]);
            $salami->ingredients()->attach([
                Ingredient::where('naam', 'Kaas')->first()->id,
                Ingredient::where('naam', 'Tomatensaus')->first()->id,
                Ingredient::where('naam', 'Salami')->first()->id,
            ]);
            $hawaii = Pizza::create(['naam' => 'Hawaii', 'prijs' => 2.00]);
            $hawaii->ingredients()->attach([
                Ingredient::where('naam', 'Kaas')->first()->id,
                Ingredient::where('naam', 'Tomatensaus')->first()->id,
                Ingredient::where('naam', 'Ham')->first()->id,
                Ingredient::where('naam', 'Ananas')->first()->id,
            ]);
            $vegetarisch = Pizza::create(['naam' => 'Vegetarisch', 'prijs' => 1.70 ]);
            $vegetarisch->ingredients()->attach([
                Ingredient::where('naam', 'Kaas')->first()->id,
                Ingredient::where('naam', 'Tomatensaus')->first()->id,
                Ingredient::where('naam', 'Paprika')->first()->id,
                Ingredient::where('naam', 'Champignons')->first()->id,
                Ingredient::where('naam', 'Olijven')->first()->id,
            ]);
            $pepperoni = Pizza::create(['naam' => 'Pepperoni', 'prijs' => 1.90]);
            $pepperoni->ingredients()->attach([
                Ingredient::where('naam', 'Kaas')->first()->id,
                Ingredient::where('naam', 'Tomatensaus')->first()->id,
                Ingredient::where('naam', 'Pepperoni')->first()->id,
            ]);
            $bbq_chicken = Pizza::create(['naam' => 'BBQ Chicken', 'prijs' => 2.20]);
            $bbq_chicken->ingredients()->attach([
                Ingredient::where('naam', 'Kaas')->first()->id,
                Ingredient::where('naam', 'BBQ saus')->first()->id,
                Ingredient::where('naam', 'Kip')->first()->id,
                Ingredient::where('naam', 'Rode ui')->first()->id,
            ]);
    }
}
