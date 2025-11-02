<x-app-layout>
    <x-slot name="title">Home - Pedidos Forma de Amor</x-slot>

    <!-- Hero Slider -->
    @if($sliders->count() > 0)
    <div class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                @foreach($sliders->take(1) as $slider)
                    <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl md:text-6xl">
                        {{ $slider->heading }}
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-base text-gray-300 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        {{ $slider->content }}
                    </p>
                    @if($slider->button_text && $slider->button_url)
                        <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                            <div class="rounded-md shadow">
                                <a href="{{ $slider->button_url }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                    {{ $slider->button_text }}
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Featured Products -->
    @if($featuredProducts->count() > 0)
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Featured Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('products.show', $product->slug) }}">
                        <img src="{{ asset('storage/products/' . $product->featured_photo) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-48 object-cover"
                             onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                    </a>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-indigo-600">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xl font-bold text-gray-900">R$ {{ number_format($product->current_price, 2, ',', '.') }}</span>
                                @if($product->old_price)
                                    <span class="text-sm text-gray-500 line-through ml-2">R$ {{ number_format($product->old_price, 2, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                        @if($product->in_stock)
                            <a href="{{ route('products.show', $product->slug) }}" 
                               class="mt-4 w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 text-center block">
                                View Details
                            </a>
                        @else
                            <button disabled class="mt-4 w-full bg-gray-400 text-white py-2 px-4 rounded-md cursor-not-allowed text-center block">
                                Out of Stock
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Latest Products -->
    @if($latestProducts->count() > 0)
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Latest Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($latestProducts as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <img src="{{ asset('storage/products/' . $product->featured_photo) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-48 object-cover"
                                 onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                        </a>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                <a href="{{ route('products.show', $product->slug) }}" class="hover:text-indigo-600">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-bold text-gray-900">R$ {{ number_format($product->current_price, 2, ',', '.') }}</span>
                            </div>
                            @if($product->in_stock)
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="mt-4 w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 text-center block">
                                    View Details
                                </a>
                            @else
                                <button disabled class="mt-4 w-full bg-gray-400 text-white py-2 px-4 rounded-md cursor-not-allowed text-center block">
                                    Out of Stock
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</x-app-layout>

