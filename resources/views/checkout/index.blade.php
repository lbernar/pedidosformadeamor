<x-app-layout>
    <x-slot name="title">Checkout - Pedidos Forma de Amor</x-slot>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Forms -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Shipping Information -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Shipping Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                <input type="text" name="shipping_name" 
                                       value="{{ old('shipping_name', $customer->shipping_name ?? $customer->name) }}" 
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('shipping_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" name="shipping_email" 
                                       value="{{ old('shipping_email', $customer->shipping_email ?? $customer->email) }}" 
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('shipping_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                                <input type="tel" name="shipping_phone" 
                                       value="{{ old('shipping_phone', $customer->shipping_phone ?? $customer->phone) }}" 
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('shipping_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                                <input type="text" name="shipping_address" 
                                       value="{{ old('shipping_address', $customer->shipping_address ?? $customer->address) }}" 
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('shipping_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                                <input type="text" name="shipping_city" 
                                       value="{{ old('shipping_city', $customer->shipping_city ?? $customer->city) }}" 
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('shipping_city')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">State *</label>
                                <input type="text" name="shipping_state" 
                                       value="{{ old('shipping_state', $customer->shipping_state ?? $customer->state) }}" 
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('shipping_state')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ZIP Code *</label>
                                <input type="text" name="shipping_zip_code" 
                                       value="{{ old('shipping_zip_code', $customer->shipping_zip_code ?? $customer->zip_code) }}" 
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('shipping_zip_code')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                                <input type="text" name="shipping_country" 
                                       value="{{ old('shipping_country', $customer->shipping_country ?? $customer->country ?? 'Brazil') }}" 
                                       required
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('shipping_country')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Order Notes (Optional)</label>
                            <textarea name="notes" rows="3" 
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Payment Method</h2>
                        
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-indigo-500 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50">
                                <input type="radio" name="payment_method" value="stripe" class="text-indigo-600 focus:ring-indigo-500" required>
                                <div class="ml-3 flex-1">
                                    <div class="font-medium text-gray-900">Credit Card (Stripe)</div>
                                    <div class="text-sm text-gray-500">Pay securely with your credit card</div>
                                </div>
                                <svg class="w-12 h-8" viewBox="0 0 48 32" fill="none">
                                    <rect width="48" height="32" rx="4" fill="#6772E5"/>
                                    <text x="24" y="20" font-size="14" fill="white" text-anchor="middle" font-weight="bold">Stripe</text>
                                </svg>
                            </label>

                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-indigo-500 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50">
                                <input type="radio" name="payment_method" value="paypal" class="text-indigo-600 focus:ring-indigo-500" required>
                                <div class="ml-3 flex-1">
                                    <div class="font-medium text-gray-900">PayPal</div>
                                    <div class="text-sm text-gray-500">Pay with your PayPal account</div>
                                </div>
                                <svg class="w-12 h-8" viewBox="0 0 48 32" fill="none">
                                    <rect width="48" height="32" rx="4" fill="#003087"/>
                                    <text x="24" y="20" font-size="11" fill="white" text-anchor="middle" font-weight="bold">PayPal</text>
                                </svg>
                            </label>

                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-indigo-500 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50">
                                <input type="radio" name="payment_method" value="pix" class="text-indigo-600 focus:ring-indigo-500" required>
                                <div class="ml-3 flex-1">
                                    <div class="font-medium text-gray-900">PIX</div>
                                    <div class="text-sm text-gray-500">Instant payment (Brazil only)</div>
                                </div>
                                <svg class="w-12 h-8" viewBox="0 0 48 32" fill="none">
                                    <rect width="48" height="32" rx="4" fill="#32BCAD"/>
                                    <text x="24" y="20" font-size="14" fill="white" text-anchor="middle" font-weight="bold">PIX</text>
                                </svg>
                            </label>

                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-indigo-500 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50">
                                <input type="radio" name="payment_method" value="bank_transfer" class="text-indigo-600 focus:ring-indigo-500" required>
                                <div class="ml-3 flex-1">
                                    <div class="font-medium text-gray-900">Bank Transfer</div>
                                    <div class="text-sm text-gray-500">Direct bank transfer</div>
                                </div>
                                <svg class="w-12 h-8" viewBox="0 0 48 32" fill="none">
                                    <rect width="48" height="32" rx="4" fill="#6B7280"/>
                                    <text x="24" y="20" font-size="11" fill="white" text-anchor="middle" font-weight="bold">BANK</text>
                                </svg>
                            </label>
                        </div>
                        @error('payment_method')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h2>
                        
                        <!-- Cart Items -->
                        <div class="space-y-4 mb-4 max-h-64 overflow-y-auto">
                            @foreach($cart as $item)
                            <div class="flex items-center">
                                @if($item['image'] && file_exists(storage_path('app/public/products/' . $item['image'])))
                                    <img src="{{ asset('storage/products/' . $item['image']) }}" 
                                         alt="{{ $item['name'] }}" 
                                         class="w-16 h-16 object-cover rounded">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">No Image</span>
                                    </div>
                                @endif
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $item['name'] }}</p>
                                    @if($item['size'] || $item['color'])
                                    <p class="text-xs text-gray-500">
                                        @if($item['size']) Size: {{ $item['size'] }} @endif
                                        @if($item['color']) Color: {{ $item['color'] }} @endif
                                    </p>
                                    @endif
                                    <p class="text-sm text-gray-600">Qty: {{ $item['quantity'] }}</p>
                                </div>
                                <p class="text-sm font-semibold text-gray-900">
                                    R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}
                                </p>
                            </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-200 pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-semibold text-gray-900">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping:</span>
                                <span class="font-semibold text-gray-900">R$ {{ number_format($shippingCost, 2, ',', '.') }}</span>
                            </div>
                            @if($tax > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax:</span>
                                <span class="font-semibold text-gray-900">R$ {{ number_format($tax, 2, ',', '.') }}</span>
                            </div>
                            @endif
                            <div class="border-t border-gray-200 pt-2 mt-2">
                                <div class="flex justify-between">
                                    <span class="text-base font-semibold text-gray-900">Total:</span>
                                    <span class="text-2xl font-bold text-indigo-600">R$ {{ number_format($total, 2, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-6 bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 font-semibold">
                            Place Order
                        </button>

                        <p class="text-xs text-gray-500 text-center mt-4">
                            By placing your order, you agree to our terms and conditions
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>

