<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Perpustakaan') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS (via Vite) -->
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-gray-100 min-h-screen flex flex-col">

    <div class="min-h-screen bg-gray-100 flex">
        <!-- Left Side - Image Section -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-red-600 to-indigo-700 items-center justify-center p-12">
            <div class="text-center text-white">
                <div class="mb-8">
                    <i class="bi bi-bookshelf text-6xl mb-4 block"></i>
                </div>
                <h1 class="text-4xl font-bold mb-4">Perpustakaan Online</h1>
                <img class="center mx-2 h-64 rounded-lg" src="https://www.creativefabrica.com/wp-content/uploads/2020/09/17/Book-Logo-Graphics-5535886-1.jpg">
                <p class="text-lg text-red-100 mb-6">Jelajahi koleksi buku digital terlengkap</p>
               
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md">
                <!-- Header -->
                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Masuk</h2>
                    <p class="text-gray-600">Selamat datang kembali ke Perpustakaan Online</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
                        <x-text-input 
                            id="email" 
                            class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 transition" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autofocus 
                            autocomplete="username"
                            placeholder="nama@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
                        <x-text-input 
                            id="password" 
                            class="block mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 transition"
                            type="password"
                            name="password"
                            required 
                            autocomplete="current-password"
                            placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500" 
                                name="remember">
                            <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-red-600 hover:text-red-700 font-medium" href="{{ route('password.request') }}">
                                {{ __('Lupa password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-indigo-700 hover:from-red-700 hover:to-indigo-800 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200">
                        {{ __('Masuk') }}
                    </button>
                </form>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-red-600 hover:text-red-700 font-semibold">
                            Daftar di sini
                        </a>
                    </p>
                </div>

                <!-- Divider -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-center text-xs text-gray-500">
                        &copy; {{ date('Y') }} Perpustakaan Online. Semua hak dilindungi.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
</body>