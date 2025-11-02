<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * HomeController
 * 
 * Handles the homepage display with featured products, sliders, and categories
 */
class HomeController extends Controller
{
    /**
     * Display the homepage
     * 
     * Shows:
     * - Homepage sliders
     * - Featured products
     * - Latest products  
     * - Popular products
     * - Category navigation
     * 
     * @return View
     */
    public function index(): View
    {
        // Get active sliders ordered by position
        $sliders = Slider::where('is_active', true)
            ->orderBy('order')
            ->get();
        
        // Get featured products (limited to 8)
        $featuredProducts = Product::featured()
            ->inStock()
            ->limit(8)
            ->get();
        
        // Get latest products (limited to 8)
        $latestProducts = Product::active()
            ->inStock()
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
        
        // Get popular products (most viewed, limited to 8)
        $popularProducts = Product::popular(8)->get();
        
        // Get top categories for navigation
        $categories = Category::where('show_on_menu', true)
            ->with(['midCategories.endCategories'])
            ->get();
        
        return view('home.index', compact(
            'sliders',
            'featuredProducts',
            'latestProducts',
            'popularProducts',
            'categories'
        ));
    }
    
    /**
     * Display about page
     * 
     * @return View
     */
    public function about(): View
    {
        return view('home.about');
    }
    
    /**
     * Display FAQ page
     * 
     * @return View
     */
    public function faq(): View
    {
        $faqs = \App\Models\Faq::where('is_active', true)
            ->orderBy('order')
            ->get();
            
        return view('home.faq', compact('faqs'));
    }
    
    /**
     * Display contact page
     * 
     * @return View
     */
    public function contact(): View
    {
        return view('home.contact');
    }
    
    /**
     * Handle contact form submission
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);
        
        // Send email notification
        // Mail::to(config('mail.from.address'))->send(new ContactFormMail($validated));
        
        return back()->with('success', 'Your message has been sent successfully!');
    }
}
