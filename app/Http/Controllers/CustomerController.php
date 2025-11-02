<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * CustomerController
 * 
 * Manages customer dashboard, profile, orders, and account settings
 */
class CustomerController extends Controller
{
    /**
     * Constructor - require customer authentication
     */
    public function __construct()
    {
        $this->middleware('auth:customer');
    }
    
    /**
     * Display customer dashboard
     * 
     * @return View
     */
    public function dashboard(): View
    {
        $customer = Auth::guard('customer')->user();
        
        // Get recent orders
        $recentOrders = Order::where('customer_id', $customer->id)
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get order statistics
        $stats = [
            'total_orders' => Order::where('customer_id', $customer->id)->count(),
            'pending_orders' => Order::where('customer_id', $customer->id)
                ->where('status', 'pending')
                ->count(),
            'completed_orders' => Order::where('customer_id', $customer->id)
                ->where('status', 'completed')
                ->count(),
            'total_spent' => Order::where('customer_id', $customer->id)
                ->where('status', 'completed')
                ->sum('total'),
        ];
        
        return view('customer.dashboard', compact('customer', 'recentOrders', 'stats'));
    }
    
    /**
     * Display customer orders
     * 
     * @return View
     */
    public function orders(): View
    {
        $customer = Auth::guard('customer')->user();
        
        $orders = Order::where('customer_id', $customer->id)
            ->with(['items.product', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('customer.orders', compact('orders'));
    }
    
    /**
     * Display single order details
     * 
     * @param int $id
     * @return View
     */
    public function orderDetail(int $id): View
    {
        $customer = Auth::guard('customer')->user();
        
        $order = Order::with(['items.product', 'payment'])
            ->where('customer_id', $customer->id)
            ->findOrFail($id);
        
        return view('customer.order-detail', compact('order'));
    }
    
    /**
     * Display customer profile
     * 
     * @return View
     */
    public function profile(): View
    {
        $customer = Auth::guard('customer')->user();
        
        return view('customer.profile', compact('customer'));
    }
    
    /**
     * Update customer profile
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $customer = Auth::guard('customer')->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);
        
        $customer->update($validated);
        
        return back()->with('success', 'Profile updated successfully!');
    }
    
    /**
     * Display billing address form
     * 
     * @return View
     */
    public function billingAddress(): View
    {
        $customer = Auth::guard('customer')->user();
        
        return view('customer.billing-address', compact('customer'));
    }
    
    /**
     * Update billing address
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateBillingAddress(Request $request): RedirectResponse
    {
        $customer = Auth::guard('customer')->user();
        
        $validated = $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_company' => 'nullable|string|max:255',
            'billing_phone' => 'required|string|max:50',
            'billing_address' => 'required|string',
            'billing_city' => 'required|string|max:100',
            'billing_state' => 'required|string|max:100',
            'billing_zip_code' => 'required|string|max:20',
            'billing_country' => 'required|string|max:100',
        ]);
        
        $customer->update($validated);
        
        return back()->with('success', 'Billing address updated successfully!');
    }
    
    /**
     * Display shipping address form
     * 
     * @return View
     */
    public function shippingAddress(): View
    {
        $customer = Auth::guard('customer')->user();
        
        return view('customer.shipping-address', compact('customer'));
    }
    
    /**
     * Update shipping address
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateShippingAddress(Request $request): RedirectResponse
    {
        $customer = Auth::guard('customer')->user();
        
        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_company' => 'nullable|string|max:255',
            'shipping_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_zip_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
        ]);
        
        $customer->update($validated);
        
        return back()->with('success', 'Shipping address updated successfully!');
    }
    
    /**
     * Display password change form
     * 
     * @return View
     */
    public function passwordForm(): View
    {
        return view('customer.change-password');
    }
    
    /**
     * Update customer password
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $customer = Auth::guard('customer')->user();
        
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        
        // Verify current password
        if (!Hash::check($validated['current_password'], $customer->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        
        // Update password (will be automatically hashed by mutator in Customer model)
        $customer->update([
            'password' => $validated['new_password']
        ]);
        
        return back()->with('success', 'Password changed successfully!');
    }
}
