<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Ingredient;

use Illuminate\Http\Request;

class PizzaController extends Controller
{
 //pizza controller
    public function index()
    {
       $pizzas = Pizza::with('ingredients')->get();
    $ingredients = Ingredient::all();
       return view('menu', compact('pizzas', 'ingredients'));
        
    }
}
