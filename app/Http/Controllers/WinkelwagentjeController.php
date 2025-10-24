<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\Bestelregel;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
class WinkelwagentjeController extends Controller
{
    public function index()
    {
        $orders = Order::with(['bestelregels.pizza'])->get();

        $statusFlow = [
            'Betaald' => 'Bereiden',
            'Bereiden' => 'InOven',
            'InOven' => 'Onderweg',
            'Onderweg' => 'Bezorgd',
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
        $order->datum = now();
        $order->save();

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
    public function increment(Request $request)
    {
        $data = $request->validate([
            'regel_id' => 'required|exists:bestelregels,id',
        ]);

        $regel = Bestelregel::findOrFail($data['regel_id']);
        $regel->aantal += 1;
        $regel->save();

        return redirect()->back()->with('success', 'Pizza toegevoegd!');
    }

 public function decrement(Request $request)
{
    $data = $request->validate([
        'regel_id' => 'required|exists:bestelregels,id',
    ]);

    $regel = Bestelregel::findOrFail($data['regel_id']);

    if ($regel->aantal > 1) {
        // Reduce amount and update price
        $regel->aantal -= 1;
        $regel->save();
    } else {
        // Delete the bestelregel
        $orderId = $regel->order_id;
        $regel->delete();

        // ✅ If the parent order has no more bestelregels, remove the order too
        $order = Order::withCount('bestelregels')->find($orderId);
        if ($order && $order->bestelregels_count === 0) {
            $order->delete();
        }
    }

    return redirect()->back()->with('success', 'Pizza verwijderd!');
}



    public function betaal(Request $request)
    {
        $orderIds = $request->input('ids', []);

        foreach ($orderIds as $id) {
            $order = order::find($id);
            if ($order && $order->status === 'Initieel') {
                $order->status = 'Betaald'; // or whatever status you use
                $order->save();
            }
        }

        return redirect()->route('winkelwagentje.index')->with('success', 'Alle bestellingen zijn betaald!');
    }

    public function remove(Request $request)
    {
        $order = Order::find($request->id);

        if ($order) {
            $order->delete(); // cascades to bestelregels
            return redirect()
                ->route('winkelwagentje.index')
                ->with('success', 'Bestelling verwijderd.');
        }

        return redirect()
            ->route('winkelwagentje.index')
            ->with('error', 'Bestelling niet gevonden.');
    }

    public function quickOrderForm(Pizza $pizza)
    {
        $ingredients = Ingredient::all();

        return view('quick-order', compact('pizza', 'ingredients'));
    }

    public function quickOrderStore(Request $request, Pizza $pizza)
    {
        $data = $request->validate([
            'grootte' => 'required|string|max:255',
            'naam' => 'required|string|max:255',
            'woonplaats' => 'required|string|max:255',
            'adres' => 'required|string|max:255',
            'email' => 'required|email',
            'telefoonnummer' => ['required', 'regex:/^\+?[0-9]{9,15}$/'],
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
        ]);

        // Size multipliers
        $sizeMultipliers = [
            'klein' => 1,
            'normaal' => 1.25,
            'groot' => 1.5,
        ];
        $afmeting = strtolower(trim($data['grootte']));
        $multiplier = $sizeMultipliers[$afmeting] ?? 1.25;

        // Create customer
        $customer = Customer::create([
            'naam' => $data['naam'],
            'woonplaats' => $data['woonplaats'],
            'adres' => Crypt::encrypt($data['adres']),
            'email' => Crypt::encrypt($data['email']),
            'telefoon' => Crypt::encrypt($data['telefoonnummer']),
        ]);

        // Create order
        $order = new Order();
        $order->customer_id = $customer->id;
        $order->status = 'Initieel';
        $order->datum = now();
        $order->save();

        // Create bestelregel
        $bestelregel = Bestelregel::create([
            'order_id' => $order->id,
            'pizza_id' => $pizza->id,
            'aantal' => 1,
            'afmeting' => $afmeting,
            'prijs' => $pizza->prijs * $multiplier,
        ]);

        if (!empty($data['ingredients'])) {
            $bestelregel->ingredients()->sync($data['ingredients']);
        }

        return redirect()->route('winkelwagentje.index')->with('success', 'Pizza besteld!');
    }

}

