<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight" style="font-family: 'Space Grotesk', sans-serif;">
                Detail UMKM
            </h2>
            <a href="{{ route('admin.umkm.index') }}" class="text-gold-400 hover:text-gold-300 text-sm font-semibold">
                ← Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Main Info -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-8">
                <div class="flex items-start gap-8">
                    <!-- Logo -->
                    <div class="w-32 h-32 bg-arsa-800 rounded-xl flex items-center justify-center flex-shrink-0 border-2 border-arsa-700">
                        @if($umkm->logo_path)
                        <img src="{{ Storage::url($umkm->logo_path) }}" alt="{{ $umkm->nama_usaha }}" class="w-full h-full object-cover rounded-xl">
                        @else
                        <span class="text-6xl">🏪</span>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="flex-1">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h1 class="text-3xl font-black text-white mb-2" style="font-family: 'Space Grotesk', sans-serif;">
                                    {{ $umkm->nama_usaha }}
                                </h1>
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 bg-gold-500/10 text-gold-400 rounded-full text-sm font-semibold">
                                        {{ $umkm->category->nama_kategori }}
                                    </span>
                                    @if($umkm->is_published)
                                    <span class="px-3 py-1 bg-green-500/10 text-green-400 rounded-full text-sm font-semibold">AKTIF</span>
                                    @else
                                    <span class="px-3 py-1 bg-red-500/10 text-red-400 rounded-full text-sm font-semibold">NONAKTIF</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-gray-400 text-sm mb-1">Pemilik</p>
                                <p class="text-white font-semibold">{{ $umkm->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm mb-1">Kecamatan</p>
                                <p class="text-white font-semibold">{{ $umkm->district->nama_kecamatan }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm mb-1">Slug</p>
                                <p class="text-white font-semibold">{{ $umkm->slug }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm mb-1">Terdaftar</p>
                                <p class="text-white font-semibold">{{ $umkm->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Privacy Notice -->
                        <div class="bg-blue-500/10 border border-blue-500/30 rounded-lg p-4 mb-6">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <div>
                                    <p class="text-blue-300 text-sm font-semibold mb-1">Data Kontak Dilindungi</p>
                                    <p class="text-blue-200 text-xs">Nomor WhatsApp dan email pemilik tidak ditampilkan untuk menjaga privasi. Gunakan halaman publik untuk kontak.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3">
                            <a href="{{ route('umkm.show', $umkm->slug) }}" target="_blank" 
                               class="bg-gradient-to-r from-gold-500 to-gold-600 text-black font-bold px-6 py-3 rounded-lg hover:from-gold-600 hover:to-gold-700 transition-all">
                                Lihat Halaman Publik
                            </a>
                            
                            <!-- Moderate Publish (Content Moderation Only) -->
                            <form action="{{ route('admin.umkm.moderate-publish', $umkm) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="action" value="{{ $umkm->is_published ? 'unpublish' : 'publish' }}">
                                @if(!$umkm->is_published)
                                    <button type="submit" 
                                            class="bg-arsa-800 text-green-400 font-bold px-6 py-3 rounded-lg border-2 border-green-500 hover:bg-green-500/10 transition-all">
                                        Aktifkan Profil
                                    </button>
                                @else
                                    <button type="button" 
                                            onclick="showUnpublishModal()"
                                            class="bg-arsa-800 text-red-400 font-bold px-6 py-3 rounded-lg border-2 border-red-500 hover:bg-red-500/10 transition-all">
                                        Nonaktifkan Profil
                                    </button>
                                @endif
                            </form>
                            
                            <!-- Note: Admin cannot delete UMKM profiles - only UMKM owners can -->
                        </div>
                        
                        <!-- Unpublish Modal (for reason input) -->
                        @if($umkm->is_published)
                        <div id="unpublishModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
                            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-8 max-w-md w-full mx-4">
                                <h3 class="text-xl font-bold text-white mb-4">Nonaktifkan Profil UMKM</h3>
                                <p class="text-gray-300 mb-4">Berikan alasan untuk menonaktifkan profil ini. UMKM akan menerima notifikasi.</p>
                                
                                <form action="{{ route('admin.umkm.moderate-publish', $umkm) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="unpublish">
                                    
                                    <div class="mb-4">
                                        <label class="block text-gray-300 text-sm font-semibold mb-2">Alasan Moderasi</label>
                                        <textarea name="reason" 
                                                  rows="4" 
                                                  required
                                                  class="w-full bg-arsa-800 border border-arsa-700 rounded-lg px-4 py-3 text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20"
                                                  placeholder="Contoh: Konten tidak sesuai, informasi tidak lengkap, dll."></textarea>
                                    </div>
                                    
                                    <div class="flex gap-3">
                                        <button type="submit" 
                                                class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold px-6 py-3 rounded-lg transition-all">
                                            Nonaktifkan
                                        </button>
                                        <button type="button" 
                                                onclick="hideUnpublishModal()"
                                                class="flex-1 bg-arsa-800 text-white font-bold px-6 py-3 rounded-lg border-2 border-arsa-700 hover:border-gold-500 transition-all">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <script>
                            function showUnpublishModal() {
                                document.getElementById('unpublishModal').classList.remove('hidden');
                            }
                            function hideUnpublishModal() {
                                document.getElementById('unpublishModal').classList.add('hidden');
                            }
                        </script>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-8">
                <h3 class="text-xl font-bold text-white mb-4" style="font-family: 'Space Grotesk', sans-serif;">Deskripsi Usaha</h3>
                <p class="text-gray-300 leading-relaxed">{{ $umkm->deskripsi }}</p>
            </div>

            <!-- Gallery -->
            @if($umkm->photos && count($umkm->photos) > 0)
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-8">
                <h3 class="text-xl font-bold text-white mb-4" style="font-family: 'Space Grotesk', sans-serif;">Galeri Foto</h3>
                <div class="grid grid-cols-3 gap-4">
                    @foreach($umkm->photos as $photo)
                    <div class="aspect-video bg-arsa-800 rounded-lg overflow-hidden">
                        <img src="{{ Storage::url($photo) }}" alt="Gallery" class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Location -->
            @if($umkm->latitude && $umkm->longitude)
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-8">
                <h3 class="text-xl font-bold text-white mb-4" style="font-family: 'Space Grotesk', sans-serif;">Lokasi</h3>
                <p class="text-gray-300 mb-4">
                    <strong>Koordinat:</strong> {{ $umkm->latitude }}, {{ $umkm->longitude }}
                </p>
                @if($umkm->alamat_lengkap)
                <p class="text-gray-300">
                    <strong>Alamat:</strong> {{ $umkm->alamat_lengkap }}
                </p>
                @endif
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
