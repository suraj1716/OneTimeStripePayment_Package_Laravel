<?php
namespace Suraj1716\Onetimestripe\Http\Controllers;

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

class ProductController extends BaseController
{
    public function index(Request $request)
    {

        $products = Product::all();
        return view('onetimestripe::product.index', compact("products"));
    }

    public function checkout(Request $request)
    {
        // Fetch the user's cart
        $cart = Cart::first();
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $products = $cart->products; // Get products from the user's cart

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $totalPrice = 0;
        $lineItems = [];

        // Create the order **before** the Stripe session
        $order = new Order();
        $order->status = 'unpaid';
        $order->total_price = $totalPrice;
        $order->save(); // Now `$order->id` exists

        // Create line items for Stripe
        foreach ($products as $product) {
            $totalPrice += $product->price;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->name,
                        'images' => [$product->image],
                    ],
                    'unit_amount' => $product->price * 100, // Price in cents
                ],
                'quantity' => 1,
            ];
        }

        // Now create Stripe checkout session with the order ID
        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['order' => $order->id], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel', [], true),
        ]);

        // Update the order with the session ID
        $order->session_id = $session->id;
        $order->save();

        // Attach products to the order (optional)
        foreach ($products as $product) {
            $order->products()->attach($product->id, ['quantity' => 1]);
        }

        // Redirect the user to Stripe checkout page
        return redirect($session->url);
    }


    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $sessionId = $request->get('session_id');

        try {
            $session = Session::retrieve($sessionId);

            if (!$session) {
                throw new NotFoundHttpException;
            }

            $order = Order::where('session_id', $session->id)->where('status', 'unpaid')->first();

            if (!$order) {
                throw new NotFoundHttpException();
            }

            $order->status = 'paid';
            $order->save();

            return view('onetimestripe::checkout.success', compact('order'));

        } catch (Exception $e) {
            throw new NotFoundHttpException;
        }
    }

    public function cancel()
    {
        // Redirect the user back to the cart or another appropriate page
        return redirect()->route('cart.index')->with('error', 'Payment was cancelled.');
    }
}
