@extends('layouts.app-layout')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('menustyle.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<div class="min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-blue-800 text-white p-4 text-center text-xl font-bold">
        Bestel je pizza {{ $pizza->naam }}
    </header>
    <hr>

    <main class="p-8 flex flex-col lg:flex-row gap-8 justify-center">
        <!-- Order Form -->
        <form action="{{ route('quickOrder.store', $pizza->id) }}" method="POST" class="bg-white p-6 rounded shadow-md w-full max-w-3xl">
            @csrf
            <div class="flex items-center gap-6 mb-6">
                <img src="{{ asset('Margherita.png') }}" alt="{{ $pizza->naam }}" class="w-32 h-32 object-cover rounded">
                <div>
                    <h2 class="text-2xl font-bold">{{ $pizza->naam }}</h2>
                    <p class="text-gray-600">Vers en heerlijk bereid</p>
                    <p class="text-lg font-semibold mt-2">€{{ number_format($pizza->prijs, 2) }}</p>
                </div>
            </div>

            <!-- Size Selection -->
            <div class="mb-6">
                <label class="block font-medium mb-2">Grootte</label>
                <div class="space-y-1">
                    <label><input type="radio" name="grootte" value="klein"> Klein (20cm)</label><br>
                    <label><input type="radio" name="grootte" value="normaal" checked> Medium (25cm)</label><br>
                    <label><input type="radio" name="grootte" value="groot"> Groot (30cm)</label>
                </div>
            </div>

            <!-- ✅ Hidden Default Ingredients -->
            @foreach ($pizza->ingredients as $ingredient)
                <input type="hidden" name="ingredients[]" value="{{ $ingredient->id }}">
            @endforeach

            <!-- ✅ Extra Ingredients (Visible to customer) -->
            <div class="mb-6">
                <label class="block font-medium mb-2">Extra Ingrediënten</label>
                <div class="ingredients-container space-y-1">
                    @foreach ($ingredients as $ingredient)
                        @if (!$pizza->ingredients->contains($ingredient->id))
                            <!-- <label class="ingredient-option block">
                                <input type="checkbox" name="ingredients[]" value="{{ $ingredient->id }}">
                                {{ $ingredient->naam }} (€{{ number_format($ingredient->prijs, 2) }})
                            </label> -->
                        @endif
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

            <div class="mb-6">
                <label class="block font-medium">Telefoonnummer</label>
                <input 
                    type="tel" 
                    name="telefoonnummer"  
                    class="w-full border px-3 py-2 rounded" 
                    required
                    pattern="^\+?[0-9]{9,15}$"
                    title="Voer een geldig telefoonnummer in (bijv. +31612345678 of 0612345678)">
            </div>
            <br>
            <button type="submit" class="add-btn w-full">Bestellen</button>
        </form>
    </main>

    <footer class="footer">@include('layouts.footer')</footer>
</div>
@endsection
