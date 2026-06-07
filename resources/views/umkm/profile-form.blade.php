<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $profile ? 'Edit Profil UMKM' : 'Buat Profil UMKM' }}
        </h2>
    </x-slot>

    <div class="py-6 lg:py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-arsa-900 overflow-hidden shadow-xl sm:rounded-lg border border-arsa-800">
                <div class="p-6">
                    <form action="{{ route('umkm.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama Usaha -->
                        <div class="mb-6">
                            <div class="flex items-center gap-2 mb-2">
                                <label class="block text-sm font-medium text-arsa-200">Nama Usaha *</label>
                                <div class="group relative">
                                    <svg class="w-4 h-4 text-arsa-400 hover:text-gold-400 cursor-help transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="absolute left-0 top-6 w-64 p-3 bg-arsa-800 border border-gold-500/30 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
                                        <p class="text-xs text-arsa-200">Nama usaha yang mudah diingat akan membantu pelanggan menemukan Anda dengan lebih mudah.</p>
                                    </div>
                                </div>
                            </div>
                            <input type="text" name="nama_usaha" value="{{ old('nama_usaha', $profile->nama_usaha ?? '') }}" 
                                   placeholder="Contoh: Toko Kue Mawar"
                                   class="w-full rounded-md bg-arsa-800 border-arsa-700 text-white shadow-sm focus:border-gold-500 focus:ring-gold-500" required>
                            @error('nama_usaha')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="mb-6">
                            <div class="flex items-center gap-2 mb-2">
                                <label class="block text-sm font-medium text-arsa-200">Kategori *</label>
                                <div class="group relative">
                                    <svg class="w-4 h-4 text-arsa-400 hover:text-gold-400 cursor-help transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="absolute left-0 top-6 w-64 p-3 bg-arsa-800 border border-gold-500/30 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
                                        <p class="text-xs text-arsa-200">Pilih kategori yang paling sesuai dengan jenis usaha Anda agar pelanggan mudah menemukan.</p>
                                    </div>
                                </div>
                            </div>
                            <select name="kategori_id" class="w-full rounded-md bg-arsa-800 border-arsa-700 text-white shadow-sm focus:border-gold-500 focus:ring-gold-500" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('kategori_id', $profile->kategori_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kecamatan -->
                        <div class="mb-6">
                            <div class="flex items-center gap-2 mb-2">
                                <label class="block text-sm font-medium text-arsa-200">Kecamatan *</label>
                                <div class="group relative">
                                    <svg class="w-4 h-4 text-arsa-400 hover:text-gold-400 cursor-help transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="absolute left-0 top-6 w-64 p-3 bg-arsa-800 border border-gold-500/30 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
                                        <p class="text-xs text-arsa-200">Pilih kecamatan lokasi usaha Anda. Ini membantu pelanggan mencari usaha di area mereka.</p>
                                    </div>
                                </div>
                            </div>
                            <select name="kecamatan_id" class="w-full rounded-md bg-arsa-800 border-arsa-700 text-white shadow-sm focus:border-gold-500 focus:ring-gold-500" required>
                                <option value="">Pilih Kecamatan</option>
                                @foreach($districts as $district)
                                <option value="{{ $district->id }}" {{ old('kecamatan_id', $profile->kecamatan_id ?? '') == $district->id ? 'selected' : '' }}>
                                    {{ $district->nama_kecamatan }}
                                </option>
                                @endforeach
                            </select>
                            @error('kecamatan_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-6">
                            <div class="flex items-center gap-2 mb-2">
                                <label class="block text-sm font-medium text-arsa-200">Deskripsi Usaha *</label>
                                <div class="group relative">
                                    <svg class="w-4 h-4 text-arsa-400 hover:text-gold-400 cursor-help transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="absolute left-0 top-6 w-72 p-3 bg-arsa-800 border border-gold-500/30 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
                                        <p class="text-xs text-arsa-200 mb-2">Ceritakan tentang usaha Anda! Jelaskan produk/jasa yang ditawarkan, keunggulan, dan apa yang membuat usaha Anda spesial.</p>
                                        <p class="text-xs text-gold-400">💡 Minimal 50 karakter agar lebih menarik</p>
                                    </div>
                                </div>
                            </div>
                            <textarea name="deskripsi" rows="5" 
                                      placeholder="Contoh: Kami menyediakan kue tradisional khas Salatiga dengan resep turun-temurun. Semua bahan berkualitas dan dibuat fresh setiap hari..."
                                      class="w-full rounded-md bg-arsa-800 border-arsa-700 text-white shadow-sm focus:border-gold-500 focus:ring-gold-500" 
                                      required>{{ old('deskripsi', $profile->deskripsi ?? '') }}</textarea>
                            <p class="text-xs text-arsa-400 mt-1">Minimal 50 karakter untuk profil yang lebih menarik</p>
                            @error('deskripsi')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- WhatsApp -->
                        <div class="mb-6">
                            <div class="flex items-center gap-2 mb-2">
                                <label class="block text-sm font-medium text-arsa-200">Nomor WhatsApp *</label>
                                <div class="group relative">
                                    <svg class="w-4 h-4 text-arsa-400 hover:text-gold-400 cursor-help transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="absolute left-0 top-6 w-72 p-3 bg-arsa-800 border border-gold-500/30 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
                                        <p class="text-xs text-arsa-200 mb-2">Nomor WhatsApp akan digunakan pelanggan untuk menghubungi Anda langsung. Pastikan nomor aktif dan bisa dihubungi.</p>
                                        <p class="text-xs text-gold-400">🔒 Privasi terjaga - hanya ditampilkan di profil publik Anda</p>
                                    </div>
                                </div>
                            </div>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $profile->whatsapp ?? '') }}" 
                                   placeholder="Contoh: 081234567890"
                                   class="w-full rounded-md bg-arsa-800 border-arsa-700 text-white shadow-sm focus:border-gold-500 focus:ring-gold-500" required>
                            <p class="text-xs text-arsa-400 mt-1">Format: 081234567890 (10-15 digit, tanpa spasi atau tanda hubung)</p>
                            @error('whatsapp')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lokasi Usaha (Optional) -->
                        <div class="mb-6 p-6 bg-arsa-800/50 border border-arsa-700 rounded-lg">
                            <div class="flex items-center gap-2 mb-3">
                                <h3 class="text-lg font-semibold text-white">Lokasi Usaha</h3>
                                <span class="text-xs bg-blue-500/20 text-blue-300 px-2 py-1 rounded">Opsional</span>
                                <div class="group relative">
                                    <svg class="w-5 h-5 text-arsa-400 hover:text-gold-400 cursor-help transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div class="absolute left-0 top-6 w-80 p-3 bg-arsa-800 border border-gold-500/30 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
                                        <p class="text-xs text-arsa-200 mb-2">Tambahkan lokasi usaha agar pelanggan lebih mudah menemukan Anda. Anda bisa menambahkan lokasi dengan dua cara:</p>
                                        <ul class="text-xs text-arsa-200 list-disc list-inside space-y-1">
                                            <li>Ketik alamat dan klik "Cari di Peta"</li>
                                            <li>Klik langsung di peta untuk menandai lokasi</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-sm text-arsa-300 mb-4">
                                Tambahkan lokasi usaha agar pelanggan lebih mudah menemukan Anda (opsional)
                            </p>

                            <!-- Privacy Notice -->
                            <div class="flex items-start gap-2 mb-4 p-3 bg-blue-900/20 border border-blue-500/30 rounded-lg">
                                <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-xs text-blue-300">
                                    <strong>Catatan Privasi:</strong> Lokasi ini akan ditampilkan di peta publik untuk membantu pelanggan menemukan usaha Anda.
                                </p>
                            </div>

                            @if($profile && $profile->latitude && $profile->longitude)
                            <!-- Current Location Display -->
                            <div class="mb-4 p-4 bg-green-900/20 border border-green-500/30 rounded-lg">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <div>
                                            <p class="text-sm text-green-300 font-medium">Lokasi sudah ditambahkan</p>
                                            @if($profile->alamat_lengkap)
                                            <p class="text-xs text-green-400 mt-1">{{ $profile->alamat_lengkap }}</p>
                                            @endif
                                            <p class="text-xs text-arsa-400 mt-1">
                                                Koordinat: {{ number_format($profile->latitude, 6) }}, {{ number_format($profile->longitude, 6) }}
                                            </p>
                                        </div>
                                    </div>
                                    <form action="{{ route('umkm.profile.location.remove') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus lokasi?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 text-xs font-medium transition-colors">
                                            Hapus Lokasi
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endif

                            <!-- Address Input -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-arsa-200 mb-2">Alamat Usaha</label>
                                <div class="flex gap-2">
                                    <input type="text" 
                                           id="address_input" 
                                           value="{{ old('alamat_lengkap', $profile->alamat_lengkap ?? '') }}" 
                                           placeholder="Contoh: Jl. Diponegoro No. 123, Salatiga"
                                           class="flex-1 rounded-md bg-arsa-800 border-arsa-700 text-white shadow-sm focus:border-gold-500 focus:ring-gold-500">
                                    <button type="button" 
                                            onclick="geocodeAddress()" 
                                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors whitespace-nowrap">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                            </svg>
                                            Cari di Peta
                                        </span>
                                    </button>
                                </div>
                                <p class="text-xs text-arsa-400 mt-1">Ketik alamat lengkap dan klik "Cari di Peta" untuk menandai lokasi</p>
                            </div>

                            <!-- Map Container -->
                            <div class="mb-4">
                                <div class="relative">
                                    <div id="location_map" class="w-full h-96 rounded-lg border border-arsa-700 bg-arsa-800"></div>
                                    <!-- Current Location Button -->
                                    <button type="button" 
                                            onclick="getCurrentLocation()" 
                                            id="current_location_btn"
                                            class="absolute top-3 right-3 z-[1000] bg-white hover:bg-gray-100 text-gray-700 p-2 rounded-lg shadow-lg transition-colors"
                                            title="Gunakan lokasi saat ini">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-xs text-arsa-400 mt-2">
                                    💡 Klik pada peta untuk menandai lokasi usaha Anda, atau seret marker untuk menyesuaikan posisi
                                </p>
                            </div>

                            <!-- Hidden inputs for coordinates -->
                            <input type="hidden" id="latitude_input" name="latitude" value="{{ old('latitude', $profile->latitude ?? '') }}">
                            <input type="hidden" id="longitude_input" name="longitude" value="{{ old('longitude', $profile->longitude ?? '') }}">
                            <input type="hidden" id="alamat_lengkap_input" name="alamat_lengkap" value="{{ old('alamat_lengkap', $profile->alamat_lengkap ?? '') }}">

                            <!-- Save Location Button -->
                            @if($profile)
                            <div class="flex gap-2">
                                <button type="button" 
                                        onclick="saveLocation()" 
                                        id="save_location_btn"
                                        class="px-4 py-2 bg-gold-600 hover:bg-gold-700 text-arsa-900 font-semibold rounded-md transition-colors shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                                    Simpan Lokasi
                                </button>
                                <button type="button" 
                                        onclick="clearLocation()" 
                                        class="px-4 py-2 bg-arsa-700 hover:bg-arsa-600 text-arsa-200 font-medium rounded-md transition-colors">
                                    Bersihkan
                                </button>
                            </div>
                            @else
                            <div class="p-3 bg-yellow-900/20 border border-yellow-500/30 rounded-lg">
                                <p class="text-xs text-yellow-300">
                                    💡 Simpan profil terlebih dahulu untuk menambahkan lokasi
                                </p>
                            </div>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-4">
                            <button type="submit" class="bg-gradient-to-r from-gold-500 to-gold-600 text-arsa-900 font-semibold px-6 py-2 rounded-md hover:from-gold-600 hover:to-gold-700 shadow-lg transition-all">
                                Simpan Profil
                            </button>
                            <a href="{{ route('umkm.dashboard') }}" class="bg-arsa-800 text-arsa-200 px-6 py-2 rounded-md hover:bg-arsa-700 border border-arsa-700 transition-all">
                                Batal
                            </a>
                        </div>
                    </form>

                    @if($profile)
                    <!-- Logo Upload -->
                    <div class="mt-8 pt-8 border-t border-arsa-800">
                        <div class="flex items-center gap-2 mb-4">
                            <h3 class="text-lg font-semibold text-white">Logo Usaha</h3>
                            <div class="group relative">
                                <svg class="w-5 h-5 text-arsa-400 hover:text-gold-400 cursor-help transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="absolute left-0 top-6 w-72 p-3 bg-arsa-800 border border-gold-500/30 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
                                    <p class="text-xs text-arsa-200">Logo membantu pelanggan mengenali usaha Anda dengan mudah. Gunakan gambar yang jelas dan mewakili identitas usaha Anda.</p>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('umkm.profile.upload-logo') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="flex items-center gap-4">
                                @if($profile->logo_path)
                                <img src="{{ Storage::url($profile->logo_path) }}" alt="Logo" class="w-24 h-24 object-cover rounded-lg border border-arsa-700">
                                @endif
                                <div class="flex-1">
                                    <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-arsa-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gold-900/20 file:text-gold-400 hover:file:bg-gold-900/30">
                                    <p class="text-xs text-arsa-400 mt-1">Maksimal 2MB • Format: JPG, PNG, atau WebP</p>
                                </div>
                                <button type="submit" class="bg-gold-600 text-arsa-900 font-semibold px-4 py-2 rounded-md hover:bg-gold-700 shadow-lg transition-all">
                                    Upload
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Gallery Photos -->
                    <div class="mt-8 pt-8 border-t border-arsa-800">
                        <div class="flex items-center gap-2 mb-4">
                            <h3 class="text-lg font-semibold text-white">Galeri Foto</h3>
                            <div class="group relative">
                                <svg class="w-5 h-5 text-arsa-400 hover:text-gold-400 cursor-help transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="absolute left-0 top-6 w-72 p-3 bg-arsa-800 border border-gold-500/30 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
                                    <p class="text-xs text-arsa-200 mb-2">Foto pertama akan menjadi foto utama yang ditampilkan di katalog. Tambahkan minimal 1 foto untuk menarik perhatian pelanggan!</p>
                                    <p class="text-xs text-gold-400">💡 Maksimal 3 foto</p>
                                </div>
                            </div>
                        </div>
                        
                        @if($profile->photos && count($profile->photos) > 0)
                        <div id="photo-gallery" class="grid grid-cols-3 gap-4 mb-4">
                            @foreach($profile->photos as $index => $photo)
                            <div class="relative photo-item cursor-move" draggable="true" data-photo="{{ $photo }}" data-index="{{ $index }}">
                                <img src="{{ Storage::url($photo) }}" alt="Gallery" class="w-full h-32 object-cover rounded-lg border border-arsa-700">
                                @if($index === 0)
                                <span class="absolute top-2 left-2 bg-gold-600 text-arsa-900 text-xs font-semibold px-2 py-1 rounded">Foto Utama</span>
                                @endif
                                <!-- Drag handle -->
                                <div class="absolute top-2 left-2 bg-arsa-900/80 p-1 rounded cursor-move" title="Seret untuk mengubah urutan">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                                    </svg>
                                </div>
                                <form action="{{ route('umkm.profile.delete-photo') }}" method="POST" class="absolute top-2 right-2">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="photo_path" value="{{ $photo }}">
                                    <button type="submit" class="bg-red-500 text-white p-1 rounded-full hover:bg-red-600 shadow-lg" title="Hapus foto" onclick="return confirm('Yakin ingin menghapus foto ini?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-arsa-400 mb-4">💡 Seret foto untuk mengubah urutan. Foto pertama akan menjadi foto utama.</p>

                        <script>
                            // Photo reordering with drag and drop
                            const gallery = document.getElementById('photo-gallery');
                            let draggedElement = null;

                            if (gallery) {
                                const photoItems = gallery.querySelectorAll('.photo-item');
                                
                                photoItems.forEach(item => {
                                    item.addEventListener('dragstart', handleDragStart);
                                    item.addEventListener('dragover', handleDragOver);
                                    item.addEventListener('drop', handleDrop);
                                    item.addEventListener('dragend', handleDragEnd);
                                });
                            }

                            function handleDragStart(e) {
                                draggedElement = this;
                                this.style.opacity = '0.4';
                                e.dataTransfer.effectAllowed = 'move';
                            }

                            function handleDragOver(e) {
                                if (e.preventDefault) {
                                    e.preventDefault();
                                }
                                e.dataTransfer.dropEffect = 'move';
                                
                                // Add visual feedback
                                if (this !== draggedElement) {
                                    this.style.borderColor = '#D4AF37';
                                }
                                
                                return false;
                            }

                            function handleDrop(e) {
                                if (e.stopPropagation) {
                                    e.stopPropagation();
                                }

                                if (draggedElement !== this) {
                                    // Get all items
                                    const items = Array.from(gallery.querySelectorAll('.photo-item'));
                                    const draggedIndex = items.indexOf(draggedElement);
                                    const targetIndex = items.indexOf(this);

                                    // Reorder in DOM
                                    if (draggedIndex < targetIndex) {
                                        this.parentNode.insertBefore(draggedElement, this.nextSibling);
                                    } else {
                                        this.parentNode.insertBefore(draggedElement, this);
                                    }

                                    // Update primary photo badge
                                    updatePrimaryBadge();

                                    // Save new order to server
                                    savePhotoOrder();
                                }

                                return false;
                            }

                            function handleDragEnd(e) {
                                this.style.opacity = '1';
                                
                                // Remove all border highlights
                                gallery.querySelectorAll('.photo-item').forEach(item => {
                                    item.style.borderColor = '';
                                });
                            }

                            function updatePrimaryBadge() {
                                // Remove all primary badges
                                gallery.querySelectorAll('.photo-item span').forEach(badge => {
                                    if (badge.textContent === 'Foto Utama') {
                                        badge.remove();
                                    }
                                });

                                // Add primary badge to first photo
                                const firstPhoto = gallery.querySelector('.photo-item');
                                if (firstPhoto) {
                                    const badge = document.createElement('span');
                                    badge.className = 'absolute top-2 left-2 bg-gold-600 text-arsa-900 text-xs font-semibold px-2 py-1 rounded';
                                    badge.textContent = 'Foto Utama';
                                    firstPhoto.appendChild(badge);
                                }
                            }

                            function savePhotoOrder() {
                                const items = gallery.querySelectorAll('.photo-item');
                                const photos = Array.from(items).map(item => item.dataset.photo);

                                // Send AJAX request to save order
                                fetch('{{ route('umkm.profile.reorder-photos') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify({ photos: photos })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Show success notification
                                        showNotification('✓ Urutan foto berhasil diperbarui!', 'success');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    showNotification('Gagal menyimpan urutan foto', 'error');
                                });
                            }
                        </script>
                        @else
                        <div class="bg-arsa-800/50 border border-arsa-700 rounded-lg p-6 mb-4 text-center">
                            <p class="text-arsa-400 text-sm mb-2">📸 Belum ada foto</p>
                            <p class="text-arsa-500 text-xs">Tambahkan foto produk atau suasana usaha Anda untuk menarik lebih banyak pelanggan</p>
                        </div>
                        @endif

                        @if(!$profile->photos || count($profile->photos) < 3)
                        <form action="{{ route('umkm.profile.upload-photo') }}" method="POST" enctype="multipart/form-data" id="photo-upload-form">
                            @csrf
                            <!-- Drag and Drop Zone -->
                            <div id="drop-zone" class="border-2 border-dashed border-arsa-700 rounded-lg p-6 mb-4 text-center hover:border-gold-500 transition-colors cursor-pointer">
                                <svg class="w-12 h-12 text-arsa-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-arsa-300 text-sm mb-1">Seret & lepas foto di sini</p>
                                <p class="text-arsa-500 text-xs mb-3">atau</p>
                                <label for="photo-input" class="inline-block bg-gold-900/20 text-gold-400 px-4 py-2 rounded-md hover:bg-gold-900/30 cursor-pointer transition-colors">
                                    Pilih Foto
                                </label>
                                <input type="file" id="photo-input" name="photo" accept="image/*" class="hidden">
                                <p class="text-xs text-arsa-400 mt-3">Maksimal 2MB • Format: JPG, PNG, atau WebP</p>
                            </div>

                            <!-- Photo Preview -->
                            <div id="photo-preview" class="hidden mb-4">
                                <div class="bg-arsa-800 rounded-lg p-4 border border-arsa-700">
                                    <div class="flex items-center gap-4">
                                        <img id="preview-image" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg">
                                        <div class="flex-1">
                                            <p class="text-white font-medium mb-1" id="preview-filename"></p>
                                            <p class="text-arsa-400 text-sm" id="preview-filesize"></p>
                                            <button type="button" onclick="clearPhotoPreview()" class="text-red-400 hover:text-red-300 text-sm mt-2 transition-colors">
                                                ✕ Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" id="upload-btn" class="bg-gold-600 text-arsa-900 font-semibold px-6 py-2 rounded-md hover:bg-gold-700 shadow-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                    Tambah Foto
                                </button>
                            </div>
                            <p class="text-xs text-arsa-400 mt-2">
                                @if($profile->photos && count($profile->photos) > 0)
                                    💡 Anda bisa menambahkan {{ 3 - count($profile->photos) }} foto lagi
                                @else
                                    💡 Foto pertama akan menjadi foto utama di katalog • Minimal 1 foto dianjurkan
                                @endif
                            </p>
                        </form>

                        <script>
                            // Photo upload with drag-and-drop and preview
                            const dropZone = document.getElementById('drop-zone');
                            const photoInput = document.getElementById('photo-input');
                            const photoPreview = document.getElementById('photo-preview');
                            const previewImage = document.getElementById('preview-image');
                            const previewFilename = document.getElementById('preview-filename');
                            const previewFilesize = document.getElementById('preview-filesize');
                            const uploadBtn = document.getElementById('upload-btn');

                            // Prevent default drag behaviors
                            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                                dropZone.addEventListener(eventName, preventDefaults, false);
                                document.body.addEventListener(eventName, preventDefaults, false);
                            });

                            function preventDefaults(e) {
                                e.preventDefault();
                                e.stopPropagation();
                            }

                            // Highlight drop zone when item is dragged over it
                            ['dragenter', 'dragover'].forEach(eventName => {
                                dropZone.addEventListener(eventName, () => {
                                    dropZone.classList.add('border-gold-500', 'bg-gold-900/10');
                                }, false);
                            });

                            ['dragleave', 'drop'].forEach(eventName => {
                                dropZone.addEventListener(eventName, () => {
                                    dropZone.classList.remove('border-gold-500', 'bg-gold-900/10');
                                }, false);
                            });

                            // Handle dropped files
                            dropZone.addEventListener('drop', (e) => {
                                const dt = e.dataTransfer;
                                const files = dt.files;
                                
                                if (files.length > 0) {
                                    photoInput.files = files;
                                    handleFileSelect(files[0]);
                                }
                            }, false);

                            // Handle file input change
                            photoInput.addEventListener('change', (e) => {
                                if (e.target.files.length > 0) {
                                    handleFileSelect(e.target.files[0]);
                                }
                            });

                            // Click on drop zone to open file picker
                            dropZone.addEventListener('click', (e) => {
                                if (e.target.id !== 'photo-input' && !e.target.closest('label')) {
                                    photoInput.click();
                                }
                            });

                            function handleFileSelect(file) {
                                // Validate file type
                                if (!file.type.match('image.*')) {
                                    alert('Hanya file gambar yang diperbolehkan!');
                                    return;
                                }

                                // Validate file size (2MB)
                                if (file.size > 2 * 1024 * 1024) {
                                    alert('Ukuran file maksimal 2MB!');
                                    return;
                                }

                                // Show preview
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    previewImage.src = e.target.result;
                                    previewFilename.textContent = file.name;
                                    previewFilesize.textContent = formatFileSize(file.size);
                                    photoPreview.classList.remove('hidden');
                                    dropZone.classList.add('hidden');
                                    uploadBtn.disabled = false;
                                };
                                reader.readAsDataURL(file);
                            }

                            function clearPhotoPreview() {
                                photoInput.value = '';
                                photoPreview.classList.add('hidden');
                                dropZone.classList.remove('hidden');
                                uploadBtn.disabled = true;
                            }

                            function formatFileSize(bytes) {
                                if (bytes === 0) return '0 Bytes';
                                const k = 1024;
                                const sizes = ['Bytes', 'KB', 'MB'];
                                const i = Math.floor(Math.log(bytes) / Math.log(k));
                                return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
                            }

                            // Disable upload button initially
                            uploadBtn.disabled = true;
                        </script>
                        @else
                        <div class="bg-green-900/20 border border-green-500/30 rounded-lg p-4 text-center">
                            <p class="text-green-300 text-sm">✨ Galeri foto Anda sudah lengkap (3/3)</p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS -->
  

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>

    <script>
        let map;
        let marker;
        const defaultLat = {{ $profile && $profile->latitude ? $profile->latitude : '-7.5616' }};
        const defaultLng = {{ $profile && $profile->longitude ? $profile->longitude : '110.5084' }};

        // Notification helper function
        function showNotification(message, type = 'info') {
            // Remove existing notifications
            const existing = document.getElementById('geocoding-notification');
            if (existing) {
                existing.remove();
            }

            // Create notification element
            const notification = document.createElement('div');
            notification.id = 'geocoding-notification';
            notification.className = 'fixed top-4 right-4 z-[9999] max-w-md p-4 rounded-lg shadow-xl border transition-all transform translate-x-0';
            
            // Set colors based on type
            let bgColor, borderColor, iconSvg;
            switch(type) {
                case 'success':
                    bgColor = 'bg-green-900/90';
                    borderColor = 'border-green-500/50';
                    iconSvg = '<svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                    break;
                case 'error':
                    bgColor = 'bg-red-900/90';
                    borderColor = 'border-red-500/50';
                    iconSvg = '<svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                    break;
                case 'warning':
                    bgColor = 'bg-yellow-900/90';
                    borderColor = 'border-yellow-500/50';
                    iconSvg = '<svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
                    break;
                default:
                    bgColor = 'bg-blue-900/90';
                    borderColor = 'border-blue-500/50';
                    iconSvg = '<svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            }
            
            notification.className += ` ${bgColor} ${borderColor}`;
            notification.innerHTML = `
                <div class="flex items-start gap-3">
                    ${iconSvg}
                    <p class="text-sm text-white flex-1">${message}</p>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.style.transform = 'translateX(400px)';
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 300);
                }
            }, 5000);
        }

        // Initialize map when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
        });

        function initMap() {
            // Initialize the map centered on Salatiga or existing location
            map = L.map('location_map').setView([defaultLat, defaultLng], 13);

            // Add OpenStreetMap tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(map);

            // Add marker if location exists
            @if($profile && $profile->latitude && $profile->longitude)
            marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            // Update coordinates when marker is dragged
            marker.on('dragend', function(e) {
                const position = marker.getLatLng();
                updateCoordinates(position.lat, position.lng);
            });
            @endif

            // Add click event to map to place/move marker
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;
                
                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng], {
                        draggable: true
                    }).addTo(map);

                    // Update coordinates when marker is dragged
                    marker.on('dragend', function(e) {
                        const position = marker.getLatLng();
                        updateCoordinates(position.lat, position.lng);
                    });
                }
                
                updateCoordinates(lat, lng);
            });
        }

        function updateCoordinates(lat, lng) {
            document.getElementById('latitude_input').value = lat.toFixed(6);
            document.getElementById('longitude_input').value = lng.toFixed(6);
            
            // Enable save button if profile exists
            @if($profile)
            document.getElementById('save_location_btn').disabled = false;
            @endif
        }

        async function geocodeAddress() {
            const address = document.getElementById('address_input').value;
            
            if (!address) {
                showNotification('Silakan masukkan alamat terlebih dahulu', 'warning');
                return;
            }

            // Show loading state
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<span class="flex items-center gap-2"><svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Mencari...</span>';

            // Add loading overlay to map
            const mapElement = document.getElementById('location_map');
            const loadingOverlay = document.createElement('div');
            loadingOverlay.id = 'map-loading';
            loadingOverlay.className = 'absolute inset-0 bg-arsa-900/80 flex items-center justify-center z-[1000] rounded-lg';
            loadingOverlay.innerHTML = '<div class="text-center"><svg class="animate-spin h-8 w-8 text-gold-400 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><p class="text-arsa-200 text-sm">Mencari lokasi...</p></div>';
            mapElement.parentElement.style.position = 'relative';
            mapElement.parentElement.appendChild(loadingOverlay);

            try {
                // Use our backend API endpoint with caching
                const response = await fetch('{{ route('umkm.profile.geocode') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ address: address })
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    const lat = result.data.latitude;
                    const lng = result.data.longitude;
                    const displayName = result.data.display_name;
                    
                    // Update map and marker with smooth animation
                    map.flyTo([lat, lng], 16, {
                        duration: 1.5
                    });
                    
                    if (marker) {
                        marker.setLatLng([lat, lng]);
                    } else {
                        marker = L.marker([lat, lng], {
                            draggable: true
                        }).addTo(map);

                        marker.on('dragend', function(e) {
                            const position = marker.getLatLng();
                            updateCoordinates(position.lat, position.lng);
                        });
                    }
                    
                    updateCoordinates(lat, lng);
                    document.getElementById('alamat_lengkap_input').value = address;
                    
                    showNotification('✓ Lokasi berhasil ditemukan! Anda bisa menyesuaikan posisi marker dengan menggesernya.', 'success');
                } else {
                    // Handle error response
                    const message = result.message || 'Alamat tidak ditemukan. Silakan coba dengan alamat yang lebih spesifik atau klik langsung di peta.';
                    showNotification(message, 'error');
                }
            } catch (error) {
                console.error('Geocoding error:', error);
                
                // Provide specific error messages
                let errorMessage = 'Terjadi kesalahan saat mencari lokasi. ';
                if (error.message.includes('Failed to fetch')) {
                    errorMessage += 'Periksa koneksi internet Anda.';
                } else {
                    errorMessage += 'Silakan coba lagi atau klik langsung di peta.';
                }
                
                showNotification(errorMessage, 'error');
            } finally {
                // Restore button state
                button.disabled = false;
                button.innerHTML = originalText;
                
                // Remove loading overlay
                const overlay = document.getElementById('map-loading');
                if (overlay) {
                    overlay.remove();
                }
            }
        }

        function saveLocation() {
            const latitude = document.getElementById('latitude_input').value;
            const longitude = document.getElementById('longitude_input').value;
            const address = document.getElementById('address_input').value;

            if (!latitude || !longitude) {
                showNotification('Silakan tandai lokasi di peta terlebih dahulu', 'warning');
                return;
            }

            // Validate coordinates
            const lat = parseFloat(latitude);
            const lng = parseFloat(longitude);
            
            if (isNaN(lat) || isNaN(lng) || lat < -90 || lat > 90 || lng < -180 || lng > 180) {
                showNotification('Koordinat tidak valid. Silakan tandai lokasi di peta.', 'error');
                return;
            }

            // Show loading state
            const button = document.getElementById('save_location_btn');
            const originalText = button.textContent;
            button.disabled = true;
            button.innerHTML = '<span class="flex items-center gap-2"><svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menyimpan...</span>';

            // Create form data
            const formData = new FormData();
            formData.append('latitude', latitude);
            formData.append('longitude', longitude);
            formData.append('alamat_lengkap', address);

            // Send AJAX request
            fetch('{{ route('umkm.profile.location.update') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                showNotification('✓ Lokasi berhasil disimpan!', 'success');
                // Reload after a short delay to show the success message
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            })
            .catch(error => {
                console.error('Error:', error);
                
                let errorMessage = 'Terjadi kesalahan saat menyimpan lokasi. ';
                if (error.message.includes('Failed to fetch')) {
                    errorMessage += 'Periksa koneksi internet Anda.';
                } else if (error.message.includes('419')) {
                    errorMessage += 'Sesi Anda telah berakhir. Silakan refresh halaman.';
                } else {
                    errorMessage += 'Silakan coba lagi.';
                }
                
                showNotification(errorMessage, 'error');
                button.disabled = false;
                button.innerHTML = originalText;
            });
        }

        function clearLocation() {
            if (!confirm('Yakin ingin membersihkan lokasi yang sudah ditandai?')) {
                return;
            }
            
            // Clear inputs
            document.getElementById('address_input').value = '';
            document.getElementById('latitude_input').value = '';
            document.getElementById('longitude_input').value = '';
            document.getElementById('alamat_lengkap_input').value = '';
            
            // Remove marker
            if (marker) {
                map.removeLayer(marker);
                marker = null;
            }
            
            // Reset map view to Salatiga center with smooth animation
            map.flyTo([-7.5616, 110.5084], 13, {
                duration: 1.5
            });
            
            // Disable save button
            @if($profile)
            document.getElementById('save_location_btn').disabled = true;
            @endif
            
            showNotification('Lokasi berhasil dibersihkan', 'info');
        }

        function getCurrentLocation() {
            if (!navigator.geolocation) {
                showNotification('Browser Anda tidak mendukung fitur lokasi', 'error');
                return;
            }

            const button = document.getElementById('current_location_btn');
            const originalHTML = button.innerHTML;
            
            // Show loading state
            button.disabled = true;
            button.innerHTML = '<svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    // Check if location is within Salatiga bounds
                    if (lat < -8 || lat > -7 || lng < 110 || lng > 111) {
                        showNotification('Lokasi Anda di luar area Salatiga. Silakan tandai lokasi usaha secara manual.', 'warning');
                        button.disabled = false;
                        button.innerHTML = originalHTML;
                        return;
                    }
                    
                    // Update map and marker
                    map.flyTo([lat, lng], 16, {
                        duration: 1.5
                    });
                    
                    if (marker) {
                        marker.setLatLng([lat, lng]);
                    } else {
                        marker = L.marker([lat, lng], {
                            draggable: true
                        }).addTo(map);

                        marker.on('dragend', function(e) {
                            const position = marker.getLatLng();
                            updateCoordinates(position.lat, position.lng);
                        });
                    }
                    
                    updateCoordinates(lat, lng);
                    showNotification('✓ Lokasi saat ini berhasil ditandai! Anda bisa menyesuaikan posisi marker.', 'success');
                    
                    button.disabled = false;
                    button.innerHTML = originalHTML;
                },
                function(error) {
                    let errorMessage = 'Tidak dapat mengakses lokasi Anda. ';
                    
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage += 'Izinkan akses lokasi di browser Anda.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage += 'Informasi lokasi tidak tersedia.';
                            break;
                        case error.TIMEOUT:
                            errorMessage += 'Permintaan lokasi timeout.';
                            break;
                        default:
                            errorMessage += 'Silakan tandai lokasi secara manual di peta.';
                    }
                    
                    showNotification(errorMessage, 'error');
                    button.disabled = false;
                    button.innerHTML = originalHTML;
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        }
    </script>

</x-app-layout>
