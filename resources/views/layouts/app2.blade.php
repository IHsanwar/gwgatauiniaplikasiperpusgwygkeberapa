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

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-orange-600 to-indigo-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold flex items-center">
                        <i class="bi bi-bookshelf mr-2"></i>
                        <span class="tracking-tight">Perpustakaan<span class="text-blue-200">Online</span></span>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <span class="hidden md:inline text-sm font-medium">
                            Hi,<a href="{{ route('profile.main') }}"> {{ Auth::user()->name }}</a>
                        </span>

                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.users.index') }}" 
                               class="px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-full shadow">
                                Admin Panel
                            </a>
                        @elseif(Auth::user()->role === 'petugas')
                            <a href="{{ route('petugas.dashboard') }}" 
                               class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded-full shadow">
                                Petugas Panel
                            </a>
                       
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-bold rounded shadow">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-3 py-1 bg-white text-blue-600 hover:bg-gray-100 font-medium rounded shadow-sm">
                            Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white font-medium rounded shadow">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    <div class="flex flex-1">
    
    <!-- Main Content -->
    <main class="flex-grow mt-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        @yield('content')
        </div>
    </main>
</div>
    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-8 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-600 text-sm">
            &copy; {{ date('Y') }} Perpustakaan Online. All rights reserved.
            <div class="mt-1">
                <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mx-1"></span>
                <span class="inline-block w-2 h-2 bg-emerald-500 rounded-full mx-1"></span>
                <span class="inline-block w-2 h-2 bg-amber-500 rounded-full mx-1"></span>
            </div>
        </div>
    </footer>

    <!-- Optional: Bootstrap Icons via CDN (for book, user, etc.) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</body>
</html>