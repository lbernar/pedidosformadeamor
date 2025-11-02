<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * CheckoutController
 * 
 * Handles the checkout process, order creation, and payment processing
 */
class CheckoutController extends Controller
{
    /**
     * Constructor - require customer authentication
     */
    public function __construct()
    {
        $this->middleware('auth:customer');
    }
    
    /**
     * Display checkout page
     * 
     * @return View|RedirectResponse
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Redirect if cart is empty
        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }
        
        $customer = Auth::guard('customer')->user();
        $subtotal = $this->calculateSubtotal($cart);
        $shippingCost = $this->calculateShipping($customer);
        $tax = $this->calculateTax($subtotal);
        $total = $subtotal + $shippingCost + $tax;
        
        return view('checkout.index', compact(
            'cart',
            'customer',
            'subtotal',
            'shippingCost',
            'tax',
            'total'
        ));
    }
    
    /**
     * Process checkout and create order
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function process(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:stripe,paypal,pix,bank_transfer',
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_zip_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }
        
        $customer = Auth::guard('customer')->user();
        
        try {
            DB::beginTransaction();
            
            // Calculate amounts
            $subtotal = $this->calculateSubtotal($cart);
            $shippingCost = $this->calculateShipping($customer);
            $tax = $this->calculateTax($subtotal);
            $total = $subtotal + $shippingCost + $tax;
            
            // Create payment record
            $payment = Payment::create([
                'customer_id' => $customer->id,
                'amount' => $total,
                'currency' => 'BRL',
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
            ]);
            
            // Create order
            $order = Order::create([
                'customer_id' => $customer->id,
                'payment_id' => $payment->id,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'tax' => $tax,
                'total' => $total,
                'status' => 'pending',
                'shipping_status' => 'pending',
                'shipping_name' => $validated['shipping_name'],
                'shipping_email' => $validated['shipping_email'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_state' => $validated['shipping_state'],
                'shipping_zip_code' => $validated['shipping_zip_code'],
                'shipping_country' => $validated['shipping_country'],
                'notes' => $validated['notes'],
            ]);
            
            // Create order items and update stock
            foreach ($cart as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Check stock availability
                if ($product->qty < $item['quantity']) {
                    throw new \Exception("Product {$product->name} is out of stock.");
                }
                
                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'size' => $item['size'],
                    'color' => $item['color'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                ]);
                
                // Reduce stock
                $product->decrement('qty', $item['quantity']);
            }
            
            DB::commit();
            
            // Clear cart
            session()->forget('cart');
            
            // Redirect to payment gateway or success page
            if ($validated['payment_method'] === 'stripe') {
                return redirect()->route('payment.stripe', $order->id);
            } elseif ($validated['payment_method'] === 'paypal') {
                return redirect()->route('payment.paypal', $order->id);
            } elseif ($validated['payment_method'] === 'pix') {
                return redirect()->route('payment.pix', $order->id);
            } else {
                // Bank transfer - show instructions
                return redirect()->route('checkout.success', $order->id)
                    ->with('success', 'Order placed successfully! Please complete the bank transfer.');
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Error processing order: ' . $e->getMessage());
        }
    }
    
    /**
     * Display order success page
     * 
     * @param int $orderId
     * @return View
     */
    public function success(int $orderId): View
    {
        $order = Order::with(['items.product', 'payment'])
            ->where('customer_id', Auth::guard('customer')->id())
            ->findOrFail($orderId);
        
        return view('checkout.success', compact('order'));
    }
    
    /**
     * Calculate subtotal from cart
     * 
     * @param array $cart
     * @return float
     */
    private function calculateSubtotal(array $cart): float
    {
        $subtotal = 0;
        
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        return $subtotal;
    }
    
    /**
     * Calculate shipping cost
     * 
     * @param \App\Models\Customer $customer
     * @return float
     */
    private function calculateShipping($customer): float
    {
        // TODO: Implement real shipping calculation based on location
        // For now, return fixed rate
        return 10.00;
    }
    
    /**
     * Calculate tax
     * 
     * @param float $subtotal
     * @return float
     */
    private function calculateTax(float $subtotal): float
    {
        // TODO: Implement real tax calculation based on location
        // For now, return 0 (tax included in product price)
        return 0.00;
    }
}
