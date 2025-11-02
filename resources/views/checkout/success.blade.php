<x-app-layout>
    <x-slot name="title">Order Successful - Pedidos Forma de Amor</x-slot>

    <div class="max-w-3xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Placed Successfully!</h1>
            <p class="text-gray-600">Thank you for your purchase. Your order has been received.</p>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-indigo-600 px-6 py-4">
                <h2 class="text-white font-semibold">Order Details</h2>
            </div>

            <div class="p-6 space-y-6">
                <!-- Order Info -->
                <div class="grid grid-cols-2 gap-4 pb-6 border-b border-gray-200">
                    <div>
                        <p class="text-sm text-gray-600">Order Number</p>
                        <p class="font-semibold text-gray-900">#{{ $order->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Order Date</p>
                        <p class="font-semibold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Payment Method</p>
                        <p class="font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $order->payment->payment_method) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                   @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                   @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                   @elseif($order->status === 'completed') bg-green-100 text-green-800
                                   @else bg-gray-100 text-gray-800
                                   @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="pb-6 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">Shipping Address</h3>
                    <p class="text-gray-700">{{ $order->shipping_name }}</p>
                    <p class="text-gray-700">{{ $order->shipping_address }}</p>
                    <p class="text-gray-700">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip_code }}</p>
                    <p class="text-gray-700">{{ $order->shipping_country }}</p>
                    <p class="text-gray-700 mt-1">{{ $order->shipping_email }}</p>
                    <p class="text-gray-700">{{ $order->shipping_phone }}</p>
                </div>

                <!-- Order Items -->
                <div class="pb-6 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-4">Order Items</h3>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center">
                            @if($item->product && $item->product->featured_photo && file_exists(storage_path('app/public/products/' . $item->product->featured_photo)))
                                <img src="{{ asset('storage/products/' . $item->product->featured_photo) }}" 
                                     alt="{{ $item->product_name }}" 
                                     class="w-16 h-16 object-cover rounded">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-400 text-xs">No Image</span>
                                </div>
                            @endif
                            <div class="ml-4 flex-1">
                                <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                                @if($item->size || $item->color)
                                <p class="text-sm text-gray-600">
                                    @if($item->size) Size: {{ $item->size }} @endif
                                    @if($item->color) Color: {{ $item->color }} @endif
                                </p>
                                @endif
                                <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">R$ {{ number_format($item->total_price, 2, ',', '.') }}</p>
                                <p class="text-sm text-gray-600">R$ {{ number_format($item->unit_price, 2, ',', '.') }} each</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Totals -->
                <div class="space-y-2">
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
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-gray-900">Total:</span>
                            <span class="text-2xl font-bold text-indigo-600">R$ {{ number_format($order->total, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Instructions -->
                @if($order->payment->payment_method === 'bank_transfer' && $order->payment->status === 'pending')
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h4 class="font-semibold text-yellow-900 mb-2">Payment Instructions</h4>
                    <p class="text-sm text-yellow-800 mb-2">Please complete the bank transfer to process your order:</p>
                    <div class="text-sm text-yellow-900 space-y-1">
                        <p><strong>Bank:</strong> Example Bank</p>
                        <p><strong>Account:</strong> 1234-5678-90</p>
                        <p><strong>Amount:</strong> R$ {{ number_format($order->total, 2, ',', '.') }}</p>
                        <p><strong>Reference:</strong> Order #{{ $order->id }}</p>
                    </div>
                </div>
                @endif

                @if($order->payment->payment_method === 'pix' && $order->payment->status === 'pending')
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                    <h4 class="font-semibold text-blue-900 mb-2">PIX Payment</h4>
                    <p class="text-sm text-blue-800 mb-3">Scan the QR code below to complete your payment:</p>
                    <div class="bg-white p-4 inline-block rounded-lg">
                        <!-- QR Code placeholder - integrate with PIX provider -->
                        <div class="w-48 h-48 bg-gray-200 flex items-center justify-center">
                            <p class="text-gray-500 text-sm">PIX QR Code</p>
                        </div>
                    </div>
                    <p class="text-xs text-blue-700 mt-2">Payment will be confirmed automatically</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('customer.orders.show', $order->id) }}" 
               class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-center font-semibold">
                View Order Details
            </a>
            <a href="{{ route('home') }}" 
               class="px-6 py-3 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 text-center font-semibold">
                Continue Shopping
            </a>
        </div>
    </div>
</x-app-layout>

