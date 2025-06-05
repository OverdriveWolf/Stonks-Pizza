@extends('layouts.app-layout')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('menustyle.css') }}">
</head>

<div class="min-h-screen flex flex-col">
    <!-- Navbar -->

   <header class="bg-blue-800 text-white p-4 text-center text-xl font-bold"> <span>Bestellingen </span> </header>
<hr>
    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside class="w-1/5 bg-blue-700 text-white flex flex-col items-center p-4">
            <div class="mb-4 w-full text-center">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <form action="{{ route('winkelwagentje.store') }}" method="POST" class="bg-white p-6 rounded shadow-md w-full max-w-lg">
                @csrf

<h3 class="text-lg font-semibold mb-4">Kies je pizza</h3>
<div class="pizza-grid">
    @foreach ($pizzas as $pizza)
        <label class="pizza-card">
            <input
                type="radio"
                name="selected_pizza"
                value="{{ $pizza->id }}"
                onclick="selectIngredients({{ $pizza->id }}, '{{ $pizza->naam }}', '{{ $pizza->prijs }}')"
                class="hidden"
            >
              <img src="{{ asset('Margherita.png') }}" alt="{{ $pizza->naam }}" class="pizza-image">
            <div class="pizza-info">
                <h4>{{ $pizza->naam }}</h4>
                <p>€{{ number_format($pizza->prijs, 2) }}</p>
            </div>
        </label>
    @endforeach
</div>

                <!-- Hidden fields -->
                <input type="hidden" name="pizza_id" id="selectedPizzaId">
                <input type="hidden" name="pizza_name" id="selectedPizzaName">
                <input type="hidden" name="pizza_prijs" id="selectedPizzaPrice">

                <!-- Size Selection -->
            <div class="mb-2">
                <label class="block text-sm font-medium">Grootte</label>
                <div class="space-y-1">
                    <label><input type="radio" name="grootte" value="0.8"> Klein (20cm)</label><br>
                    <label><input type="radio" name="grootte" value="1" checked> Medium (25cm)</label><br>
                    <label><input type="radio" name="grootte" value="1.2"> Groot (30cm)</label>
                </div>
            </div>

                <!-- Ingredients -->
                <div class="mb-4" id="ingredients-section" style="display: none;">
                    <label class="block text-sm font-medium">Ingrediënten</label>
                    <div class="ingredients-container" id="ingredients-list">
                        @foreach ($ingredients as $ingredient)
                            <label class="ingredient-option block">
                                <input
                                    type="checkbox"
                                    name="ingredients[]"
                                    value="{{ $ingredient->id }}"
                                    id="ingredient-{{ $ingredient->id }}"
                                >
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
                    <label class="block font-medium">Adres</label>
                    <input type="text" name="adres" class="w-full border px-3 py-2 rounded" required>
                </div>

                 <div class="mb-4">
                    <label class="block font-medium">Woonplaats</label>
                    <input type="text" name="woonplaats" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block font-medium">E-mail</label>
                    <input type="email" name="email" class="w-full border px-3 py-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Telefoonnummer</label>
                    <input type="tel" name="telefoonnummer" class="w-full border px-3 py-2 rounded" required>
                </div>

                <button type="submit" class="w-full bg-blue-800 text-white py-2 rounded font-semibold">
                    Bestellen
                </button>
            </form>
        </main>
    </div>

    
</div>

<div class="layout">
<main class="main">
    <div class="center-box">
         </main>
    </div>
 </main>

<footer class="footer">@include('layouts.footer')</footer>
</div>
<script>
    const pizzaIngredients = @json($pizzas->mapWithKeys(function ($pizza) {
        return [$pizza->id => $pizza->ingredients->pluck('id')];
    }));

    function selectIngredients(pizzaId, pizzaName, pizzaPrice) {
        document.getElementById('ingredients-section').style.display = 'block';

        // Reset all ingredients
        document.querySelectorAll('input[name="ingredients[]"]').forEach(cb => cb.checked = false);

        // Check relevant ingredients
        (pizzaIngredients[pizzaId] || []).forEach(id => {
            const checkbox = document.getElementById('ingredient-' + id);
            if (checkbox) checkbox.checked = true;
        });

        // Set hidden inputs
        document.getElementById('selectedPizzaId').value = pizzaId;
        document.getElementById('selectedPizzaName').value = pizzaName;
        document.getElementById('selectedPizzaPrice').value = pizzaPrice; 

    }
</script>
@endsection