<?php

namespace  Suraj1716\Onetimestripe\Http\Controllers;

use Exception;
use Suraj1716\Onetimestripe\Models\Order;
use Suraj1716\Onetimestripe\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Suraj1716\Contactform\Mail\InquiryEmail;
use Suraj1716\Contactform\Models\Contact;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Suraj1716\Onetimestripe\Models\Cart;

class CartController extends BaseController
{
    // Display the products in the cart
    public function index(Request $request)
    {
        $cart = Cart::first(); // Replace with proper logic to fetch the user's cart

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $products = $cart->products; // Get products from the user's cart

        // Pass the cart and products to the view
        return view('onetimestripe::cart.index', compact('cart', 'products'));
    }

    // Add a product to the cart
    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return redirect()->route('cart.index')->with('error', 'Product not found!');
        }

        $cart = Cart::firstOrCreate(
            // ['user_id' => Auth::id()],
            // ['total_price' => 0] // Create a new cart if none exists for the user
        );

        // Add product to the cart
        $cart->products()->attach($productId, ['quantity' => 1]);

        // Update the total price
        $cart->total_price += $product->price;
        $cart->save();

        return redirect()->route('cart.index');
    }

    // Proceed to checkout
    public function proceedToCheckout(Request $request)
    {
        $cart = Cart::first(); // Assuming carts are linked to a user
    
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
    
        $products = $cart->products; // Get products from the user's cart
    
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $totalPrice = 0;
        $lineItems = [];
    
        // Create the order before Stripe checkout
        $order = new Order();
        $order->status = 'unpaid';
    
        // Add line items for Stripe checkout
        foreach ($products as $product) {
            $totalPrice += $product->price;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->name,
                        // 'images' => [$product->image],
                    ],
                    'unit_amount' => $product->price * 100, // Convert price to cents
                ],
                'quantity' => 1,
            ];
        }
    
        // Set the order total price before saving
        $order->total_price = $totalPrice;
        $order->save(); // Save order to get the ID
    
        // Create the Stripe session
        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['order' => $order->id], true) . '&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel', [], true),
        ]);
    
        // Update the order with the session ID
        $order->session_id = $session->id;
        $order->save();
    
        // Attach products to the order (optional)
        foreach ($products as $product) {
            $order->products()->attach($product->id, ['quantity' => 1]);
        }
    
        // Redirect user to Stripe checkout page
        return redirect($session->url);
    }
    

    // Success callback from Stripe
    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $sessionId = $request->get('session_id');

        try {
            $session = Session::retrieve($sessionId);

            if (!$session) {
                throw new NotFoundHttpException;
            }

            // Find the order using the session ID
            $order = Order::where('session_id', $session->id)->where('status', 'unpaid')->first();

            if (!$order) {
                throw new NotFoundHttpException();
            }

            // Mark the order as paid
            $order->status = 'paid';
            $order->save();

            return view('onetimestripe::checkout.success', compact('order'));

        } catch (Exception $e) {
            throw new NotFoundHttpException;
        }
    }

    // Cancel callback from Stripe
    public function cancel()
    {
        return redirect()->route('cart.index')->with('error', 'Payment was cancelled.');
    }

    // Remove product from cart
    public function removeFromCart($productId)
    {
        $cart = Cart::first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Cart not found.');
        }

        $product = Product::find($productId);

        if (!$product) {
            return redirect()->route('cart.index')->with('error', 'Product not found.');
        }

        // Remove product from cart
        $cart->products()->detach($productId);

        // Update the total price after removal
        $cart->total_price -= $product->price;
        $cart->save();

        return redirect()->route('cart.index');
    }
}
