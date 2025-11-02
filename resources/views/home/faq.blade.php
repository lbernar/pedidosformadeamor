<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-6">Frequently Asked Questions</h1>
                    
                    @if($faqs->count() > 0)
                        <div class="space-y-4">
                            @foreach($faqs as $faq)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        {{ $faq->question }}
                                    </h3>
                                    <p class="text-gray-700">
                                        {{ $faq->answer }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No FAQs available</h3>
                            <p class="mt-1 text-sm text-gray-500">Check back later for frequently asked questions.</p>
                        </div>
                    @endif
                    
                    <div class="mt-8 p-6 bg-gray-50 rounded-lg">
                        <h2 class="text-xl font-semibold mb-3">Still have questions?</h2>
                        <p class="text-gray-700 mb-4">
                            Can't find the answer you're looking for? Please contact our support team.
                        </p>
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

