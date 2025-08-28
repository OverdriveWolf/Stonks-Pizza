<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\Bestelregel;
use App\Models\Customer;
use App\Models\Bestelling; // Assuming this is the model for bestelregels
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
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
            $elapsed = Carbon::parse($order->updated_at)->diffInSeconds(now());

            if (in_array($order->status, ['Bezorgd', 'Geannuleerd']) && $elapsed >= 10) {
                $order->delete(); // Cascade deletes bestelregels
                continue;
            }

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
    $data = $request->validate([
        'pizza_id' => 'required|exists:pizzas,id',
        'grootte' => 'required|string|max:255',
        'naam' => 'required|string|max:255',
        'woonplaats' => 'required|string|max:255',
        'adres' => 'required|string|max:255',
        'email' => 'required|email',
        'telefoonnummer' => [
            'required',
            'regex:/^\+?[0-9]{9,15}$/'
        ],
        'ingredients' => 'array',
        'ingredients.*' => 'exists:ingredients,id',
    ]);

    // Size multipliers
    $afmeting = strtolower(trim($data['grootte']));
    $sizeMultipliers = [
        'klein' => 1,
        'normaal' => 1.25,
        'groot' => 1.5,
    ];
    $multiplier = $sizeMultipliers[$afmeting] ?? 1.25;

    // Customer creation
    $customer = Customer::create([
        'naam' => $data['naam'],
        'woonplaats' => $data['woonplaats'],
        'adres' => Crypt::encrypt($data['adres']),
        'email' => Crypt::encrypt($data['email']),
        'telefoon' => Crypt::encrypt($data['telefoonnummer']),
    ]);

    // Order creation
  $order = new Order(); 
  $order->customer_id = $customer->id; 
  $order->status = 'Initieel'; 
  $order->datum = now(); $order->save();

    // Bestelregel creation
    $pizza = Pizza::findOrFail($data['pizza_id']);

    $bestelregel = Bestelregel::create([
        'order_id' => $order->id,
        'pizza_id' => $pizza->id,
        'aantal' => 1,
        'afmeting' => $afmeting,
        'prijs' => $pizza->prijs * $multiplier,
    ]);

    // ✅ Attach selected ingredients to the bestelregel (not the pizza!)
    if (!empty($data['ingredients'])) {
        $bestelregel->ingredients()->sync($data['ingredients']);
    }

    return redirect()->back()->with('success', 'Bestelling geplaatst!');
}
public function addPizza(Request $request)
{
    $data = $request->validate([
        'order_id' => 'required|exists:orders,id',
        'pizza_id' => 'required|exists:pizzas,id',
        'grootte' => 'required|string',
        'ingredients' => 'nullable|string',
    ]);

    $order = Order::findOrFail($data['order_id']);
    $pizza = Pizza::findOrFail($data['pizza_id']);

    // Size multipliers
    $sizeMultipliers = [
        'klein' => 0.8,
        'normaal' => 1,
        'groot' => 1.2,
    ];
    $multiplier = $sizeMultipliers[strtolower($data['grootte'])] ?? 1;

    // Create a new bestelregel
    $bestelregel = new Bestelregel();
    $bestelregel->order_id = $order->id;
    $bestelregel->pizza_id = $pizza->id;
    $bestelregel->aantal = 1;
    $bestelregel->afmeting = $data['grootte'];
    $bestelregel->prijs = $pizza->prijs * $multiplier;
    $bestelregel->save();

    // Attach same ingredients if given
    if (!empty($data['ingredients'])) {
        $ingredientIds = explode(',', $data['ingredients']);
        $bestelregel->ingredients()->sync($ingredientIds);
    }

    return redirect()->back()->with('success', 'Pizza toegevoegd aan bestelling!');
}

public function removePizza(Request $request)
{
    $data = $request->validate([
        'regel_id' => 'required|exists:bestelregels,id',
    ]);

    $regel = Bestelregel::findOrFail($data['regel_id']);

    // if aantal > 1, decrement. Otherwise delete.
    if ($regel->aantal > 1) {
        $regel->aantal -= 1;
        $regel->save();
    } else {
        $regel->delete();
    }

    return redirect()->back()->with('success', 'Pizza verwijderd!');
}

   public function betaal(Request $request)
{
    $orderIds = $request->input('ids', []);

    foreach ($orderIds as $id) {
        $order = Bestelling::find($id);
        if ($order && $order->status === 'Initieel') {
            $order->status = 'Betaald'; // or whatever status you use
            $order->save();
        }
    }

    return redirect()->route('winkelwagentje.index')->with('success', 'Alle bestellingen zijn betaald!');
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
