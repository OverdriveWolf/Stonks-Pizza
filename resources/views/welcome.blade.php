


@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif  
<p>haha</p>
    <div class="container px-6 mx-auto pt-[100px]">
        <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($pizzas as $pizza)
            <div class="w-full max-w-sm mx-auto overflow-hidden rounded-md shadow-md bg-white">
                <div class="flex items-end justify-end w-full bg-cover">

                </div>
                <div class="px-5 py-3">
                    <h3 class="text-gray-700 uppercase">Pizza {{ $pizza->name }}</h3>
                    <span class="mt-2 text-gray-500">{{ $pizza->price }}</span>
                    <br>
                    <span class="mt-2 text-gray-500">{{ $pizza->description }}</span>
               
                </div>

            </div>
            @endforeach
        </div>
    </div>
@endsection
