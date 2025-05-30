<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use  App\Models\Pizza;
use App\Http\Controllers\Pizzacontroller;

class Winkelwagentjecontroller extends Controller
{
public function index()
{
    $cart = session()->get('cart', []);
    $updated = false;

    $statusFlow = [
        'Betaald'   => 'Bereiden',
        'Bereiden'  => 'InOven',
        'InOven'    => 'Onderweg',
        'Onderweg'  => 'Bezorgd'
    ];

    foreach ($cart as &$item) {
        if (!isset($item['status']) || in_array($item['status'], ['Geannuleerd', 'Bezorgd'])) {
            continue;
        }

        if (!isset($item['status_updated_at'])) {
            $item['status_updated_at'] = time(); // set initial timestamp
        }

        $currentStatus = $item['status'];

        if (isset($statusFlow[$currentStatus])) {
            $nextStatus = $statusFlow[$currentStatus];

            if ((time() - $item['status_updated_at']) >= 10) {
                $item['status'] = $nextStatus;
                $item['status_updated_at'] = time(); // reset timer for next step
                $updated = true;
            }
        }
    }

    if ($updated) {
        session(['cart' => $cart]);
    }

    return view('winkelwagentje', compact('cart'));
}



    public function remove(Request $request)
{
    $id = $request->input('id');
    $cart = session()->get('cart', []);

    // Rebuild cart without the item with the matching ID
    $cart = array_filter($cart, function ($item) use ($id) {
        return $item['id'] != $id;
    });

    // Reset the array keys to avoid gaps (important for display loops)
    $cart = array_values($cart);

    session(['cart' => $cart]);

    return redirect()->route('winkelwagentje.index')->with('success', 'Pizza verwijderd uit winkelwagentje.');
}



public function store(Request $request)
{
 // Validate required fields
$request->validate([
    'pizza_id' => 'required|exists:pizzas,id',
    'groote' => 'required|numeric',
]);

$pizza = Pizza::findOrFail($request->pizza_id);
$factor = floatval($request->input('groote', 1));

// Handle selected ingredient IDs
$ingredientIds = $request->input('ingredients', []);
$ingredients = Ingredient::whereIn('id', $ingredientIds)->get();

$ingredientCost = $ingredients->sum('prijs');

$cartItem = [
    'id' => $pizza->id,
    'naam' => $pizza->naam,
    'prijs' => $pizza->prijs ?? 0, // fallback if prijs is null
    'groote' => $factor,
    'ingredients' => $ingredients->map(function ($ingredient) {
        return [
            'id' => $ingredient->id,
            'naam' => $ingredient->naam,
            'prijs' => $ingredient->prijs,
        ];
    })->toArray(),
    'ingredientCost' => $ingredientCost,
    'status' => 'Initieel', // Default status
];

// Add to cart in session
$cart = session()->get('cart', []);
$cart[] = $cartItem;
session(['cart' => $cart]);

return redirect()->route('winkelwagentje.index')->with('success', 'Pizza toegevoegd aan je winkelwagentje!');





}
public function betaal(Request $request)
{
    $id = $request->input('id');
    $cart = session()->get('cart', []);

    foreach ($cart as &$item) {
        if ($item['id'] == $id && $item['status'] === 'Initieel') {
            $item['status'] = 'Betaald';
            $item['status_updated_at'] = time(); // start status timer
            break;
        }
    }

    session(['cart' => $cart]);

    return redirect()->route('winkelwagentje.index')->with('success', 'Bestelling betaald!');
}


public function annuleer(Request $request)
{
    $id = $request->input('id');
    $cart = session()->get('cart', []);

    foreach ($cart as &$item) {
        if ($item['id'] == $id && !in_array($item['status'], ['Geannuleerd', 'Bezorgd'])) {
            $item['status'] = 'Geannuleerd';
            break;
        }
    }

    session(['cart' => $cart]);

    return redirect()->route('winkelwagentje.index')->with('success', 'Bestelling geannuleerd.');
}


}