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
            $margherita = Pizza::create(['naam' => 'Margherita']);
            $margherita->ingredients()->attach([
                Ingredient::where('naam', 'Kaas')->first()->id,
                Ingredient::where('naam', 'Tomatensaus')->first()->id,
            ]);
    
            $salami = Pizza::create(['naam' => 'Salami']);
            $salami->ingredients()->attach([
                Ingredient::where('naam', 'Kaas')->first()->id,
                Ingredient::where('naam', 'Tomatensaus')->first()->id,
                Ingredient::where('naam', 'Salami')->first()->id,
            ]);
    }
}
