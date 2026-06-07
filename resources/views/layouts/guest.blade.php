<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NovaDex') }} - Platform Digital UMKM Salatiga</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900|space-grotesk:700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Dynamic Meta Tags -->
        @stack('meta')
        
        <!-- Dynamic Styles -->
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-[#10130f] text-gray-100" x-data="{ mobileMenuOpen: false }">
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 border-b border-white/10 bg-[#10130f]/95 backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 md:h-20">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center border border-[#d4a945] bg-[#d4a945] md:h-10 md:w-10">
                                <span class="text-lg font-black text-[#10130f] md:text-xl" style="font-family: 'Space Grotesk', sans-serif;">N</span>
                            </div>
                            <span class="text-lg md:text-xl font-black text-white" style="font-family: 'Space Grotesk', sans-serif;">Nova<span class="text-gold-400">Dex</span></span>
                        </a>
                        <div class="hidden md:flex ml-8 lg:ml-12 items-center gap-1">
                            <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium text-white/70 transition-colors hover:text-[#d4a945] lg:px-4">Beranda</a>
                            <a href="{{ route('umkm.index') }}" class="px-3 py-2 text-sm font-medium text-white/70 transition-colors hover:text-[#d4a945] lg:px-4">Katalog</a>
                            <a href="{{ route('umkm.categories') }}" class="px-3 py-2 text-sm font-medium text-white/70 transition-colors hover:text-[#d4a945] lg:px-4">Kategori</a>
                            <a href="{{ route('umkm.map') }}" class="px-3 py-2 text-sm font-medium text-white/70 transition-colors hover:text-[#d4a945] lg:px-4">Peta</a>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="hidden min-h-10 items-center border border-[#d4a945] bg-[#d4a945] px-4 py-2 text-sm font-bold text-[#10130f] transition-colors hover:bg-[#e2bd62] sm:inline-flex">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="hidden px-4 py-2 text-sm font-medium text-white/70 transition-colors hover:text-white sm:inline-flex">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="hidden min-h-10 items-center border border-[#d4a945] bg-[#d4a945] px-5 py-2 text-sm font-bold text-[#10130f] transition-colors hover:bg-[#e2bd62] sm:inline-flex">
                                Daftar
                            </a>
                        @endauth
                        <!-- Mobile menu button -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-white/70 transition hover:text-white md:hidden" aria-label="Toggle navigation">
                            <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-1"
                 class="border-t border-white/10 bg-[#10130f]/[0.98] backdrop-blur-md md:hidden"
                 style="display: none;">
                <div class="space-y-2 px-4 py-4">
                    <a href="{{ route('home') }}" class="block px-4 py-3 font-medium text-white/70 transition-colors hover:bg-white/[0.06] hover:text-[#d4a945]">Beranda</a>
                    <a href="{{ route('umkm.index') }}" class="block px-4 py-3 font-medium text-white/70 transition-colors hover:bg-white/[0.06] hover:text-[#d4a945]">Katalog</a>
                    <a href="{{ route('umkm.categories') }}" class="block px-4 py-3 font-medium text-white/70 transition-colors hover:bg-white/[0.06] hover:text-[#d4a945]">Kategori</a>
                    <a href="{{ route('umkm.map') }}" class="block px-4 py-3 font-medium text-white/70 transition-colors hover:bg-white/[0.06] hover:text-[#d4a945]">Peta</a>
                    <div class="mt-3 border-t border-white/10 pt-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="block px-4 py-3 font-bold text-[#d4a945] transition-colors hover:bg-white/[0.06]">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block px-4 py-3 font-medium text-white/70 transition-colors hover:bg-white/[0.06] hover:text-white">Masuk</a>
                            <a href="{{ route('register') }}" class="mt-2 block bg-[#d4a945] px-4 py-3 text-center font-bold text-[#10130f]">Daftar</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="border-t border-white/10 bg-[#10130f] py-10 lg:py-12">
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4 lg:gap-10">
                    <div class="sm:col-span-2">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex h-9 w-9 items-center justify-center bg-[#d4a945]">
                                <span class="text-lg font-black text-[#10130f]" style="font-family: 'Space Grotesk', sans-serif;">N</span>
                            </div>
                            <span class="text-xl font-black text-white" style="font-family: 'Space Grotesk', sans-serif;">Nova<span class="text-gold-400">Dex</span></span>
                        </div>
                        <p class="max-w-sm text-sm leading-6 text-white/60">
                            Direktori UMKM Kota Salatiga untuk pencarian usaha, kurasi profil, dan presentasi data yang lebih rapi.
                        </p>
                    </div>
                    <div>
                        <h3 class="font-bold text-white mb-3 text-sm">Navigasi</h3>
                        <ul class="space-y-2 text-sm text-white/60">
                            <li><a href="{{ route('home') }}" class="transition-colors hover:text-[#d4a945]">Beranda</a></li>
                            <li><a href="{{ route('umkm.index') }}" class="transition-colors hover:text-[#d4a945]">Katalog UMKM</a></li>
                            <li><a href="{{ route('umkm.categories') }}" class="transition-colors hover:text-[#d4a945]">Kategori</a></li>
                            <li><a href="{{ route('umkm.map') }}" class="transition-colors hover:text-[#d4a945]">Peta</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold text-white mb-3 text-sm">Kontak</h3>
                        <p class="text-sm leading-6 text-white/60">
                            Pemerintah Kota Salatiga<br>
                            Jawa Tengah, Indonesia
                        </p>
                    </div>
                </div>
                <div class="mt-8 flex flex-col items-center justify-between gap-2 border-t border-white/10 pt-6 sm:flex-row">
                    <p class="text-xs text-white/40">&copy; {{ date('Y') }} NovaDex. Hak Cipta Dilindungi.</p>
                    <p class="text-xs text-white/40">Platform Digital UMKM Salatiga</p>
                </div>
            </div>
        </footer>
    </body>
</html>
