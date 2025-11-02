<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Pedidos Forma de Amor - E-commerce' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">
                                Pedidos Forma de Amor
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') ? 'border-indigo-400' : 'border-transparent' }} text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                                Home
                            </a>
                            <a href="{{ route('about') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('about') ? 'border-indigo-400' : 'border-transparent' }} text-sm font-medium leading-5 text-gray-900 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                About
                            </a>
                            <a href="{{ route('faq') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('faq') ? 'border-indigo-400' : 'border-transparent' }} text-sm font-medium leading-5 text-gray-900 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                FAQ
                            </a>
                            <a href="{{ route('contact') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('contact') ? 'border-indigo-400' : 'border-transparent' }} text-sm font-medium leading-5 text-gray-900 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                Contact
                            </a>
                        </div>
                    </div>

                    <!-- Right Side Navigation -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" class="relative mr-4 text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ session()->has('cart') ? count(session('cart')) : 0 }}
                            </span>
                        </a>

                        @auth('customer')
                            <!-- Customer Dropdown -->
                            <div class="ml-3 relative">
                                <a href="{{ route('customer.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                                    {{ Auth::guard('customer')->user()->name }}
                                </a>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 mr-4">Login</a>
                            <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white mt-12">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">About Us</h3>
                        <p class="text-gray-400">
                            Modern e-commerce platform built with Laravel 12.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="{{ route('about') }}" class="hover:text-white">About</a></li>
                            <li><a href="{{ route('faq') }}" class="hover:text-white">FAQ</a></li>
                            <li><a href="{{ route('contact') }}" class="hover:text-white">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contact</h3>
                        <p class="text-gray-400">
                            Email: contato@pedidosformadeamor.com<br>
                            Phone: +55 (xx) xxxx-xxxx
                        </p>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-700 pt-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} Pedidos Forma de Amor. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
