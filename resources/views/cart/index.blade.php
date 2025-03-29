<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Checkout</title>
</head>
<body>

    <div class="container">
        <h1>Your Cart</h1>
        @if($cart && $cart->products->isNotEmpty())
            <ul>
                @foreach ($cart->products as $product)
                    <li>
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" width="100">
                        <strong>{{ $product->name }}</strong> - ${{ $product->price }}
                        <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Remove</button>
                        </form>
                    </li>
                @endforeach
            </ul>
            <a href="{{ route('cart.checkout') }}" class="btn btn-primary">Proceed to Checkout</a>
        @else
            <p>Your cart is empty!</p>
        @endif
    </div>

</body>
</html>
