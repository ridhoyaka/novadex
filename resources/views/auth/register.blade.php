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
                            Bergabung dengan NovaDex
                        </h1>
                        
                        <p class="text-xl text-gray-400 mb-8 leading-relaxed">
                            Daftarkan UMKM Anda dan jangkau lebih banyak pelanggan
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-gold-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold mb-1">Gratis Selamanya</h3>
                                    <p class="text-gray-400 text-sm">Tidak ada biaya pendaftaran atau langganan</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-gold-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold mb-1">Aktif dalam 5 Menit</h3>
                                    <p class="text-gray-400 text-sm">Profil UMKM langsung tayang setelah verifikasi</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-gold-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold mb-1">Data Aman</h3>
                                    <p class="text-gray-400 text-sm">Informasi Anda dilindungi dengan enkripsi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Register Form -->
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
                        <h2 class="text-3xl font-black text-white mb-2" style="font-family: 'Space Grotesk', sans-serif;">Buat Akun Baru</h2>
                        <p class="text-gray-400">Daftarkan UMKM Anda sekarang</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-white mb-2 tracking-wide">NAMA LENGKAP</label>
                            <input id="name" 
                                   type="text" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   required 
                                   autofocus 
                                   autocomplete="name"
                                   class="w-full px-4 py-3.5 bg-arsa-900 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                                   placeholder="Nama Anda">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-white mb-2 tracking-wide">EMAIL</label>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required 
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
                                   autocomplete="new-password"
                                   class="w-full px-4 py-3.5 bg-arsa-900 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                                   placeholder="Minimal 8 karakter">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-white mb-2 tracking-wide">KONFIRMASI PASSWORD</label>
                            <input id="password_confirmation" 
                                   type="password" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password"
                                   class="w-full px-4 py-3.5 bg-arsa-900 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                                   placeholder="Ulangi password">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-gold-500 to-gold-600 text-black font-bold py-4 rounded-lg hover:from-gold-600 hover:to-gold-700 focus:outline-none focus:ring-4 focus:ring-gold-500/50 transition-all transform hover:scale-[1.02] shadow-lg shadow-gold-500/20">
                            DAFTAR SEKARANG
                        </button>

                        <!-- Login Link -->
                        <div class="text-center pt-4 border-t border-arsa-700">
                            <p class="text-gray-400">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-gold-400 hover:text-gold-300 font-semibold transition-colors">
                                    Masuk di sini
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
