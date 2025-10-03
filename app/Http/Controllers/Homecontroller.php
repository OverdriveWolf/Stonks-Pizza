<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Ingredient;


class Homecontroller extends Controller
{
    public function index()
    {
       $pizzas = Pizza::with('ingredients')->get();
    $ingredients = Ingredient::all();
       return view('home', compact('pizzas', 'ingredients'));
        
    }
}
