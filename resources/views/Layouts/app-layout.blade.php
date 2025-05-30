<!DOCTYPE html>
<html lang="en">

    <meta charset="UTF-8">
    <title>Pizza Menu</title>


<body>  
    {{-- Optional: include the nav --}}
    @include('layouts.nav')

    {{-- Main content from child views --}}
    @yield('content')
  
</body>
</html>
