<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-xl text-white leading-tight" style="font-family: 'Space Grotesk', sans-serif;">
                Detail UMKM
            </h2>
            <a href="{{ route('superadmin.umkm.index') }}" class="text-gold-400 hover:text-gold-300 text-sm font-semibold">
                ← Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Flash Messages -->
            @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/30 rounded-lg p-4">
                <p class="text-green-300 text-sm font-semibold">{{ session('success') }}</p>
            </div>
            @endif

            <!-- Main Info -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 sm:p-6 lg:p-8">
                <div class="flex flex-col sm:flex-row items-start gap-4 sm:gap-6 lg:gap-8">
                    <!-- Logo -->
                    <div class="w-24 h-24 sm:w-32 sm:h-32 bg-arsa-800 rounded-xl flex items-center justify-center flex-shrink-0 border-2 border-arsa-700 mx-auto sm:mx-0">
                        @if($umkm->logo_path)
                        <img src="{{ Storage::url($umkm->logo_path) }}" alt="{{ $umkm->nama_usaha }}" class="w-full h-full object-cover rounded-xl">
                        @else
                        <span class="text-5xl sm:text-6xl">🏪</span>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="flex-1 w-full">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-4 gap-3">
                            <div class="text-center sm:text-left">
                                <h1 class="text-2xl sm:text-3xl font-black text-white mb-2" style="font-family: 'Space Grotesk', sans-serif;">
                                    {{ $umkm->nama_usaha }}
                                </h1>
                                <div class="flex items-center gap-3 justify-center sm:justify-start flex-wrap">
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

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-gray-400 text-sm mb-1">Pemilik</p>
                                <p class="text-white font-semibold">{{ $umkm->user->name }}</p>
                                <p class="text-gray-400 text-xs">{{ $umkm->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm mb-1">Kecamatan</p>
                                <p class="text-white font-semibold">{{ $umkm->district->nama_kecamatan }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm mb-1">WhatsApp</p>
                                <p class="text-white font-semibold">{{ $umkm->whatsapp }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm mb-1">Terdaftar</p>
                                <p class="text-white font-semibold">{{ $umkm->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm mb-1">Slug</p>
                                <p class="text-white font-semibold break-all">{{ $umkm->slug }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm mb-1">Kelengkapan Profil</p>
                                <p class="text-white font-semibold">{{ $umkm->profile_completion_score }}%</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('superadmin.umkm.edit', $umkm) }}" 
                               class="bg-gradient-to-r from-gold-500 to-gold-600 text-black font-bold px-5 py-2.5 rounded-lg hover:from-gold-600 hover:to-gold-700 transition-all text-sm">
                                Edit UMKM
                            </a>
                            <form method="POST" action="{{ route('superadmin.umkm.toggle-publish', $umkm) }}">
                                @csrf
                                <button type="submit" class="bg-purple-500/10 border border-purple-500/30 text-purple-400 font-bold px-5 py-2.5 rounded-lg hover:bg-purple-500/20 transition-all text-sm">
                                    {{ $umkm->is_published ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <a href="{{ route('umkm.show', $umkm->slug) }}" target="_blank" 
                               class="bg-blue-500/10 border border-blue-500/30 text-blue-400 font-bold px-5 py-2.5 rounded-lg hover:bg-blue-500/20 transition-all text-sm">
                                Lihat Publik
                            </a>
                            <form method="POST" action="{{ route('superadmin.umkm.destroy', $umkm) }}" onsubmit="return confirm('Yakin hapus UMKM ini? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500/10 border border-red-500/30 text-red-400 font-bold px-5 py-2.5 rounded-lg hover:bg-red-500/20 transition-all text-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 sm:p-6 lg:p-8">
                <h3 class="text-xl font-bold text-white mb-4" style="font-family: 'Space Grotesk', sans-serif;">Deskripsi Usaha</h3>
                <p class="text-gray-300 leading-relaxed">{{ $umkm->deskripsi }}</p>
            </div>

            <!-- Gallery -->
            @if($umkm->photos && count($umkm->photos) > 0)
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 sm:p-6 lg:p-8">
                <h3 class="text-xl font-bold text-white mb-4" style="font-family: 'Space Grotesk', sans-serif;">Galeri Foto</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
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
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 sm:p-6 lg:p-8">
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
