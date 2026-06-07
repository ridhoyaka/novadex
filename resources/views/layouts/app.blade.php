<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NovaDex') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:700|inter:400,500,600,700" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-arsa-900 text-gray-100" x-data="{ sidebarOpen: false }">
        <div class="flex min-h-screen h-screen overflow-hidden">
            
            <!-- Mobile Sidebar Overlay -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden"
                 style="display: none;"></div>

            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                   class="fixed inset-y-0 left-0 z-50 w-64 max-w-[86vw] bg-arsa-950 border-r border-arsa-800 flex flex-col transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto lg:z-auto">
                <!-- Logo -->
                <div class="h-16 flex items-center justify-between px-6 border-b border-arsa-800">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-gold-400 rounded-sm flex items-center justify-center">
                            <span class="text-black font-black text-lg" style="font-family: 'Space Grotesk', sans-serif;">N</span>
                        </div>
                        <span class="text-lg font-black text-white" style="font-family: 'Space Grotesk', sans-serif;">Nova<span class="text-gold-400">Dex</span></span>
                    </a>
                    <!-- Close button for mobile -->
                    <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto py-6 px-3">
                    @if(auth()->user()->isSuperAdmin())
                        <!-- Super Admin Menu (Full Access) -->
                        <div class="mb-3 px-4">
                            <p class="text-xs font-bold text-gold-400 uppercase tracking-wider">Super Admin</p>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-arsa-800 hover:text-gold-400 transition-all {{ request()->routeIs('superadmin.dashboard') ? 'bg-arsa-800 text-gold-400' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <span class="font-medium">Dashboard</span>
                            </a>
                            
                            <a href="{{ route('superadmin.umkm.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-arsa-800 hover:text-gold-400 transition-all {{ request()->routeIs('superadmin.umkm.*') ? 'bg-arsa-800 text-gold-400' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span class="font-medium">Kelola UMKM</span>
                            </a>
                            
                            <a href="{{ route('superadmin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-arsa-800 hover:text-gold-400 transition-all {{ request()->routeIs('superadmin.users.*') ? 'bg-arsa-800 text-gold-400' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <span class="font-medium">Kelola Users</span>
                            </a>
                            
                            <a href="{{ route('superadmin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-arsa-800 hover:text-gold-400 transition-all {{ request()->routeIs('superadmin.categories.*') ? 'bg-arsa-800 text-gold-400' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                <span class="font-medium">Kelola Kategori</span>
                            </a>
                            
                            <a href="{{ route('superadmin.districts.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-arsa-800 hover:text-gold-400 transition-all {{ request()->routeIs('superadmin.districts.*') ? 'bg-arsa-800 text-gold-400' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <span class="font-medium">Kelola Kecamatan</span>
                            </a>
                        </div>

                        <div class="mt-6 mb-3 px-4">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Akses Admin</p>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-arsa-800 hover:text-gold-400 transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-arsa-800 text-gold-400' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                                </svg>
                                <span class="font-medium">Dashboard Admin</span>
                            </a>
                            <a href="{{ route('admin.content.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-arsa-800 hover:text-gold-400 transition-all {{ request()->routeIs('admin.content.*') && !request()->routeIs('admin.content.map') ? 'bg-arsa-800 text-gold-400' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                                </svg>
                                <span class="font-medium">Monitoring Konten</span>
                            </a>
                            <a href="{{ route('admin.content.map') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-arsa-800 hover:text-gold-400 transition-all {{ request()->routeIs('admin.content.map') ? 'bg-arsa-800 text-gold-400' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                                <span class="font-medium">Peta Admin</span>
                            </a>
                        </div>
                    @elseif(auth()->user()->isAdmin())
                        <!-- Admin Menu -->
                        <div class="mb-3 px-4">
                            <p class="text-xs font-bold text-purple-400 uppercase tracking-wider">Admin</p>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-arsa-800 hover:text-gold-400 transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-arsa-800 text-gold-400' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span class="font-medium">Dashboard</span>
                            </a>
                            
                            <a href="{{ route('admin.umkm.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-arsa-800 hover:text-gold-400 transition-all {{ request()->routeIs('admin.umkm.*') ? 'bg-arsa-800 text-gold-400' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span class="font-medium">UMKM</span>
                            </a>

                            <a href="{{ route('admin.content.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-arsa-800 hover:text-gold-400 transition-all {{ request()->routeIs('admin.content.*') && !request()->routeIs('admin.content.map') ? 'bg-arsa-800 text-gold-400' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                                </svg>
                                <span class="font-medium">Monitoring Konten</span>
                            </a>
                            
                            <a href="{{ route('admin.content.map') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-arsa-800 hover:text-gold-400 transition-all {{ request()->routeIs('admin.content.map') ? 'bg-arsa-800 text-gold-400' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                                <span class="font-medium">Peta UMKM</span>
                            </a>
                            
                            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-arsa-800 hover:text-gold-400 transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-arsa-800 text-gold-400' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                <span class="font-medium">Kategori</span>
                            </a>
                        </div>
                    @elseif(auth()->user()->isUmkm())
                        <!-- UMKM Menu -->
                        <div class="mb-3 px-4">
                            <p class="text-xs font-bold text-blue-400 uppercase tracking-wider">UMKM</p>
                        </div>
                        <div class="space-y-1">
                            <a href="{{ route('umkm.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-arsa-800 hover:text-gold-400 transition-all {{ request()->routeIs('umkm.dashboard') ? 'bg-arsa-800 text-gold-400' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span class="font-medium">Dashboard</span>
                            </a>
                            
                            <a href="{{ route('umkm.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-arsa-800 hover:text-gold-400 transition-all {{ request()->routeIs('umkm.profile.*') ? 'bg-arsa-800 text-gold-400' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="font-medium">Profil UMKM</span>
                            </a>
                        </div>
                    @endif

                    <!-- Divider -->
                    <div class="my-6 border-t border-arsa-800"></div>

                    <!-- Public Link -->
                    @php
                        $ownedProfile = auth()->user()->isUmkm() ? auth()->user()->umkmProfile : null;
                        $websiteHref = ($ownedProfile && $ownedProfile->is_published)
                            ? route('umkm.show', $ownedProfile->slug)
                            : route('home');
                        $websiteLabel = auth()->user()->isUmkm() ? 'Website Saya' : 'Lihat Website';
                    @endphp
                    <a href="{{ $websiteHref }}" @if($ownedProfile && $ownedProfile->is_published) target="_blank" @endif class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-arsa-800 hover:text-gold-400 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                        <span class="font-medium">{{ $websiteLabel }}</span>
                    </a>
                </nav>

                <!-- User Profile -->
                <div class="border-t border-arsa-800 p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-gold-400 rounded-sm flex items-center justify-center text-arsa-900 font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-300 hover:bg-arsa-800 hover:text-gold-400 rounded-lg transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Pengaturan</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-gray-300 hover:bg-arsa-800 hover:text-red-400 rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 min-w-0 flex flex-col overflow-hidden">
                <!-- Top Bar -->
                <header class="min-h-16 bg-arsa-900 border-b border-arsa-800 flex items-center justify-between gap-3 px-4 py-3 lg:px-6">
                    <div class="flex items-center gap-3 flex-1 min-w-0 overflow-hidden">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = true" class="lg:hidden text-gray-400 hover:text-white flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <div class="flex-1 min-w-0 overflow-hidden">
                            @if (isset($header))
                                {{ $header }}
                            @endif
                        </div>
                    </div>
                    
                    <!-- Role Badge -->
                    <div class="flex-shrink-0">
                        @if(auth()->user()->isSuperAdmin())
                        <span class="px-3 py-1 text-xs font-semibold bg-gold-50 text-gold-700">Super Admin</span>
                        @elseif(auth()->user()->isAdmin())
                        <span class="px-3 py-1 text-xs font-semibold bg-arsa-100 text-arsa-700">Admin</span>
                        @elseif(auth()->user()->isUmkm())
                        <span class="px-3 py-1 text-xs font-semibold bg-[#e7f7f4] text-[#1d675d]">UMKM</span>
                        @endif
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto bg-arsa-900">
                    {{ $slot }}
                </main>
            </div>

        </div>
        
        <!-- Dynamic Scripts -->
        @stack('scripts')
    </body>
</html>
