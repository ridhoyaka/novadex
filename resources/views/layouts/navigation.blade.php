<nav x-data="{ open: false }" class="bg-arsa-900 border-b border-arsa-800 shadow-lg sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gold-400 rounded-sm flex items-center justify-center text-arsa-900 font-bold text-xl shadow-lg">
                            N
                        </div>
                        <span class="text-xl font-bold text-white">NovaDex</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(auth()->user()->isSuperAdmin())
                    <x-nav-link :href="route('superadmin.dashboard')" :active="request()->routeIs('superadmin.dashboard')">
                        Dashboard
                    </x-nav-link>
                    <x-nav-link :href="route('superadmin.users.index')" :active="request()->routeIs('superadmin.users.*')">
                        Users
                    </x-nav-link>
                    <x-nav-link :href="route('superadmin.categories.index')" :active="request()->routeIs('superadmin.categories.*')">
                        Kategori
                    </x-nav-link>
                    <x-nav-link :href="route('superadmin.districts.index')" :active="request()->routeIs('superadmin.districts.*')">
                        Kecamatan
                    </x-nav-link>
                    <x-nav-link :href="route('superadmin.umkm.index')" :active="request()->routeIs('superadmin.umkm.*')">
                        UMKM
                    </x-nav-link>
                    @elseif(auth()->user()->isAdmin())
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        Dashboard
                    </x-nav-link>
                    <x-nav-link :href="route('admin.umkm.index')" :active="request()->routeIs('admin.umkm.*')">
                        UMKM
                    </x-nav-link>
                    <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                        Kategori
                    </x-nav-link>
                    @elseif(auth()->user()->isUmkm())
                    <x-nav-link :href="route('umkm.dashboard')" :active="request()->routeIs('umkm.dashboard')">
                        Dashboard
                    </x-nav-link>
                    <x-nav-link :href="route('umkm.profile.edit')" :active="request()->routeIs('umkm.profile.*')">
                        Profil UMKM
                    </x-nav-link>
                    @else
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>
                    @endif
                    <x-nav-link :href="route('home')">
                        Lihat Website
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-arsa-300 bg-arsa-800 hover:text-white hover:bg-arsa-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profil Akun
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                Keluar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-arsa-400 hover:text-white hover:bg-arsa-800 focus:outline-none focus:bg-arsa-800 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->isSuperAdmin())
            <x-responsive-nav-link :href="route('superadmin.dashboard')" :active="request()->routeIs('superadmin.dashboard')">
                Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('superadmin.users.index')" :active="request()->routeIs('superadmin.users.*')">
                Users
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('superadmin.categories.index')" :active="request()->routeIs('superadmin.categories.*')">
                Kategori
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('superadmin.districts.index')" :active="request()->routeIs('superadmin.districts.*')">
                Kecamatan
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('superadmin.umkm.index')" :active="request()->routeIs('superadmin.umkm.*')">
                UMKM
            </x-responsive-nav-link>
            @elseif(auth()->user()->isAdmin())
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.umkm.index')" :active="request()->routeIs('admin.umkm.*')">
                UMKM
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                Kategori
            </x-responsive-nav-link>
            @elseif(auth()->user()->isUmkm())
            <x-responsive-nav-link :href="route('umkm.dashboard')" :active="request()->routeIs('umkm.dashboard')">
                Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('umkm.profile.edit')" :active="request()->routeIs('umkm.profile.*')">
                Profil UMKM
            </x-responsive-nav-link>
            @else
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('home')">
                Lihat Website
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-arsa-800">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-arsa-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profil Akun
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        Keluar
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
