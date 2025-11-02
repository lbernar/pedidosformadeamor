<x-app-layout>
    <x-slot name="title">My Orders - Pedidos Forma de Amor</x-slot>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">My Orders</h1>

        @if($orders->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="divide-y divide-gray-200">
                @foreach($orders as $order)
                <div class="p-6 hover:bg-gray-50">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4">
                        <div class="flex-1 mb-4 lg:mb-0">
                            <div class="flex items-center flex-wrap gap-2">
                                <h3 class="text-lg font-semibold text-gray-900">Order #{{ $order->id }}</h3>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                           @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                           @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                           @elseif($order->status === 'completed') bg-green-100 text-green-800
                                           @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                           @else bg-gray-100 text-gray-800
                                           @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Shipping: {{ ucfirst($order->shipping_status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                            </p>
                            <p class="text-sm text-gray-600">
                                Payment: {{ ucfirst(str_replace('_', ' ', $order->payment->payment_method)) }}
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            <div class="text-left sm:text-right">
                                <p class="text-sm text-gray-600">Total</p>
                                <p class="text-2xl font-bold text-gray-900">R$ {{ number_format($order->total, 2, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">{{ $order->items->count() }} {{ $order->items->count() == 1 ? 'item' : 'items' }}</p>
                            </div>
                            <a href="{{ route('customer.orders.show', $order->id) }}" 
                               class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium whitespace-nowrap">
                                View Details
                            </a>
                        </div>
                    </div>

                    <!-- Order Items Preview -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4 mt-4">
                        @foreach($order->items->take(6) as $item)
                        <div class="flex flex-col">
                            @if($item->product && $item->product->featured_photo && file_exists(storage_path('app/public/products/' . $item->product->featured_photo)))
                                <img src="{{ asset('storage/products/' . $item->product->featured_photo) }}" 
                                     alt="{{ $item->product_name }}" 
                                     class="w-full h-24 object-cover rounded">
                            @else
                                <div class="w-full h-24 bg-gray-200 rounded flex items-center justify-center">
                                    <span class="text-gray-400 text-xs">No Image</span>
                                </div>
                            @endif
                            <p class="text-xs text-gray-600 mt-1 truncate">{{ $item->product_name }}</p>
                            <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                        </div>
                        @endforeach
                        
                        @if($order->items->count() > 6)
                        <div class="flex items-center justify-center bg-gray-100 rounded h-24">
                            <p class="text-sm text-gray-600 font-medium">+{{ $order->items->count() - 6 }} more</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $orders->links() }}
        </div>

        @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No orders yet</h3>
            <p class="mt-2 text-sm text-gray-500">You haven't placed any orders. Start shopping to see your orders here!</p>
            <div class="mt-6">
                <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Start Shopping
                </a>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>

