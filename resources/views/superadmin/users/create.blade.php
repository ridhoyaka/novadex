<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-xl text-white leading-tight" style="font-family: 'Space Grotesk', sans-serif;">
                Tambah User Baru
            </h2>
            <a href="{{ route('superadmin.users.index') }}" class="text-gold-400 hover:text-gold-300 text-sm font-semibold">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6 lg:py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 sm:p-6 lg:p-8">
                <form method="POST" action="{{ route('superadmin.users.store') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-white mb-2">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                               class="w-full px-4 py-3 bg-arsa-800 border border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                               placeholder="Masukkan nama lengkap">
                        @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-white mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                               class="w-full px-4 py-3 bg-arsa-800 border border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                               placeholder="email@example.com">
                        @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-white mb-2">Password</label>
                        <input type="password" id="password" name="password" required 
                               class="w-full px-4 py-3 bg-arsa-800 border border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                               placeholder="Minimal 8 karakter">
                        @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-bold text-white mb-2">Role</label>
                        <select id="role" name="role" required 
                                class="w-full px-4 py-3 bg-arsa-800 border border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                            <option value="">Pilih Role</option>
                            <option value="umkm" {{ old('role') == 'umkm' ? 'selected' : '' }}>UMKM</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        </select>
                        @error('role')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-gold-500 to-gold-600 rounded-lg font-bold text-sm text-black hover:from-gold-600 hover:to-gold-700 transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan User
                        </button>
                        <a href="{{ route('superadmin.users.index') }}" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-arsa-800 border border-arsa-700 rounded-lg font-bold text-sm text-gray-300 hover:text-white hover:border-gold-500/50 transition-all text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
