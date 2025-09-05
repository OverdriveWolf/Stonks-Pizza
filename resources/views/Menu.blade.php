@extends('layouts.app-layout')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('menustyle.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<div class="min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-blue-800 text-white p-4 text-center text-xl font-bold">Bestellingen</header>
    <hr>

    <main class="p-8 flex flex-col lg:flex-row gap-8">

        <!-- Order Form -->
        <form action="{{ route('winkelwagentje.store') }}" method="POST" class="bg-white p-6 rounded shadow-md w-full max-w-3xl">
            @csrf
            <h2 class="menu-heading">Our Menu</h2>



          <div class="pizza-grid">
                @foreach ($pizzas as $pizza)
                
                    <label class="pizza-card cursor-pointer">
                        <input type="radio"
                               name="selected_pizza"
                               value="{{ $pizza->id }}"
                               onclick='selectIngredients({{ $pizza->id }}, @json($pizza->naam), @json($pizza->prijs))'
                               class="hidden">
                        <img src="{{ asset('Margherita.png') }}" alt="{{ $pizza->naam }}" class="pizza-thumb">
                        <div class="pizza-details">
                            <h4>{{ $pizza->naam }}</h4>
                            <p class="description">Fresh ingredients & delicious flavor</p>
                            <p class="description">€{{ number_format($pizza->prijs, 2) }}</p>
                              <div class="mb-4 mt-6">
                <label class="block font-medium">Grootte</label>
                <div class="space-y-1">
                    <label><input type="radio" name="grootte" value="klein"> Klein (20cm)</label><br>
                    <label><input type="radio" name="grootte" value="normaal"x> Medium (25cm)</label><br>
                    <label><input type="radio" name="grootte" value="groot"> Groot (30cm)</label>
                </div>
            </div>
                        </div>
                    </label>
                @endforeach
                </div>     

            <!-- Hidden fields -->
            <input type="hidden" name="pizza_id" id="selectedPizzaId">
            <input type="hidden" name="pizza_name" id="selectedPizzaName">
            <input type="hidden" name="pizza_prijs" id="selectedPizzaPrice">

            <!-- Size Selection -->
          

            <!-- Ingredients -->
            <div class="mb-4" id="ingredients-section" style="display: none;">
                <label class="block font-medium mb-2">Ingrediënten</label>
                <div class="ingredients-container" id="ingredients-list">
                    @foreach ($ingredients as $ingredient)
                        <label class="ingredient-option">
                            <input type="checkbox" name="ingredients[]" value="{{ $ingredient->id }}" id="ingredient-{{ $ingredient->id }}">
                            {{ $ingredient->naam }} (€{{ number_format($ingredient->prijs, 2) }})
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Customer Info -->
            <div class="mb-4">
                <label class="block font-medium">Naam</label>
                <input type="text" name="naam" class="w-full border px-3 py-2 rounded" required>
            </div>

             <div class="mb-4">
                <label class="block font-medium">Woonplaats</label>
                <input type="text" name="woonplaats" class="w-full border px-3 py-2 rounded" required>
            </div>
            
            <div class="mb-4">
                <label class="block font-medium">Adres</label>
                <input type="text" name="adres" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium">E-mail</label>
                <input type="email" name="email" class="w-full border px-3 py-2 rounded" required>
            </div>

      <div class="mb-4">
    <label class="block font-medium">Telefoonnummer</label>
    <input 
        type="tel" 
        name="telefoonnummer"  
        class="w-full border px-3 py-2 rounded" 
        required
        pattern="^\+?[0-9]{9,15}$"
        title="Voer een geldig telefoonnummer in (bijv. +31612345678 of 0612345678)">
</div>


            <button type="submit" class="add-btn w-full">Bestellen</button>
        </form>
    </main>

    <footer class="footer">@include('layouts.footer')</footer>
</div>

<script>

    const pizzaIngredients = @json($pizzas->mapWithKeys(function ($pizza) {
        return [$pizza->id => $pizza->ingredients->pluck('id')];
    }));

 function selectIngredients(pizzaId, pizzaName, pizzaPrice) {
    document.getElementById('ingredients-section').style.display = 'block';

    // Reset all checkboxes
    document.querySelectorAll('input[name="ingredients[]"]').forEach(cb => {
        cb.checked = false;
        cb.disabled = false; // make sure user can change freely
    });

    // Pre-check the defaults, but mark them as non-editable if you want
    (pizzaIngredients[pizzaId] || []).forEach(id => {
        const checkbox = document.getElementById('ingredient-' + id);
        if (checkbox) {
            checkbox.checked = true;
            // Optional: lock them so they can’t be unchecked
            // checkbox.disabled = true;
        }
    });

    // Update hidden fields for this order only
    document.getElementById('selectedPizzaId').value = pizzaId;
    document.getElementById('selectedPizzaName').value = pizzaName;
    document.getElementById('selectedPizzaPrice').value = pizzaPrice;
}

</script>
@endsection
