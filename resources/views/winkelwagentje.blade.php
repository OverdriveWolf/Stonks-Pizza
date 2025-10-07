@extends('layouts.app-layout')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('orderstyle.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


    <div class="cart-container">
        <h1 class="cart-title">🍕 Your Cart</h1>

        <div class="cart-grid">
            {{-- Left Side – Order Items --}}
            <div class="cart-items">
                @if ($orders->isEmpty())
                    <div class="empty-cart">Je winkelwagentje is leeg.</div>
                @else
                    @foreach ($orders as $order)
                        <div class="order-card">
                            <h2 class="order-title">Bestelling #{{ $order->id }} - Status: {{ $order->status }}</h2>

                            @php $orderTotaal = 0; @endphp

                            @foreach ($order->bestelregels as $regel)
                                @php
                                    $pizza = $regel->pizza;
                                    $afmeting = strtolower(trim($regel->afmeting ?? 'normaal'));
                                    $sizeMultiplier = ['klein' => 1.0, 'normaal' => 1.25, 'groot' => 1.5];
                                    $multiplier = $sizeMultiplier[$afmeting] ?? 1.25;
                                    $basePrijs = $pizza->prijs ?? 0;
                                    $prijs = $basePrijs * $multiplier;
                                    $subtotaal = $prijs * $regel->aantal;
                                    $orderTotaal += $subtotaal;
                                @endphp

                                <div class="item-row">
                                    <img src="{{ asset('Margherita.png') }}" alt="{{ $pizza->naam }}" class="pizza-image">
                                    <div class="item-details">
                                        <div class="item-name">{{ $pizza->naam }}</div>
                                        <div class="item-size"><strong>Maat:</strong> {{ ucfirst($afmeting) }}</div>
                                        <div class="item-ingredients">
                                            {{ $regel->ingredients?->pluck('naam')->join(', ') ?? 'Geen ingrediënten' }}
                                        </div>
                                        <div class="item-info">
                                            Aantal: {{ $regel->aantal }} | Subtotaal: €{{ number_format($subtotaal, 2) }}
                                        </div>
                                    </div>
                                    <div class="item-actions">
                                        
                                        </form>

                           @if ($order->status === 'Initieel')
    @foreach ($order->bestelregels as $regel)
        <div class="cart-item flex justify-between items-center p-2 border-b">
  
      

            <div class="actions">
                <!-- Add one -->
                <form action="{{ route('winkelwagentje.increment') }}" method="POST" style="display:inline;">
                    @csrf
                    <input type="hidden" name="regel_id" value="{{ $regel->id }}">
                    <button type="submit" class="btn btn-add">➕</button>
                </form>

                <!-- Remove one -->
                <form action="{{ route('winkelwagentje.decrement') }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="regel_id" value="{{ $regel->id }}">
                    <button type="submit" class="btn btn-remove">➖</button>
                </form>
            </div>
        </div>
    @endforeach
@endif



                                    </div>
                                </div>
                            @endforeach

                         <!-- <div class="order-total">Totaal: €{{ number_format($orderTotaal, 2) }}</div> -->
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Right Side – Summary --}}
            <div class="cart-summary">
                <h2 class="summary-title">Order Summary</h2>

                @php
                    $cartTotaal = 0;
                    $sizeMultiplier = ['klein' => 1.0, 'normaal' => 1.25, 'groot' => 1.5];

                    foreach ($orders as $order) {
                        foreach ($order->bestelregels as $regel) {
                            $pizza = $regel->pizza;
                            $size = strtolower(trim($regel->afmeting ?? 'normaal'));
                            $multiplier = $sizeMultiplier[$size] ?? 1.25;
                            $prijs = ($pizza->prijs ?? 0) * $multiplier;
                            $cartTotaal += $prijs * $regel->aantal;
                        }
                    }

                    $bezorgkosten = 3.99;
                    $btw = $cartTotaal * 0.09;
                    $totaal = $cartTotaal + $bezorgkosten + $btw;
                @endphp

                <div class="summary-line"><span>Subtotaal:</span><span>€{{ number_format($cartTotaal, 2) }}</span></div>
                <div class="summary-line"><span>Bezorgkosten:</span><span>€{{ number_format($bezorgkosten, 2) }}</span></div>
                <div class="summary-line"><span>BTW (9%):</span><span>€{{ number_format($btw, 2) }}</span></div>
                <hr>
                <div class="summary-total">
                    <span>Totaal:</span>
                    <span>€{{ number_format($totaal, 2) }}</span>
                </div>

                <hr>

                <form>
                    <label class="promo-label">Kortingscode:</label>
                    <div class="promo-inputs">
                        <input type="text" placeholder="Voer code in" class="promo-field">
                        <button type="submit" class="btn btn-dark">Toepassen</button>
                    </div>
                </form>

                <div class="delivery-info">
                    ⏱️ Geschatte bezorgtijd: 25-35 minuten<br>
                    📍 Leveradres: 123 Main St, City
                </div>

         @if (!$orders->isEmpty())
    @php
        $initieleOrderIds = $orders->where('status', 'Initieel')->pluck('id');
    @endphp

    @if ($initieleOrderIds->isNotEmpty())
        <form action="{{ route('bestelling.betaal') }}" method="POST">
            @csrf
            @foreach ($initieleOrderIds as $orderId)
                <input type="hidden" name="ids[]" value="{{ $orderId }}">
            @endforeach
            <button class="btn btn-checkout">Verder naar afrekenen</button>
        </form>
    @endif
@endif


                <a href="{{ route('menu') }}" class="btn btn-outline">Terug naar menu</a>
            </div>
        </div>
    </div>
</main>

@include('layouts.footer')

<script>
    document.getElementById("btnRefresh")?.addEventListener("click", function () {
        window.location.reload();
    });
</script>
@endsection
