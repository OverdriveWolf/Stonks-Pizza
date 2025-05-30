<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bestelling;
use App\Models\Pizza;
use App\Models\Ingredient;
class BestellingController extends Controller
{
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