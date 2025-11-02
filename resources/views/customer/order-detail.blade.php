<x-app-layout>
    <x-slot name="title">Order #{{ $order->id }} - Pedidos Forma de Amor</x-slot>

    <div class="max-w-5xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('customer.orders') }}" class="text-indigo-600 hover:text-indigo-700 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Orders
            </a>
        </div>

        <!-- Order Header -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            <div class="bg-indigo-600 px-6 py-4 flex justify-between items-center flex-wrap gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-white">Order #{{ $order->id }}</h1>
                    <p class="text-indigo-100 text-sm">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                </div>
                <div class="flex gap-2 flex-wrap">
                    <span class="px-3 py-1 text-sm font-semibold rounded-full 
                               @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                               @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                               @elseif($order->status === 'completed') bg-green-100 text-green-800
                               @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                               @else bg-gray-100 text-gray-800
                               @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-white text-gray-800">
                        Shipping: {{ ucfirst($order->shipping_status) }}
                    </span>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Shipping Address -->
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Shipping Address
                        </h3>
                        <div class="text-sm text-gray-700 space-y-1">
                            <p class="font-medium">{{ $order->shipping_name }}</p>
                            <p>{{ $order->shipping_address }}</p>
                            <p>{{ $order->shipping_city }}, {{ $order->shipping_state }}</p>
                            <p>{{ $order->shipping_zip_code }}</p>
                            <p>{{ $order->shipping_country }}</p>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Contact Info
                        </h3>
                        <div class="text-sm text-gray-700 space-y-1">
                            <p>{{ $order->shipping_email }}</p>
                            <p>{{ $order->shipping_phone }}</p>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Payment Info
                        </h3>
                        <div class="text-sm text-gray-700 space-y-1">
                            <p><span class="font-medium">Method:</span> {{ ucfirst(str_replace('_', ' ', $order->payment->payment_method)) }}</p>
                            <p>
                                <span class="font-medium">Status:</span> 
                                <span class="px-2 py-0.5 text-xs rounded-full
                                           @if($order->payment->status === 'pending') bg-yellow-100 text-yellow-800
                                           @elseif($order->payment->status === 'completed') bg-green-100 text-green-800
                                           @elseif($order->payment->status === 'failed') bg-red-100 text-red-800
                                           @else bg-gray-100 text-gray-800
                                           @endif">
                                    {{ ucfirst($order->payment->status) }}
                                </span>
                            </p>
                            @if($order->payment->txn_id)
                            <p><span class="font-medium">Transaction ID:</span> {{ $order->payment->txn_id }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                @if($order->notes)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">Order Notes</h3>
                    <p class="text-sm text-gray-700">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Order Items</h2>
            </div>

            <div class="divide-y divide-gray-200">
                @foreach($order->items as $item)
                <div class="p-6 flex items-center">
                    <img src="{{ asset('storage/products/' . $item->product->featured_photo) }}" 
                         alt="{{ $item->product_name }}" 
                         class="w-20 h-20 object-cover rounded"
                         onerror="this.src='https://via.placeholder.com/80'">
                    
                    <div class="ml-4 flex-1">
                        <h3 class="font-medium text-gray-900">
                            <a href="{{ route('products.show', $item->product->slug) }}" 
                               class="hover:text-indigo-600">
                                {{ $item->product_name }}
                            </a>
                        </h3>
                        @if($item->size || $item->color)
                        <p class="text-sm text-gray-600 mt-1">
                            @if($item->size) Size: {{ $item->size }} @endif
                            @if($item->color) • Color: {{ $item->color }} @endif
                        </p>
                        @endif
                        <p class="text-sm text-gray-600 mt-1">
                            R$ {{ number_format($item->unit_price, 2, ',', '.') }} × {{ $item->quantity }}
                        </p>
                    </div>
                    
                    <div class="text-right">
                        <p class="font-semibold text-gray-900 text-lg">
                            R$ {{ number_format($item->total_price, 2, ',', '.') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="bg-gray-50 px-6 py-4">
                <div class="max-w-xs ml-auto space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-semibold text-gray-900">R$ {{ number_format($order->subtotal, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Shipping:</span>
                        <span class="font-semibold text-gray-900">R$ {{ number_format($order->shipping_cost, 2, ',', '.') }}</span>
                    </div>
                    @if($order->tax > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax:</span>
                        <span class="font-semibold text-gray-900">R$ {{ number_format($order->tax, 2, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="border-t border-gray-300 pt-2 mt-2">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-gray-900">Total:</span>
                            <span class="text-2xl font-bold text-indigo-600">
                                R$ {{ number_format($order->total, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Instructions (if pending) -->
        @if($order->payment->status === 'pending')
        <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Payment Pending</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        @if($order->payment->payment_method === 'bank_transfer')
                        <p>Please complete the bank transfer to process your order.</p>
                        <div class="mt-2 space-y-1">
                            <p><strong>Bank:</strong> Example Bank</p>
                            <p><strong>Account:</strong> 1234-5678-90</p>
                            <p><strong>Amount:</strong> R$ {{ number_format($order->total, 2, ',', '.') }}</p>
                            <p><strong>Reference:</strong> Order #{{ $order->id }}</p>
                        </div>
                        @elseif($order->payment->payment_method === 'pix')
                        <p>Complete your PIX payment using the QR code below:</p>
                        <div class="mt-4 bg-white p-4 inline-block rounded">
                            <div class="w-48 h-48 bg-gray-200 flex items-center justify-center">
                                <p class="text-gray-500 text-sm">PIX QR Code</p>
                            </div>
                        </div>
                        @else
                        <p>Your payment is being processed. We'll send you a confirmation email once it's complete.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>

