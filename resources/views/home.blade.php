@extends('layouts.app-layout')

@section('content')
<link rel="stylesheet" href="{{ asset('styles.css') }}">

<div class="layout">


    <!-- Sidebar Logo -->
 
        <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">


    <!-- Main Content (Centered) -->
    <main class="main">
        <div class="center-box">
            <div class="box">Stonks pizza</div>
            <div class="box">   
            <p class="text-center text-gray-600 max-w-xl">
                Lorem ipsum dolor sit amet. Eos consequatur similique et sunt consequatur est dolorum asperiores et corrupti minima. 
                Non facilis alias id doit voluptate aut consequatur totam sed quas totam. Ut ne est. 
                33 numquam Quis aut quia pariatur et earum voluptatem qui animi voluptatem id ipsa numquam ut quia libero ad debitis nisi.
            </p>
        </main>
    </div>
        </div>
    </main>
  
    
    <!-- Footer -->
    <footer class="footer"> @include('layouts.footer')</footer>
</div>
@endsection
