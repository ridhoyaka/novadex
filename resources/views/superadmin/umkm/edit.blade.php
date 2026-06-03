<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-xl text-white leading-tight" style="font-family: 'Space Grotesk', sans-serif;">
                Edit UMKM: {{ $umkm->nama_usaha }}
            </h2>
            <a href="{{ route('superadmin.umkm.show', $umkm) }}" class="text-gold-400 hover:text-gold-300 text-sm font-semibold">
                ← Kembali ke Detail
            </a>
        </div>
    </x-slot>

    <div class="py-6 lg:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Flash Messages -->
            @if(session('error'))
            <div class="mb-6 bg-red-500/10 border border-red-500/30 rounded-lg p-4">
                <p class="text-red-300 text-sm font-semibold">{{ session('error') }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('superadmin.umkm.update', $umkm) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Info -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 sm:p-6 lg:p-8">
                    <h3 class="text-lg font-bold text-white mb-6">Informasi Dasar</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-bold text-white mb-2">Nama Usaha</label>
                            <input type="text" name="nama_usaha" value="{{ old('nama_usaha', $umkm->nama_usaha) }}" required
                                   class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                            @error('nama_usaha')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-white mb-2">Kategori</label>
                            <select name="kategori_id" required
                                    class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('kategori_id', $umkm->kategori_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-white mb-2">Kecamatan</label>
                            <select name="kecamatan_id" required
                                    class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                                @foreach($districts as $district)
                                <option value="{{ $district->id }}" {{ old('kecamatan_id', $umkm->kecamatan_id) == $district->id ? 'selected' : '' }}>
                                    {{ $district->nama_kecamatan }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-bold text-white mb-2">Deskripsi</label>
                            <textarea name="deskripsi" rows="5" required
                                      class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all resize-y">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
                            @error('deskripsi')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 sm:p-6 lg:p-8">
                    <h3 class="text-lg font-bold text-white mb-6">Kontak & Alamat</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label class="block text-sm font-bold text-white mb-2">WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $umkm->whatsapp) }}" required
                                   class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-white mb-2">Email (opsional)</label>
                            <input type="email" name="email" value="{{ old('email', $umkm->email) }}"
                                   class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-bold text-white mb-2">Alamat Lengkap (opsional)</label>
                            <input type="text" name="alamat_lengkap" value="{{ old('alamat_lengkap', $umkm->alamat_lengkap) }}"
                                   class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 sm:p-6 lg:p-8">
                    <h3 class="text-lg font-bold text-white mb-6">Status Publikasi</h3>
                    
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" {{ $umkm->is_published ? 'checked' : '' }}
                               class="w-5 h-5 rounded border-arsa-700 bg-arsa-800 text-gold-500 focus:ring-gold-500/20">
                        <span class="text-white font-medium">Publikasikan UMKM ini (tampil di katalog publik)</span>
                    </label>
                </div>

                <!-- Submit -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="bg-gradient-to-r from-gold-500 to-gold-600 text-black font-bold px-8 py-3 rounded-lg hover:from-gold-600 hover:to-gold-700 transition-all">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('superadmin.umkm.show', $umkm) }}" class="bg-arsa-800 text-white font-bold px-8 py-3 rounded-lg border-2 border-arsa-700 hover:border-gold-500 transition-all text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
