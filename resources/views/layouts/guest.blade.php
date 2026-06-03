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
    <body class="font-sans antialiased bg-arsa-900 text-gray-100" x-data="{ mobileMenuOpen: false }">
        <!-- Navigation -->
        <nav class="bg-black/80 backdrop-blur-md border-b border-gray-800 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 md:h-20">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center gap-3">
                            <div class="w-9 h-9 md:w-10 md:h-10 bg-gold-500 rounded-sm flex items-center justify-center">
                                <span class="text-black font-black text-lg md:text-xl" style="font-family: 'Space Grotesk', sans-serif;">N</span>
                            </div>
                            <span class="text-lg md:text-xl font-black text-white" style="font-family: 'Space Grotesk', sans-serif;">Nova<span class="text-gold-400">Dex</span></span>
                        </a>
                        <div class="hidden md:flex ml-8 lg:ml-12 space-x-1">
                            <a href="{{ route('home') }}" class="text-gray-300 hover:text-gold-400 px-3 lg:px-4 py-2 text-sm font-medium transition-colors">Beranda</a>
                            <a href="{{ route('umkm.index') }}" class="text-gray-300 hover:text-gold-400 px-3 lg:px-4 py-2 text-sm font-medium transition-colors">Katalog</a>
                            <a href="{{ route('umkm.categories') }}" class="text-gray-300 hover:text-gold-400 px-3 lg:px-4 py-2 text-sm font-medium transition-colors">Kategori</a>
                            <a href="{{ route('umkm.map') }}" class="text-gray-300 hover:text-gold-400 px-3 lg:px-4 py-2 text-sm font-medium transition-colors">Peta</a>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex px-4 py-2 bg-gold-500 hover:bg-gold-400 text-black text-sm font-bold rounded-lg transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="hidden sm:inline-flex text-gray-300 hover:text-white px-4 py-2 text-sm font-medium transition-colors">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="hidden sm:inline-flex bg-gold-500 hover:bg-gold-400 text-black px-5 py-2 rounded-lg text-sm font-bold transition-colors">
                                Daftar
                            </a>
                        @endauth
                        <!-- Mobile menu button -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-300 hover:text-white p-2">
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
                 class="md:hidden border-t border-gray-800 bg-black/95 backdrop-blur-md"
                 style="display: none;">
                <div class="px-4 py-4 space-y-2">
                    <a href="{{ route('home') }}" class="block px-4 py-3 text-gray-300 hover:text-gold-400 hover:bg-arsa-800 rounded-lg font-medium transition-colors">Beranda</a>
                    <a href="{{ route('umkm.index') }}" class="block px-4 py-3 text-gray-300 hover:text-gold-400 hover:bg-arsa-800 rounded-lg font-medium transition-colors">Katalog</a>
                    <a href="{{ route('umkm.categories') }}" class="block px-4 py-3 text-gray-300 hover:text-gold-400 hover:bg-arsa-800 rounded-lg font-medium transition-colors">Kategori</a>
                    <a href="{{ route('umkm.map') }}" class="block px-4 py-3 text-gray-300 hover:text-gold-400 hover:bg-arsa-800 rounded-lg font-medium transition-colors">Peta</a>
                    <div class="border-t border-gray-800 pt-3 mt-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-gold-400 hover:bg-arsa-800 rounded-lg font-bold transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block px-4 py-3 text-gray-300 hover:text-white hover:bg-arsa-800 rounded-lg font-medium transition-colors">Masuk</a>
                            <a href="{{ route('register') }}" class="block px-4 py-3 mt-2 bg-gold-500 text-black rounded-lg font-bold text-center">Daftar</a>
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
        <footer class="bg-arsa-950 border-t border-arsa-700 py-12 lg:py-14">
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10">
                    <div class="sm:col-span-2">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-9 h-9 bg-gold-500 rounded-sm flex items-center justify-center">
                                <span class="text-black font-black text-lg" style="font-family: 'Space Grotesk', sans-serif;">N</span>
                            </div>
                            <span class="text-xl font-black text-white" style="font-family: 'Space Grotesk', sans-serif;">Nova<span class="text-gold-400">Dex</span></span>
                        </div>
                        <p class="text-gray-400 leading-relaxed max-w-sm text-sm">
                            Platform katalog digital yang membangun fondasi digital untuk UMKM Kota Salatiga. Menghubungkan bisnis lokal dengan masyarakat.
                        </p>
                    </div>
                    <div>
                        <h3 class="font-bold text-white mb-3 text-sm">Navigasi</h3>
                        <ul class="space-y-2 text-gray-400 text-sm">
                            <li><a href="{{ route('home') }}" class="hover:text-gold-400 transition-colors">Beranda</a></li>
                            <li><a href="{{ route('umkm.index') }}" class="hover:text-gold-400 transition-colors">Katalog UMKM</a></li>
                            <li><a href="{{ route('umkm.categories') }}" class="hover:text-gold-400 transition-colors">Kategori</a></li>
                            <li><a href="{{ route('umkm.map') }}" class="hover:text-gold-400 transition-colors">Peta</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold text-white mb-3 text-sm">Kontak</h3>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Pemerintah Kota Salatiga<br>
                            Jawa Tengah, Indonesia
                        </p>
                    </div>
                </div>
                <div class="border-t border-arsa-700 mt-8 pt-6 flex flex-col sm:flex-row justify-between items-center gap-2">
                    <p class="text-gray-500 text-xs">&copy; {{ date('Y') }} NovaDex. Hak Cipta Dilindungi.</p>
                    <p class="text-gray-600 text-xs">Platform Digital UMKM Salatiga</p>
                </div>
            </div>
        </footer>
    </body>
</html>
