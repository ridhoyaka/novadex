<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <!-- Left Side - Branding -->
            <div class="hidden lg:block">
                <div class="relative">
                    <!-- Geometric Background -->
                    <div class="absolute inset-0 opacity-20">
                        <div class="absolute top-0 left-0 w-64 h-64 border border-gold-500/30 rotate-12"></div>
                        <div class="absolute bottom-0 right-0 w-48 h-48 border-2 border-gold-500/20 -rotate-12"></div>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="mb-8">
                            <div class="w-20 h-20 bg-gradient-to-br from-gold-500 to-gold-600 rounded-xl flex items-center justify-center shadow-2xl shadow-gold-500/30 mb-6">
                                <span class="text-black font-black text-4xl" style="font-family: 'Space Grotesk', sans-serif;">A</span>
                            </div>
                        </div>
                        
                        <h1 class="text-5xl font-black text-white mb-4 tracking-tight" style="font-family: 'Space Grotesk', sans-serif;">
                            Selamat Datang di NovaDex
                        </h1>
                        
                        <p class="text-xl text-gray-400 mb-8 leading-relaxed">
                            Platform katalog digital untuk UMKM Kota Salatiga
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-gold-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold mb-1">Kelola Profil UMKM</h3>
                                    <p class="text-gray-400 text-sm">Tampilkan informasi lengkap usaha Anda</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-gold-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold mb-1">Jangkau Lebih Banyak Pelanggan</h3>
                                    <p class="text-gray-400 text-sm">Tingkatkan visibilitas bisnis lokal Anda</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-gold-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold mb-1">Gratis & Mudah</h3>
                                    <p class="text-gray-400 text-sm">Daftar dan kelola profil tanpa biaya</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full">
                <div class="bg-arsa-800 border border-arsa-700 rounded-2xl shadow-2xl p-8 lg:p-12">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden mb-8 text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-gold-500 to-gold-600 rounded-xl flex items-center justify-center shadow-2xl shadow-gold-500/30 mx-auto mb-4">
                            <span class="text-black font-black text-3xl" style="font-family: 'Space Grotesk', sans-serif;">N</span>
                        </div>
                        <h2 class="text-3xl font-black text-white" style="font-family: 'Space Grotesk', sans-serif;">NovaDex</h2>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-3xl font-black text-white mb-2" style="font-family: 'Space Grotesk', sans-serif;">Masuk ke Akun</h2>
                        <p class="text-gray-400">Kelola profil UMKM Anda</p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-white mb-2 tracking-wide">EMAIL</label>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required 
                                   autofocus 
                                   autocomplete="username"
                                   class="w-full px-4 py-3.5 bg-arsa-900 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                                   placeholder="nama@email.com">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-white mb-2 tracking-wide">PASSWORD</label>
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   class="w-full px-4 py-3.5 bg-arsa-900 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                                   placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                                <input id="remember_me" 
                                       type="checkbox" 
                                       name="remember"
                                       class="w-4 h-4 rounded border-arsa-700 bg-arsa-900 text-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                                <span class="ml-2 text-sm text-gray-400 group-hover:text-white transition-colors">Ingat saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-gold-400 hover:text-gold-300 font-medium transition-colors">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-gold-500 to-gold-600 text-black font-bold py-4 rounded-lg hover:from-gold-600 hover:to-gold-700 focus:outline-none focus:ring-4 focus:ring-gold-500/50 transition-all transform hover:scale-[1.02] shadow-lg shadow-gold-500/20">
                            MASUK
                        </button>

                        <!-- Register Link -->
                        <div class="text-center pt-4 border-t border-arsa-700">
                            <p class="text-gray-400">
                                Belum punya akun? 
                                <a href="{{ route('register') }}" class="text-gold-400 hover:text-gold-300 font-semibold transition-colors">
                                    Daftar sekarang
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
