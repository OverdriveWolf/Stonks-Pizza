

@extends('layouts.app-layout')

@section('content')
<head>
<link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>
<div class="container mx-auto pt-[100px] px-6">
    <h1 class="text-3xl font-bold mb-6">Winkelwagentje</h1>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-1">
        {{-- Sidebar with Logo --}}
        <aside class="w-1/5 bg-blue-700 text-white flex flex-col items-center p-4">
            <div class="mb-4 w-full text-center">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">
            </div>
        </aside>

        <div class="layout w-4/5 px-6">
            @if (empty($cart) || count($cart) === 0)
                <p class="text-gray-600">Je winkelwagentje is leeg.</p>
            @else
                <table class="w-full text-left border-collapse bg-white shadow rounded overflow-hidden">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="border-b p-2">Naam</th>
                            <th class="border-b p-2">Ingrediënten</th>
                            <th class="border-b p-2">Basisprijs</th>
                            <th class="border-b p-2">Grootte</th>
                            <th class="border-b p-2">Status</th>
                            <th class="border-b p-2">Voortgang</th>
                            <th class="border-b p-2">Subtotaal</th>
                            <th class="border-b p-2">Actie</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totaal = 0; @endphp
                        @foreach ($cart as $item)
                            @php
                            
                                $factor = $item['groote'] ?? 1;
                                $ingredientCost = $item['ingredientCost'] ?? 0;
                                $adjustedPrice = $item['prijs'] * $factor;
                                $subtotaal = $adjustedPrice + $ingredientCost;
                                $totaal += $subtotaal;
                            @endphp
                            <tr class="hover:bg-gray-100">
                                <td class="border-b p-2 font-semibold">{{ $item['naam'] }}</td>
                                <td class="border-b p-2">
                                    @if (!empty($item['ingredients']))
                                        <ul class="list-disc list-inside">
                                            @foreach ($item['ingredients'] as $ingredient)
                                                <li>{{ $ingredient['naam'] }} (€{{ number_format($ingredient['prijs'], 2) }})</li>
                                            @endforeach
                                        </ul>
                                        
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border-b p-2">€{{ number_format($item['prijs'], 2) }}</td>
                                <td class="border-b p-2">
                                    {{ $factor == 0.8 ? 'Klein' : ($factor == 1.2 ? 'Groot' : 'Medium') }}
                                </td>
                                <td class="border-b p-2">
    <span class="px-2 py-1 rounded-full text-sm 
            $item['status'] === 'Initieel' ? 'bg-gray-200 text-gray-800' : 
            ($item['status'] === 'Betaald' ? 'bg-blue-200 text-blue-800' : 
            ($item['status'] === 'Bereiden' ? 'bg-orange-200 text-orange-800' : 
            ($item['status'] === 'InOven' ? 'bg-purple-200 text-purple-800' : 
            ($item['status'] === 'Onderweg' ? 'bg-teal-200 text-teal-800' : '')))))
          
            // Dynamically set the class based on status
            $item['status'] === 'Geannuleerd' ? 'bg-red-200 text-red-800' : 
            ($item['status'] === 'Bezorgd' ? 'bg-green-200 text-green-800' : ''))

        }}">
        {{ $item['status'] ?? 'Onbekend' }}
    </span>
</td>

<td class="border-b p-2">
    @php
        $statuses = ['Initieel', 'Betaald', 'Bereiden', 'InOven', 'Onderweg', 'Bezorgd', 'Geannuleerd'];
        // Determine the current step based on the status
        // If status is not found, default to 'Initieel'
        $status = $item['status'] ?? 'Initieel'; // default fallback
        $currentStep = array_search($status, $statuses);
        $progressPercent = $currentStep !== false ? ($currentStep / (count($statuses) - 1)) * 100 : 0;
    @endphp

    <div class="w-full bg-gray-200 rounded h-2">
        <div class="bg-blue-500 h-2 rounded" style="width: {{ $progressPercent }}%"></div>
    </div>
</td>
                                <td class="border-b p-2">€{{ number_format($subtotaal, 2) }}</td>
                                <td class="border-b p-2">
                                 <form action="{{ route('winkelwagentje.remove') }}" method="POST">
                                @csrf
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Verwijder</button>
                                </form>

                                        @if (!in_array($item['status'], ['Bezorgd', 'Geannuleerd']))
        <form action="{{ route('bestelling.annuleer') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $item['id'] }}">
    <button class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 w-full">Annuleer</button>
</form>

        
    @endif
    @if ($item['status'] === 'Initieel')
    <form action="{{ route('bestelling.betaal') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $item['id'] }}">
        <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 w-full mt-1">
            Betaal
        </button>
    </form>
@endif

</td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-blue-50">
                        <tr>
                            <td colspan="4" class="p-2 font-bold text-right">Totaal:</td>
                            <td colspan="2" class="p-2 font-bold">€{{ number_format($totaal, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            @endif
        </div>
    </div>

    <footer class="footer"> @include('layouts.footer')</footer>
</div>
  @if ($item['status'] !== 'Bezorgd')
<script>

    setInterval(() => {
        window.location.reload();
    }, 10000);
  
</script>
  @endif
@endsection
