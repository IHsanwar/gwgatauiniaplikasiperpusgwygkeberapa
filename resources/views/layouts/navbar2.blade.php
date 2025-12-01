<nav class="bg-white shadow-md border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold flex items-center text-gray-800">
                    <i class="bi bi-bookshelf mr-2 text-red-600"></i>
                    <span class="tracking-tight">
                        Digital<span class="text-red-500">Library</span>
                    </span>
                </a>
            </div>

            <!-- Right Menu -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- Name -->
                    <span class="hidden md:inline text-sm font-medium text-gray-700">
                        Hi, <a href="{{ route('profile.main') }}" class="text-red-600 hover:underline">
                            {{ Auth::user()->name }}
                        </a>
                    </span>

                    <!-- Profile Icon -->

                    <!-- Roles -->
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center bg-red-600 text-white hover:bg-white hover:text-red-600 hover:border-red-600 border transition rounded-lg px-4 py-2">
                    
                            <span><i class="bi bi-people"></i> Panel Admin</span>
                        </a>
                    @elseif(Auth::user()->role === 'petugas')
                        <a href="{{ route('petugas.dashboard') }}" class="inline-flex items-center bg-red-600 text-white hover:bg-white hover:text-red-600 hover:border-red-600 border transition rounded-lg px-4 py-2">
                    
                            <span><i class="bi bi-window-stack"></i> Panel petugas</span>
                        </a>
                    @elseif(Auth::user()->role === 'user')
                        <a href="{{ route('profile.main') }}" class="inline-flex items-center bg-red-600 text-white hover:bg-white hover:text-red-600 hover:border-red-600 border transition rounded-lg px-4 py-2">
                    
                            <span><i class="bi bi-journals"></i> Buku pinjaman</span>
                        </a>
                    @endif

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class=" inline-flex items-center bg-red-600 text-white hover:bg-white hover:text-red-600 hover:border-red-600 border transition rounded-lg px-4 py-2 mt-0">
                          <i class="bi bi-box-arrow-right"></i>Logout
                        </button>
                    </form>

                @else
                    <a href="{{ route('login') }}"
                       class="px-3 py-1 bg-white text-red-600 hover:bg-gray-100 font-medium rounded shadow-sm">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white font-medium rounded shadow">
                        Register
                    </a>
                @endauth
            </div>

        </div>
    </div>
</nav>
