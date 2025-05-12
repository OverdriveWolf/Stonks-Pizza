<?php

namespace App\Http\Controllers;

use App\Models\Pizza;

use Illuminate\Http\Request;

class Pizzacontroller extends Controller
{
    public function index()
    {
        $pizzas = Pizza::all(); // or a filtered list if needed
        return view('welcome', compact('pizzas')); // assumes you saved your Blade file as resources/views/menu.blade.php
    }
}
