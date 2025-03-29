



    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">


            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>




                @foreach ($products as $product)
                <div class="product-item">
                    <!-- Product Image -->
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" style="max-width:100%;"/>

                    <!-- Product Name and Price -->
                    <h2>{{ $product->name }}</h2>
                    <p>${{ number_format($product->price, 2) }}</p>

                    <!-- Add to Cart Form -->
                    <form action="{{ route('cart.add', ['productId' => $product->id]) }}" method="POST">
                        @csrf
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            @endforeach


            </main>
        </div>
    </body>
</html>






















{{--


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>


</head>

<body class="antialiased" style="display:flex">
    @foreach ($products as $product)
        <div class="flex:1 ; gap:2rem ">
            <img src="{{ $product->image }}" style="max-width:100% " />

            <h2>{{ $product->name }}</h2>
            <p>${{ $product->price }}</p>

        </div>
    @endforeach

    <p>
        <form action="{{ route('checkout') }}" method="POST">
            @csrf
                <button>Checkout</button>
            </form>
    </p>
</body>

</html> --}}
