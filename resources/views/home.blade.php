@extends('layouts.app-layout')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('homestyle.css') }}">
</head>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-text">
        <h1>Best Pizza in Town</h1>
        <p>Fresh ingredients, authentic recipes, and unbeatable taste since 1995</p>
        <a href="{{ route('winkelwagentje.store') }}" class="btn">Order Now</a>
        <a href="{{ route('menu') }}" class="btn">View Menu</a>
    </div>
    <img src="{{ asset('logopizza.png') }}" alt="Delicious Pizza">
</section>

<!-- Features Section -->
<section class="features">
    <div class="feature">
        <i class="fas fa-leaf"></i>
        <h4>Fresh Ingredients</h4>
        <p>Only the freshest local ingredients go into our pizzas.</p>
    </div>
    <div class="feature">
        <i class="fas fa-truck"></i>
        <h4>Fast Delivery</h4>
        <p>Hot and delicious pizzas delivered in under 30 minutes.</p>
    </div>
    <div class="feature">
        <i class="fas fa-heart"></i>
        <h4>Made with Love</h4>
        <p>Every pizza is crafted with passion and dedication to taste.</p>
    </div>
</section>

<!-- Popular Pizzas Section -->
<section class="pizza-section">
    <h2 class="section-title">Popular Pizzas</h2>
    <div class="pizza-grid">
        <div class="pizza-card">
            <img src="{{ asset('Margherita.png') }}" alt="Margherita">
            <h4>Margherita</h4>
            <p>Classic tomato, mozzarella & basil</p>
            <p class="price">$14.99</p>
            <button class="btn">Order Now</button>
        </div>
        <div class="pizza-card">
            <img src="{{ asset('Margherita.png') }}" alt="Pepperoni Supreme">
            <h4>Pepperoni Supreme</h4>
            <p>Loaded with pepperoni & cheese</p>
            <p class="price">$16.99</p>
            <button class="btn">Order Now</button>
        </div>
        <div class="pizza-card">
            <img src="{{ asset('Margherita.png') }}" alt="Meat Lovers">
            <h4>Meat Lovers</h4>
            <p>Beef, sausage, pepperoni & bacon</p>
            <p class="price">$19.99</p>
            <button class="btn">Order Now</button>
        </div>
    </div>
    <div style="text-align:center; margin-top: 20px;">
        <a href="{{ route('menu') }}" class="btn">View Full Menu</a>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials">
    <div class="testimonial">
        <strong>Jane Anderson</strong>
        <p>"Delicious and fast delivery! Always my go-to place."</p>
    </div>
    <div class="testimonial">
        <strong>Mike Clark</strong>
        <p>"Best pizza I’ve had in a long time. Pizza stonks. is a local gem."</p>
    </div>
    <div class="testimonial">
        <strong>Susan Davis</strong>
        <p>"Incredible taste and presentation. Highly recommend the Margherita!"</p>
    </div>
</section>

<!-- Call to Action -->
<section class="cta">
    <h2>Ready to Order?</h2>
    <p>Get your favorite pizzas delivered hot and fresh to your door</p>
    <a href="{{ route('menu') }}" class="btn">Order Now</a>
    <a href="tel:+1234567890" class="btn">Call: (123) 123-4567</a>
</section>
<footer class="footer">@include('layouts.footer')</footer>
@endsection
