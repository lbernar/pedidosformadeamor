<x-app-layout>
    <x-slot name="title">Shopping Cart - Pedidos Forma de Amor</x-slot>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Shopping Cart</h1>

        @if(empty($cart) || count($cart) === 0)
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Your cart is empty</h3>
                <p class="mt-1 text-sm text-gray-500">Start shopping to add items to your cart.</p>
                <div class="mt-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Continue Shopping
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        @foreach($cart as $key => $item)
                            <div class="p-6 border-b border-gray-200">
                                <div class="flex items-center">
                                    @if($item['image'] && file_exists(storage_path('app/public/products/' . $item['image'])))
                                        <img src="{{ asset('storage/products/' . $item['image']) }}" 
                                             alt="{{ $item['name'] }}" 
                                             class="w-24 h-24 object-cover rounded">
                                    @else
                                        <div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center">
                                            <span class="text-gray-400 text-xs">No Image</span>
                                        </div>
                                    @endif
                                    
                                    <div class="ml-6 flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            <a href="{{ route('products.show', $item['slug']) }}" class="hover:text-indigo-600">
                                                {{ $item['name'] }}
                                            </a>
                                        </h3>
                                        
                                        @if($item['size'])
                                            <p class="text-sm text-gray-600">Size: {{ $item['size'] }}</p>
                                        @endif
                                        
                                        @if($item['color'])
                                            <p class="text-sm text-gray-600">Color: {{ $item['color'] }}</p>
                                        @endif
                                        
                                        <p class="mt-2 text-lg font-bold text-gray-900">
                                            R$ {{ number_format($item['price'], 2, ',', '.') }}
                                        </p>
                                        
                                        <div class="mt-4 flex items-center space-x-4">
                                            <form action="{{ route('cart.update', $key) }}" method="POST" class="flex items-center">
                                                @csrf
                                                @method('PUT')
                                                <label class="text-sm text-gray-600 mr-2">Qty:</label>
                                                <input type="number" 
                                                       name="quantity" 
                                                       value="{{ $item['quantity'] }}" 
                                                       min="1" 
                                                       class="w-20 border-gray-300 rounded-md shadow-sm">
                                                <button type="submit" class="ml-2 text-sm text-indigo-600 hover:text-indigo-700">
                                                    Update
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('cart.remove', $key) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-700">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right">
                                        <p class="text-xl font-bold text-gray-900">
                                            R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 hover:text-red-700">
                                Clear Cart
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>
                        
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-semibold text-gray-900">R$ {{ number_format($total, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping:</span>
                                <span class="font-semibold text-gray-900">Calculated at checkout</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2 mt-2">
                                <div class="flex justify-between">
                                    <span class="text-base font-semibold text-gray-900">Total:</span>
                                    <span class="text-xl font-bold text-gray-900">R$ {{ number_format($total, 2, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 space-y-3">
                            <a href="{{ route('checkout.index') }}" class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 text-center block font-semibold">
                                Proceed to Checkout
                            </a>
                            <a href="{{ route('home') }}" class="w-full bg-gray-200 text-gray-800 py-3 px-4 rounded-md hover:bg-gray-300 text-center block">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>

