
  @extends('layouts.app2')
  @section('content')

        

  <main class="min-h-[70vh] flex items-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
        <!-- Left: Illustration / image -->
        <div class="order-2 lg:order-1">
          <div class="bg-gradient-to-br from-red-50 to-indigo-50 rounded-2xl p-6 shadow-md">
            <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?q=80&w=1200&auto=format&fit=crop&ixlib=rb-4.0.3&s=0d5b3f082d5f4b1a5fb0f9a2b6e0e7f4" 
                 alt="Books" 
                 class="w-full h-96 object-cover rounded-xl shadow-sm">
          </div>
        </div>

        <!-- Right: Hero content -->
        <div class="order-1 lg:order-2">
          <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
            Perpustakaan Digital — Akses Buku Dimanapun
          </h1>
          <p class="text-gray-600 mb-6">
            Temukan, pinjam, dan baca koleksi buku digital dan fisik kami. Mudah diakses, tersusun rapi, dan selalu up-to-date.
          </p>

          <div class="flex flex-wrap gap-3 mb-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-red-500 text-white rounded-lg shadow hover:scale-[1.01] transition">
              <i class="bi bi-book-half"></i>
              Jelajahi Koleksi
            </a>

            @if (Route::has('login'))
              @guest
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-3 border border-gray-200 bg-white text-gray-800 rounded-lg shadow-sm hover:shadow-md transition">
                  <i class="bi bi-box-arrow-in-right"></i>
                  Masuk
                </a>
              @endguest
            @endif
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="p-4 bg-white rounded-lg shadow-sm">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                  <i class="bi bi-journal-bookmark"></i>
                </div>
                <div>
                  <div class="text-sm font-semibold">Ribuan Judul</div>
                  <div class="text-xs text-gray-500">Fiksi, non-fiksi & akademik</div>
                </div>
              </div>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-sm">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-green-50 text-green-600">
                  <i class="bi bi-clock-history"></i>
                </div>
                <div>
                  <div class="text-sm font-semibold">Pinjam Buku Fisik Via Online</div>
                  <div class="text-xs text-gray-500">Proses cepat & mudah</div>
                </div>
              </div>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-sm">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                  <i class="bi bi-cloud-download"></i>
                </div>
                <div>
                  <div class="text-sm font-semibold">Baca Online</div>
                  <div class="text-xs text-gray-500">Akses e-book kapan saja</div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </main>

  <section class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-2xl font-semibold mb-6 text-gray-800">Fitur Utama</h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 bg-gray-50 rounded-lg shadow-sm">
          <h3 class="font-semibold mb-2">Cari Cepat</h3>
          <p class="text-sm text-gray-600">Pencarian berdasarkan judul, pengarang, atau ISBN.</p>
        </div>

        <div class="p-6 bg-gray-50 rounded-lg shadow-sm">
          <h3 class="font-semibold mb-2">Kelola Peminjaman</h3>
          <p class="text-sm text-gray-600">Lihat status peminjaman, tenggat, dan riwayat Anda.</p>
        </div>

        <div class="p-6 bg-gray-50 rounded-lg shadow-sm">
          <h3 class="font-semibold mb-2">Dashboard Admin & Petugas</h3>
          <p class="text-sm text-gray-600">Manajemen koleksi, pengguna, dan laporan.</p>
        </div>
      </div>
    </div>
  </section>
@endsection
