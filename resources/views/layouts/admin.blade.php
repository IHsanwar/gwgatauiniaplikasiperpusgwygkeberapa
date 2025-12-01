<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Digital') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
     <link href="https://fonts.bunny.net/css?family=poppins:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tailwind CSS (via Vite) -->
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('layouts.navbar2')


    <!-- Main Layout dengan Sidebar -->
    <div class="flex flex-1">
        <!-- Fixed Sidebar: fixed width, full height, scrollable -->
        



<!-- resources/views/layouts/sidebar_admin.blade.php -->
<aside class="w-64 bg-white border-r border-gray-200 min-h-screen p-5 hidden md:block">


<!-- Profile -->
<div class="flex flex-col items-center mb-8">
<div class="w-20 h-20 rounded-full bg-gray-100 overflow-hidden mb-3 justify-center flex items-center"><i class="bi bi-gear text-red-600 text-6xl"></i></div>
<h3 class="text-gray-700 text-sm font-semibold">@auth {{ Auth::user()->name }} @else Guest @endauth</h3>
</div>


<!-- Menu -->
<nav class="space-y-1">


<a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-100 font-medium' : '' }}">
<i class="bi bi-house-door mr-3 text-lg text-red-600"></i> Beranda
</a>


@auth
<a href="{{ route('profile.main') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 {{ request()->routeIs('profile.*') ? 'bg-gray-100 font-medium' : '' }}">
<i class="bi bi-person mr-3 text-lg text-red-600"></i> Profil
</a>


<a href="{{ route('admin.books.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 {{ request()->routeIs('admin.books.*') ? 'bg-gray-100 font-medium' : '' }}">
<i class="bi bi-journal-bookmark mr-3 text-lg text-red-600"></i> Manajemen Buku
</a>



@if (Auth::user()->role == 'petugas')
<a href="{{ route('petugas.dashboard') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 {{ request()->routeIs('petugas.*') ? 'bg-gray-100 font-medium' : '' }}">
<i class="bi bi-people-fill mr-3 text-lg text-red-600"></i> Panel Petugas
</a>
@elseif (Auth::user()->role == 'admin')
<a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-100 text-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 font-medium' : '' }}">
<i class="bi bi-people-fill mr-3 text-lg text-red-600"></i> Panel Admin
</a>
@endif
@endauth


</nav>
</aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-y-auto">
            <div class="max-w-7xl mx-auto">
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


    <!-- Bootstrap Icons via CDN -->
    
</body>
</html>