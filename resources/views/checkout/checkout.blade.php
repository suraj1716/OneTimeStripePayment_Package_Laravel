<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Checkout</title>
</head>
<body>
    <div id="checkout-button-container">
        <button id="checkout-button" style="padding: 10px 20px; background-color: #5469d4; color: white; border: none; cursor: pointer; font-size: 16px;">
            Checkout with Stripe
        </button>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        var stripe = Stripe('{{ env('STRIPE_KEY') }}'); // Public Key

        var checkoutButton = document.getElementById('checkout-button');
        checkoutButton.addEventListener('click', function () {
            window.location.href = '/checkout';  // Trigger /checkout when the button is clicked
        });
    </script>
</body>
</html>
