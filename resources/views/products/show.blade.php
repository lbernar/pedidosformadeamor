<x-app-layout>
    <x-slot name="title">{{ $product->name }} - Pedidos Forma de Amor</x-slot>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Images -->
            <div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-4">
                    <img id="mainImage" 
                         src="{{ asset('storage/products/' . $product->featured_photo) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-96 object-cover"
                         onerror="this.src='https://via.placeholder.com/600x400?text=No+Image'">
                </div>
                
                @if($product->photos->count() > 0)
                <div class="grid grid-cols-4 gap-2">
                    <div class="cursor-pointer hover:opacity-75">
                        <img src="{{ asset('storage/products/' . $product->featured_photo) }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-20 object-cover rounded"
                             onclick="document.getElementById('mainImage').src=this.src">
                    </div>
                    @foreach($product->photos as $photo)
                    <div class="cursor-pointer hover:opacity-75">
                        <img src="{{ asset('storage/products/' . $photo->photo) }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-20 object-cover rounded"
                             onclick="document.getElementById('mainImage').src=this.src">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                
                <!-- Rating -->
                @if($product->ratings->count() > 0)
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $product->average_rating)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="ml-2 text-gray-600">
                        ({{ $product->ratings->count() }} {{ $product->ratings->count() == 1 ? 'review' : 'reviews' }})
                    </span>
                </div>
                @endif

                <!-- Price -->
                <div class="mb-6">
                    <div class="flex items-baseline">
                        <span class="text-4xl font-bold text-gray-900">
                            R$ {{ number_format($product->current_price, 2, ',', '.') }}
                        </span>
                        @if($product->old_price)
                        <span class="ml-3 text-xl text-gray-500 line-through">
                            R$ {{ number_format($product->old_price, 2, ',', '.') }}
                        </span>
                        <span class="ml-2 bg-red-100 text-red-800 text-sm font-semibold px-2.5 py-0.5 rounded">
                            {{ round((($product->old_price - $product->current_price) / $product->old_price) * 100) }}% OFF
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Short Description -->
                @if($product->short_description)
                <p class="text-gray-700 mb-6">{{ $product->short_description }}</p>
                @endif

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <!-- Size Selection -->
                    @if($product->sizes->count() > 0)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Size:</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($product->sizes as $size)
                            <label class="cursor-pointer">
                                <input type="radio" name="size" value="{{ $size->name }}" class="sr-only peer" required>
                                <div class="px-4 py-2 border-2 border-gray-300 rounded-md peer-checked:border-indigo-600 peer-checked:bg-indigo-50 hover:border-indigo-400">
                                    {{ $size->name }}
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Color Selection -->
                    @if($product->colors->count() > 0)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Color:</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($product->colors as $color)
                            <label class="cursor-pointer">
                                <input type="radio" name="color" value="{{ $color->name }}" class="sr-only peer" required>
                                <div class="px-4 py-2 border-2 border-gray-300 rounded-md peer-checked:border-indigo-600 peer-checked:bg-indigo-50 hover:border-indigo-400 flex items-center">
                                    <span class="w-4 h-4 rounded-full mr-2" style="background-color: {{ $color->hex_code }}"></span>
                                    {{ $color->name }}
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Quantity -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantity:</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->qty }}" 
                               class="w-24 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">
                            ({{ $product->qty }} available)
                        </span>
                    </div>

                    <!-- Stock Status -->
                    <div class="mb-4">
                        @if($product->in_stock)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            In Stock
                        </span>
                        @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            Out of Stock
                        </span>
                        @endif
                    </div>

                    <!-- Add to Cart Button -->
                    @if($product->in_stock)
                    <button type="submit" class="w-full bg-indigo-600 text-white py-3 px-6 rounded-md hover:bg-indigo-700 font-semibold text-lg">
                        Add to Cart
                    </button>
                    @else
                    <button disabled class="w-full bg-gray-400 text-white py-3 px-6 rounded-md cursor-not-allowed font-semibold text-lg">
                        Out of Stock
                    </button>
                    @endif
                </form>

                <!-- Category -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Category: 
                        <a href="{{ route('products.category', [$product->endCategory->id, 'end']) }}" 
                           class="text-indigo-600 hover:text-indigo-700">
                            {{ $product->endCategory->name }}
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="mt-12">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button onclick="showTab('description')" id="tab-description" 
                            class="tab-button border-b-2 border-indigo-500 py-4 px-1 text-sm font-medium text-indigo-600">
                        Description
                    </button>
                    <button onclick="showTab('reviews')" id="tab-reviews" 
                            class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Reviews ({{ $product->ratings->count() }})
                    </button>
                </nav>
            </div>

            <!-- Description Tab -->
            <div id="content-description" class="tab-content py-8">
                <div class="prose max-w-none">
                    {!! nl2br(e($product->description)) !!}
                </div>

                @if($product->features)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-2">Features:</h3>
                    <div class="prose">
                        {!! nl2br(e($product->features)) !!}
                    </div>
                </div>
                @endif
            </div>

            <!-- Reviews Tab -->
            <div id="content-reviews" class="tab-content hidden py-8">
                @auth('customer')
                <!-- Add Review Form -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-4">Write a Review</h3>
                    <form action="{{ route('products.rate', $product->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating:</label>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $i }}" class="sr-only peer" required>
                                    <svg class="w-8 h-8 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                </label>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Comment:</label>
                            <textarea name="comment" rows="3" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Submit Review
                        </button>
                    </form>
                </div>
                @else
                <div class="bg-gray-50 rounded-lg p-6 mb-8 text-center">
                    <p class="text-gray-600">
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700">Login</a> 
                        to write a review
                    </p>
                </div>
                @endauth

                <!-- Reviews List -->
                <div class="space-y-6">
                    @forelse($product->ratings as $rating)
                    <div class="border-b border-gray-200 pb-6">
                        <div class="flex items-center mb-2">
                            <div class="flex text-yellow-400 mr-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $rating->rating ? 'fill-current' : 'fill-current text-gray-300' }}" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="font-semibold text-gray-900">{{ $rating->customer->name }}</span>
                            <span class="ml-2 text-sm text-gray-500">{{ $rating->created_at->format('M d, Y') }}</span>
                        </div>
                        @if($rating->comment)
                        <p class="text-gray-700">{{ $rating->comment }}</p>
                        @endif
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-8">No reviews yet. Be the first to review!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-button').forEach(el => {
                el.classList.remove('border-indigo-500', 'text-indigo-600');
                el.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab
            document.getElementById('content-' + tabName).classList.remove('hidden');
            document.getElementById('tab-' + tabName).classList.remove('border-transparent', 'text-gray-500');
            document.getElementById('tab-' + tabName).classList.add('border-indigo-500', 'text-indigo-600');
        }
    </script>
</x-app-layout>

