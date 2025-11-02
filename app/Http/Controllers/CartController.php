<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * CartController
 * 
 * Manages shopping cart functionality using session-based storage
 */
class CartController extends Controller
{
    /**
     * Display the shopping cart
     * 
     * @return View
     */
    public function index(): View
    {
        $cart = session()->get('cart', []);
        $total = $this->calculateTotal($cart);
        
        return view('cart.index', compact('cart', 'total'));
    }
    
    /**
     * Add product to cart
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function add(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);
        
        $product = Product::findOrFail($validated['product_id']);
        
        // Check if product is in stock
        if ($product->qty < $validated['quantity']) {
            return back()->with('error', 'Sorry, insufficient stock available.');
        }
        
        $cart = session()->get('cart', []);
        
        // Generate unique cart item key
        $cartKey = $this->generateCartKey(
            $validated['product_id'], 
            $validated['size'] ?? null, 
            $validated['color'] ?? null
        );
        
        // If item exists, increase quantity
        if (isset($cart[$cartKey])) {
            $newQuantity = $cart[$cartKey]['quantity'] + $validated['quantity'];
            
            // Check stock for new quantity
            if ($product->qty < $newQuantity) {
                return back()->with('error', 'Cannot add more items. Stock limit reached.');
            }
            
            $cart[$cartKey]['quantity'] = $newQuantity;
        } else {
            // Add new item to cart
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->current_price,
                'quantity' => $validated['quantity'],
                'size' => $validated['size'] ?? null,
                'color' => $validated['color'] ?? null,
                'image' => $product->featured_photo,
            ];
        }
        
        session()->put('cart', $cart);
        
        return back()->with('success', 'Product added to cart successfully!');
    }
    
    /**
     * Update cart item quantity
     * 
     * @param Request $request
     * @param string $cartKey
     * @return RedirectResponse
     */
    public function update(Request $request, string $cartKey): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (!isset($cart[$cartKey])) {
            return back()->with('error', 'Item not found in cart.');
        }
        
        // Check stock
        $product = Product::find($cart[$cartKey]['product_id']);
        if ($product->qty < $validated['quantity']) {
            return back()->with('error', 'Insufficient stock available.');
        }
        
        $cart[$cartKey]['quantity'] = $validated['quantity'];
        session()->put('cart', $cart);
        
        return back()->with('success', 'Cart updated successfully!');
    }
    
    /**
     * Remove item from cart
     * 
     * @param string $cartKey
     * @return RedirectResponse
     */
    public function remove(string $cartKey): RedirectResponse
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
            return back()->with('success', 'Item removed from cart.');
        }
        
        return back()->with('error', 'Item not found in cart.');
    }
    
    /**
     * Clear entire cart
     * 
     * @return RedirectResponse
     */
    public function clear(): RedirectResponse
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared successfully.');
    }
    
    /**
     * Get cart item count
     * 
     * @return int
     */
    public function getCartCount(): int
    {
        $cart = session()->get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }
    
    /**
     * Calculate cart total
     * 
     * @param array $cart
     * @return float
     */
    private function calculateTotal(array $cart): float
    {
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return $total;
    }
    
    /**
     * Generate unique cart key for product with variants
     * 
     * @param int $productId
     * @param string|null $size
     * @param string|null $color
     * @return string
     */
    private function generateCartKey(int $productId, ?string $size, ?string $color): string
    {
        return implode('_', array_filter([
            $productId,
            $size,
            $color
        ]));
    }
}
