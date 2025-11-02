<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\EndCategory;
use App\Models\MidCategory;
use App\Models\ProductRating;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * ProductController
 * 
 * Handles product browsing, search, filtering, and rating functionality
 */
class ProductController extends Controller
{
    /**
     * Display a single product with details
     * 
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        // Get product with relationships
        $product = Product::where('slug', $slug)
            ->with([
                'endCategory.midCategory.topCategory',
                'colors',
                'sizes',
                'photos',
                'ratings.customer'
            ])
            ->firstOrFail();
        
        // Increment view count
        $product->incrementViews();
        
        // Get related products from same category
        $relatedProducts = Product::where('end_category_id', $product->end_category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->inStock()
            ->limit(4)
            ->get();
        
        // Check if current customer has already rated
        $hasRated = false;
        if (Auth::guard('customer')->check()) {
            $hasRated = ProductRating::where('product_id', $product->id)
                ->where('customer_id', Auth::guard('customer')->id())
                ->exists();
        }
        
        return view('products.show', compact('product', 'relatedProducts', 'hasRated'));
    }
    
    /**
     * Display products by category
     * 
     * @param Request $request
     * @param int $id
     * @param string $type (top-category, mid-category, end-category)
     * @return View
     */
    public function category(Request $request, int $id, string $type = 'end-category'): View
    {
        $products = collect();
        $categoryName = '';
        $breadcrumbs = [];
        
        switch ($type) {
            case 'top-category':
                $category = Category::findOrFail($id);
                $categoryName = $category->name;
                $products = $category->products()->active()->inStock()->paginate(12);
                $breadcrumbs = [$category->name];
                break;
                
            case 'mid-category':
                $category = MidCategory::with('topCategory')->findOrFail($id);
                $categoryName = $category->name;
                $products = $category->products()->active()->inStock()->paginate(12);
                $breadcrumbs = [$category->topCategory->name, $category->name];
                break;
                
            case 'end-category':
                $category = EndCategory::with('midCategory.topCategory')->findOrFail($id);
                $categoryName = $category->name;
                $products = $category->products()->active()->inStock()->paginate(12);
                $breadcrumbs = [
                    $category->midCategory->topCategory->name,
                    $category->midCategory->name,
                    $category->name
                ];
                break;
        }
        
        // Apply sorting
        if ($request->has('sort')) {
            $products = $this->applySorting($products, $request->sort);
        }
        
        return view('products.category', compact('products', 'categoryName', 'breadcrumbs'));
    }
    
    /**
     * Search products
     * 
     * @param Request $request
     * @return View
     */
    public function search(Request $request): View
    {
        $query = $request->input('q', '');
        
        $products = Product::active()
            ->inStock()
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('short_description', 'LIKE', "%{$query}%");
            })
            ->paginate(12);
        
        return view('products.search', compact('products', 'query'));
    }
    
    /**
     * Submit a product rating/review
     * 
     * @param Request $request
     * @param int $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rate(Request $request, int $productId)
    {
        if (!Auth::guard('customer')->check()) {
            return back()->with('error', 'You must be logged in to rate products.');
        }
        
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        
        $customer = Auth::guard('customer')->user();
        
        // Check if already rated
        $existingRating = ProductRating::where('product_id', $productId)
            ->where('customer_id', $customer->id)
            ->first();
        
        if ($existingRating) {
            return back()->with('error', 'You have already rated this product.');
        }
        
        // Create rating
        ProductRating::create([
            'product_id' => $productId,
            'customer_id' => $customer->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);
        
        return back()->with('success', 'Your rating has been submitted successfully!');
    }
    
    /**
     * Apply sorting to product query
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $sort
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function applySorting($query, string $sort)
    {
        switch ($sort) {
            case 'price_low_high':
                return $query->orderBy('current_price', 'asc');
            case 'price_high_low':
                return $query->orderBy('current_price', 'desc');
            case 'name_asc':
                return $query->orderBy('name', 'asc');
            case 'name_desc':
                return $query->orderBy('name', 'desc');
            case 'newest':
                return $query->orderBy('created_at', 'desc');
            case 'popular':
                return $query->orderBy('total_views', 'desc');
            default:
                return $query;
        }
    }
}
