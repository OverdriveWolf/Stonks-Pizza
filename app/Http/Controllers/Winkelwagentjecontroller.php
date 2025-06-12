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
        //dd($request->all());
        $data = $request->validate([
            'pizza_id' => 'required|exists:pizzas,id',
            'grootte' => 'required|string|max:255',
            'naam' => 'required|string|max:255',
            'adres' => 'required|string|max:255',
            'woonplaats' => 'required|string|max:255',
            'email' => 'required|email',
            'telefoonnummer' => 'required|string|max:20',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
        ]);

        // Size multipliers
        $afmeting = strtolower(trim($data['grootte']));
$sizeMultipliers = [
    'klein' => 0.8,
    'normaal' => 1,
    'groot' => 1.2,
];
$multiplier = $sizeMultipliers[$afmeting] ?? 1.25; // fallback


        // Customer creation
        $customer = new Customer();
        $customer->naam = $data['naam'];
        $customer->adres = $data['adres'];
        $customer->woonplaats = $data['woonplaats'];
        $customer->email = $data['email'];
        $customer->telefoon = $data['telefoonnummer'];
        $customer->save();

        // Order creation
        $order = new Order();
        $order->customer_id = $customer->id;
        $order->status = 'Initieel';
        $order->datum = now();
        $order->save();

        // Bestelregel creation
        $pizza = Pizza::findOrFail($data['pizza_id']);

        $bestelregel = new Bestelregel();
        $bestelregel->order_id = $order->id;
        $bestelregel->pizza_id = $pizza->id;
        $bestelregel->aantal = 1;
        $bestelregel->afmeting = $afmeting; // Save the size
        $bestelregel->prijs = $pizza->prijs * $multiplier;
        $bestelregel->save();

        // Attach ingredients
        if (!empty($data['ingredients'])) {
            $pizza->ingredients()->syncWithoutDetaching($data['ingredients']);
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
