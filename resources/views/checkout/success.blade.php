<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Checkout</title>
</head>
<body>

    <div class="container">
        <h1>Order Successful!</h1>
        <p>Your order has been placed successfully.</p>
        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Total Price:</strong> ${{ $order->total_price }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

        <a href="{{ route('checkout.success') }}" class="btn btn-primary">Go back to Home</a>
    </div>


</body>
</html>
