<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Ingredient;


class HomeController extends Controller
{
   //home controller
    public function index()
    {
       $pizzas = Pizza::with('ingredients')->get();
    $ingredients = Ingredient::all();
       return view('home', compact('pizzas', 'ingredients'));
        
    }
}
