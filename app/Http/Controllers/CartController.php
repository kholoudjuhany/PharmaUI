<?php

namespace App\Http\Controllers;

use App\Models\Med;
use Illuminate\Http\Request;

class CartController extends Controller
{

    // Show the cart page
    public function showCart()
    {
        $cartItems = session()->get('cart', []);
        $totalPrice = 0;

        foreach ($cartItems as $id => $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return view('dashboard.cart', compact('cartItems', 'totalPrice'));
    }

    // Add a medicine to the cart
    public function addToCart($id)
    {
        $medicine = Med::findOrFail($id);

        $cart = session()->get('cart', []);

        // If the medicine is already in the cart, increment the quantity
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // If not, add the medicine to the cart
            $cart[$id] = [
                'name' => $medicine->med_name,
                'price' => $medicine->med_price,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.show')->with('success', 'Medicine added to cart!');
    }

    // Remove a specific medicine from the cart
    public function removeFromCart($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.show')->with('success', 'Medicine removed from cart!');
    }

    // Clear the entire cart
    public function clearCart()
    {
        session()->forget('cart');

        return redirect()->route('cart.show')->with('success', 'Cart cleared!');
    }

    // Checkout (placeholder, you can extend with actual payment/processing logic)
    public function checkout()
    {
        // For now, just clear the cart and show a message
        session()->forget('cart');

        return redirect()->route('cart.show')->with('success', 'Checkout complete!');
    }
}
