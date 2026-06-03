<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight" style="font-family: 'Space Grotesk', sans-serif;">
                Tambah UMKM (Pendaftaran Offline)
            </h2>
            <a href="{{ route('admin.umkm.index') }}" class="text-gold-400 hover:text-gold-300 text-sm font-semibold">
                ← Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-gold-900/20 border border-gold-500 text-gold-300 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 bg-red-900/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-4 bg-red-900/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg">
                <p class="font-semibold mb-2">Terdapat kesalahan:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.umkm.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Info Notice -->
                <div class="bg-blue-500/10 border border-blue-500/30 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-blue-300 text-sm font-semibold mb-1">Pendaftaran Offline</p>
                            <p class="text-blue-200 text-xs">Form ini untuk mendaftarkan UMKM yang mendaftar secara offline. Akun user akan dibuat otomatis dan email akan terverifikasi.</p>
                        </div>
                    </div>
                </div>

                <!-- User Account Section -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4" style="font-family: 'Space Grotesk', sans-serif;">Data Akun User</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-white mb-2 tracking-wide">NAMA PEMILIK *</label>
                            <input type="text" 
                                   name="user_name" 
                                   value="{{ old('user_name') }}"
                                   required
                                   class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                                   placeholder="Nama lengkap pemilik">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-white mb-2 tracking-wide">EMAIL USER *</label>
                            <input type="email" 
                                   name="user_email" 
                                   value="{{ old('user_email') }}"
                                   required
                                   class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                                   placeholder="email@example.com">
                            <p class="text-gray-400 text-xs mt-1">Email untuk login ke sistem</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-white mb-2 tracking-wide">PASSWORD *</label>
                            <input type="password" 
                                   name="user_password" 
                                   required
                                   minlength="8"
                                   class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                                   placeholder="Minimal 8 karakter">
                            <p class="text-gray-400 text-xs mt-1">Password untuk login (minimal 8 karakter)</p>
                        </div>
                    </div>
                </div>

                <!-- UMKM Profile Section -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4" style="font-family: 'Space Grotesk', sans-serif;">Data UMKM</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-white mb-2 tracking-wide">NAMA USAHA *</label>
                            <input type="text" 
                                   name="nama_usaha" 
                                   value="{{ old('nama_usaha') }}"
                                   required
                                   class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                                   placeholder="Nama usaha">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-white mb-2 tracking-wide">KATEGORI *</label>
                                <select name="kategori_id" 
                                        required
                                        class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('kategori_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama_kategori }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-white mb-2 tracking-wide">KECAMATAN *</label>
                                <select name="kecamatan_id" 
                                        required
                                        class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                                    <option value="">Pilih Kecamatan</option>
                                    @foreach($districts as $district)
                                    <option value="{{ $district->id }}" {{ old('kecamatan_id') == $district->id ? 'selected' : '' }}>
                                        {{ $district->nama_kecamatan }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-white mb-2 tracking-wide">DESKRIPSI USAHA *</label>
                            <textarea name="deskripsi" 
                                      rows="5"
                                      required
                                      minlength="50"
                                      class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                                      placeholder="Ceritakan tentang usaha Anda (minimal 50 karakter)">{{ old('deskripsi') }}</textarea>
                            <p class="text-gray-400 text-xs mt-1">Minimal 50 karakter</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-white mb-2 tracking-wide">WHATSAPP *</label>
                                <input type="text" 
                                       name="whatsapp" 
                                       value="{{ old('whatsapp') }}"
                                       required
                                       class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                                       placeholder="08123456789">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-white mb-2 tracking-wide">EMAIL USAHA</label>
                                <input type="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                                       placeholder="usaha@example.com">
                                <p class="text-gray-400 text-xs mt-1">Opsional</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-white mb-2 tracking-wide">ALAMAT LENGKAP</label>
                            <textarea name="alamat_lengkap" 
                                      rows="3"
                                      class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                                      placeholder="Alamat lengkap usaha">{{ old('alamat_lengkap') }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-white mb-2 tracking-wide">LATITUDE</label>
                                <input type="number" 
                                       name="latitude" 
                                       value="{{ old('latitude') }}"
                                       step="0.00000001"
                                       min="-90"
                                       max="90"
                                       class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                                       placeholder="-7.123456">
                                <p class="text-gray-400 text-xs mt-1">Opsional</p>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-white mb-2 tracking-wide">LONGITUDE</label>
                                <input type="number" 
                                       name="longitude" 
                                       value="{{ old('longitude') }}"
                                       step="0.00000001"
                                       min="-180"
                                       max="180"
                                       class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                                       placeholder="110.123456">
                                <p class="text-gray-400 text-xs mt-1">Opsional</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-white mb-2 tracking-wide">LOGO USAHA</label>
                            <input type="file" 
                                   name="logo" 
                                   accept="image/*"
                                   class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gold-500 file:text-black file:font-semibold hover:file:bg-gold-600 transition-all">
                            <p class="text-gray-400 text-xs mt-1">Maksimal 2MB, format: JPG, PNG, GIF</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <input type="checkbox" 
                                   name="is_published" 
                                   id="is_published"
                                   {{ old('is_published') ? 'checked' : '' }}
                                   class="w-5 h-5 bg-arsa-800 border-2 border-arsa-700 rounded text-gold-500 focus:ring-2 focus:ring-gold-500/20">
                            <label for="is_published" class="text-white font-semibold">Publikasikan profil sekarang</label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-3">
                    <button type="submit" 
                            class="bg-gradient-to-r from-gold-500 to-gold-600 text-black font-bold px-8 py-4 rounded-lg hover:from-gold-600 hover:to-gold-700 transition-all">
                        SIMPAN UMKM
                    </button>
                    <a href="{{ route('admin.umkm.index') }}" 
                       class="bg-arsa-800 text-white font-bold px-8 py-4 rounded-lg border-2 border-arsa-700 hover:border-gold-500 transition-all">
                        BATAL
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
