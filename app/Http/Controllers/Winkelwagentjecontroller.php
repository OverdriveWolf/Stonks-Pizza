<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\Bestelregel;
use App\Models\Bestelling; // Assuming Bestelling is an alias for Order
use App\Models\Customer;
use Carbon\Carbon;

class Winkelwagentjecontroller extends Controller
{
   public function index()
{
    $orders = Order::with(['bestelregels.pizza'])->get();

    $statusFlow = [
        'Betaald'   => 'Bereiden',
        'Bereiden'  => 'InOven',
        'InOven'    => 'Onderweg',
        'Onderweg'  => 'Bezorgd',
    ];

    foreach ($orders as $order) {
        $elapsed = \Carbon\Carbon::parse($order->updated_at)->diffInSeconds(now());

        // If order is Bezorgd or Geannuleerd for 10+ seconds, delete it
        if (in_array($order->status, ['Bezorgd', 'Geannuleerd']) && $elapsed >= 10) {
            $order->delete(); // Cascade should remove related bestelregels
            continue; // Skip processing deleted order
        }

        // Auto-progress logic
        if (!in_array($order->status, ['Bezorgd', 'Geannuleerd']) && $elapsed >= 10) {
            if (isset($statusFlow[$order->status])) {
                $order->status = $statusFlow[$order->status];
                $order->save();
            }
        }
    }

        return view('winkelwagentje', compact('orders'));
    }



public function store(Request $request)
{
    //dd($request->all());
    // Step 1: Validate input
    $data = $request->validate([
        'pizza_id' => 'required|exists:pizzas,id',
        'grootte' => 'required|numeric',
        'naam' => 'required|string|max:255',
        'adres' => 'required|string|max:255',
        'woonplaats' => 'required|string|max:255',
        'email' => 'required|email',
        'telefoonnummer' => 'required|string|max:20',
        'ingredients' => 'array',
        'ingredients.*' => 'exists:ingredients,id',
    ]);

    // Step 2: Save customer
    $customer = new \App\Models\Customer();
    $customer->naam = $data['naam'];
    $customer->adres = $data['adres'];
    $customer->woonplaats = $data['woonplaats'];
    $customer->email = $data['email'];
    $customer->telefoon = $data['telefoonnummer'];
    $customer->save();

    // Step 3: Create order for this customer
    $order = new \App\Models\Order();
    $order->customer_id = $customer->id;
    $order->status = 'Initieel';
    $order->datum = now();

    $order->save();

    // Step 4: Create bestelregel (line item for pizza)
    $pizza = \App\Models\Pizza::findOrFail($data['pizza_id']);

    $bestelregel = new \App\Models\Bestelregel();
    $bestelregel->order_id = $order->id;
    $bestelregel->aantal = 1; // Assuming one pizza per order for simplicity
    $bestelregel->pizza_id = $pizza->id;
    $bestelregel->prijs = $pizza->prijs * $data['grootte']; // price adjusted by size
    $bestelregel->save();

    // Step 5: Attach ingredients to the pizza (if any)
    if (!empty($data['ingredients'])) {
        $pizza->ingredients()->syncWithoutDetaching($data['ingredients']);
        // NOTE: this does not affect existing ingredients unless the pivot is being reused
    }

    return redirect()->back()->with('success', 'Bestelling geplaatst!');
}



public function betaal(Request $request)
    {
        $order = Order::findOrFail($request->id);

        if ($order->status === 'Initieel') {
            $order->status = 'Betaald';
            $order->updated_at = now();
            $order->save();
        }

        return redirect()->route('winkelwagentje.index')->with('success', 'Bestelling betaald!');
    }

public function annuleer(Request $request)
    {
        $order = Order::findOrFail($request->id);

        if (!in_array($order->status, ['Bezorgd', 'Geannuleerd'])) {
            $order->status = 'Geannuleerd';
            $order->save();
        }

        return redirect()->route('winkelwagentje.index')->with('success', 'Bestelling geannuleerd.');
    }


public function remove(Request $request)
{
    
 $regel = Bestelling::find($request->id);


    if ($regel) {
        $regel->delete();
        return redirect()->back()->with('success', 'Bestelregel verwijderd.');
    }

    return redirect()->back()->with('error', 'Bestelregel niet gevonden.');

}

}
