<?php

namespace App\Http\Controllers;

use App\Models\Med;
use App\Models\User;
use App\Models\HIC;
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
    public function addToCart(Request $request, $id)
    {
        $medicine = Med::findOrFail($id);
    $cart = session()->get('cart', []);
    
    // Assuming the user is authenticated
    $user = auth()->user();
    $insuranceCompany = $user->hic; // Get the user's health insurance company
    
    // Store the original price
    $originalPrice = $medicine->med_price;
    
    // Apply discount if there's an insurance company
    $discount = 0; // Default discount is 0%
    $price = $originalPrice;
    
    if ($insuranceCompany) {
        $discount = $insuranceCompany->HIC_disscount; // E.g., 10% discount
        $price -= ($price * ($discount)); // Apply the discount
    }

    // If the medicine is already in the cart, increment the quantity
    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        // If not, add the medicine to the cart
        $cart[$id] = [
            'name' => $medicine->med_name,
            'original_price' => $originalPrice,
            'price' => $price,
            'discount' => $discount, // Save the discount percentage
            'quantity' => 1,
        ];
    }

    // Save the updated cart to the session
    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Medicine added to cart!');
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
