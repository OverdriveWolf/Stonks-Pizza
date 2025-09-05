<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <title>Pizza Menu</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    @include('layouts.nav')

    {{-- Main content --}}
    @yield('content')

</body>
</html>

