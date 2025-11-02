<x-app-layout>
    <x-slot name="title">Home - Pedidos Forma de Amor</x-slot>

    <!-- Hero Slider -->
    @if($sliders->count() > 0)
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto py-20 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                @foreach($sliders->take(1) as $slider)
                    <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl md:text-6xl drop-shadow-lg">
                        {{ $slider->heading }}
                    </h1>
                    <p class="mt-4 max-w-2xl mx-auto text-xl text-white sm:text-2xl md:mt-6 md:max-w-3xl drop-shadow-md">
                        {{ $slider->content }}
                    </p>
                    @if($slider->button_text && $slider->button_url)
                        <div class="mt-8 max-w-md mx-auto sm:flex sm:justify-center md:mt-10">
                            <div class="rounded-md shadow-xl">
                                <a href="{{ $slider->button_url }}" class="w-full flex items-center justify-center px-8 py-4 border-2 border-white text-lg font-bold rounded-lg text-indigo-600 bg-white hover:bg-gray-100 hover:scale-105 transform transition-all duration-200 md:py-5 md:text-xl md:px-12">
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
                        @if($product->featured_photo && file_exists(storage_path('app/public/products/' . $product->featured_photo)))
                            <img src="{{ asset('storage/products/' . $product->featured_photo) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400 text-lg font-medium">No Image</span>
                            </div>
                        @endif
                    </a>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-indigo-600">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <span class="text-xl font-bold text-gray-900">R$ {{ number_format($product->current_price, 2, ',', '.') }}</span>
                                @if($product->old_price)
                                    <span class="text-sm text-gray-500 line-through ml-2">R$ {{ number_format($product->old_price, 2, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                        @if($product->qty > 0)
                            <a href="{{ route('products.show', $product->slug) }}" 
                               class="mt-2 w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                View Details
                            </a>
                        @else
                            <button disabled class="mt-2 w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-400 cursor-not-allowed">
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
                            @if($product->featured_photo && file_exists(storage_path('app/public/products/' . $product->featured_photo)))
                                <img src="{{ asset('storage/products/' . $product->featured_photo) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400 text-lg font-medium">No Image</span>
                                </div>
                            @endif
                        </a>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                <a href="{{ route('products.show', $product->slug) }}" class="hover:text-indigo-600">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <span class="text-xl font-bold text-gray-900">R$ {{ number_format($product->current_price, 2, ',', '.') }}</span>
                                    @if($product->old_price)
                                        <span class="text-sm text-gray-500 line-through ml-2">R$ {{ number_format($product->old_price, 2, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                            @if($product->qty > 0)
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="mt-2 w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    View Details
                                </a>
                            @else
                                <button disabled class="mt-2 w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-400 cursor-not-allowed">
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

