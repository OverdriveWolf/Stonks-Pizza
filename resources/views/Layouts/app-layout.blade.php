<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <title>Pizza Menu</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>
<body>

    @include('layouts.nav')

    {{-- Main content --}}
    @yield('content')

</body>
</html>

