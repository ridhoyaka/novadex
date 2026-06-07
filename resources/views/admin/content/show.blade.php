<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="font-semibold text-xl text-white leading-tight" style="font-family: 'Space Grotesk', sans-serif;">
                    Review Konten UMKM
                </h2>
                <p class="text-sm text-arsa-400 mt-1">Tampilan read-only untuk mengecek kelayakan konten publik.</p>
            </div>
            <a href="{{ route('admin.content.index') }}" class="text-gold-400 hover:text-gold-300 text-sm font-semibold">
                &larr; Kembali ke Monitoring
            </a>
        </div>
    </x-slot>

    <div class="py-6 lg:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
            <div class="bg-gold-900/20 border border-gold-500 text-gold-300 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-900/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-4 sm:p-6 lg:p-8">
                        <div class="flex flex-col sm:flex-row gap-5">
                            <div class="w-24 h-24 sm:w-32 sm:h-32 bg-arsa-800 rounded-xl flex items-center justify-center flex-shrink-0 border border-arsa-700 overflow-hidden">
                                @if($profile->logo_path)
                                <img src="{{ Storage::url($profile->logo_path) }}" alt="{{ $profile->nama_usaha }}" class="w-full h-full object-cover">
                                @else
                                <svg class="w-12 h-12 text-arsa-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2"/>
                                </svg>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="px-3 py-1 bg-gold-500/10 text-gold-400 rounded-full text-sm font-semibold">
                                        {{ $profile->category->nama_kategori ?? '-' }}
                                    </span>
                                    @if($profile->is_published)
                                    <span class="px-3 py-1 bg-green-500/10 text-green-400 rounded-full text-sm font-semibold">DIPUBLIKASI</span>
                                    @else
                                    <span class="px-3 py-1 bg-red-500/10 text-red-400 rounded-full text-sm font-semibold">BELUM PUBLIK</span>
                                    @endif
                                </div>

                                <h1 class="text-2xl sm:text-3xl font-black text-white break-words" style="font-family: 'Space Grotesk', sans-serif;">
                                    {{ $profile->nama_usaha }}
                                </h1>
                                <p class="text-arsa-300 mt-2">{{ $profile->district->nama_kecamatan ?? '-' }}</p>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                                    <div>
                                        <p class="text-arsa-400 text-sm">Pemilik</p>
                                        <p class="text-white font-semibold">{{ $profile->user->name ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-arsa-400 text-sm">Kelengkapan</p>
                                        <p class="text-white font-semibold">{{ $profile->profile_completion_score ?? 0 }}%</p>
                                    </div>
                                    <div>
                                        <p class="text-arsa-400 text-sm">Terakhir Update</p>
                                        <p class="text-white font-semibold">{{ $profile->updated_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-4 sm:p-6 lg:p-8">
                        <div class="flex items-center justify-between gap-4 mb-4">
                            <h3 class="text-xl font-bold text-white" style="font-family: 'Space Grotesk', sans-serif;">Deskripsi Publik</h3>
                            <span class="text-sm text-arsa-400">{{ strlen(trim($profile->deskripsi ?? '')) }} karakter</span>
                        </div>
                        <p class="text-gray-300 leading-relaxed whitespace-pre-line">{{ $profile->deskripsi }}</p>
                    </div>

                    <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-4 sm:p-6 lg:p-8">
                        <h3 class="text-xl font-bold text-white mb-4" style="font-family: 'Space Grotesk', sans-serif;">Galeri Konten</h3>
                        @if($profile->photos && count($profile->photos) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($profile->photos as $photo)
                            <div class="aspect-video bg-arsa-800 rounded-lg overflow-hidden border border-arsa-700">
                                <img src="{{ Storage::url($photo) }}" alt="Foto {{ $profile->nama_usaha }}" class="w-full h-full object-cover">
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="border border-dashed border-arsa-700 rounded-lg p-8 text-center">
                            <svg class="w-12 h-12 mx-auto text-arsa-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-arsa-300 font-semibold">Belum ada foto galeri</p>
                            <p class="text-arsa-500 text-sm mt-1">Konten publik akan lebih kuat jika UMKM menambahkan foto produk atau tempat usaha.</p>
                        </div>
                        @endif
                    </div>

                    <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-4 sm:p-6 lg:p-8">
                        <h3 class="text-xl font-bold text-white mb-4" style="font-family: 'Space Grotesk', sans-serif;">Informasi Lokasi</h3>
                        @if($profile->latitude && $profile->longitude)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-arsa-400 text-sm">Koordinat</p>
                                <p class="text-white font-semibold">{{ $profile->latitude }}, {{ $profile->longitude }}</p>
                            </div>
                            <div>
                                <p class="text-arsa-400 text-sm">Alamat</p>
                                <p class="text-white font-semibold">{{ $profile->alamat_lengkap ?: '-' }}</p>
                            </div>
                        </div>
                        @else
                        <p class="text-yellow-300">Lokasi belum dilengkapi, sehingga UMKM tidak tampil optimal di peta.</p>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-5">
                        <h3 class="text-white font-bold mb-4">Catatan Kualitas</h3>
                        <div class="space-y-3">
                            @if(count($missingFields) > 0)
                                @foreach($missingFields as $field)
                                <div class="flex items-start gap-3 p-3 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-yellow-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                    </svg>
                                    <p class="text-yellow-100 text-sm">{{ $field }}</p>
                                </div>
                                @endforeach
                            @else
                                <div class="p-3 bg-green-500/10 border border-green-500/20 rounded-lg">
                                    <p class="text-green-300 text-sm font-semibold">Tidak ada catatan kualitas utama.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-blue-500/10 border border-blue-500/30 rounded-lg p-5">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <div>
                                <p class="text-blue-300 text-sm font-semibold mb-1">Data kontak dilindungi</p>
                                <p class="text-blue-200 text-xs">Email dan nomor WhatsApp tidak ditampilkan di monitoring konten.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-5">
                        <h3 class="text-white font-bold mb-4">Tandai untuk Review</h3>
                        <form method="POST" action="{{ route('admin.flags.store', $profile) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-semibold text-arsa-300 mb-2">Jenis Catatan</label>
                                <select name="flag_type" required class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                                    <option value="quality">Kualitas perlu ditingkatkan</option>
                                    <option value="incomplete">Profil belum lengkap</option>
                                    <option value="inappropriate">Konten tidak sesuai</option>
                                    <option value="duplicate">Dugaan duplikat</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-arsa-300 mb-2">Catatan untuk UMKM</label>
                                <textarea name="reason"
                                          rows="4"
                                          maxlength="500"
                                          class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all"
                                          placeholder="Contoh: Mohon tambahkan foto produk dan lengkapi alamat usaha."></textarea>
                            </div>
                            <button type="submit" class="w-full bg-gradient-to-r from-gold-500 to-gold-600 text-black font-bold px-6 py-3 rounded-lg hover:from-gold-600 hover:to-gold-700 transition-all">
                                Simpan Catatan
                            </button>
                        </form>
                    </div>

                    <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-5">
                        <h3 class="text-white font-bold mb-4">Riwayat Flag</h3>
                        <div class="space-y-3">
                            @forelse($profile->flags as $flag)
                            <div class="p-3 bg-arsa-800/60 border border-arsa-700 rounded-lg">
                                <div class="flex items-center justify-between gap-3 mb-2">
                                    <span class="text-sm font-semibold text-gold-300">
                                        @switch($flag->flag_type)
                                            @case('inappropriate') Konten tidak sesuai @break
                                            @case('duplicate') Dugaan duplikat @break
                                            @case('incomplete') Profil belum lengkap @break
                                            @default Kualitas perlu ditingkatkan
                                        @endswitch
                                    </span>
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        @if($flag->status === 'active') bg-yellow-500/10 text-yellow-300
                                        @elseif($flag->status === 'resolved') bg-green-500/10 text-green-300
                                        @else bg-arsa-700 text-arsa-300
                                        @endif">
                                        {{ strtoupper($flag->status) }}
                                    </span>
                                </div>
                                @if($flag->reason)
                                <p class="text-sm text-arsa-300 mb-2">{{ $flag->reason }}</p>
                                @endif
                                <p class="text-xs text-arsa-500">{{ $flag->admin->name ?? 'Admin' }} - {{ $flag->created_at->format('d M Y H:i') }}</p>
                            </div>
                            @empty
                            <p class="text-sm text-arsa-400">Belum ada flag untuk profil ini.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-5">
                        <h3 class="text-white font-bold mb-4">Aksi</h3>
                        <div class="space-y-3">
                            @if($profile->is_published)
                            <a href="{{ route('umkm.show', $profile->slug) }}" target="_blank"
                               class="block text-center bg-arsa-800 text-gold-400 font-bold px-5 py-3 rounded-lg border border-gold-500/50 hover:bg-gold-500/10 transition-all">
                                Lihat Halaman Publik
                            </a>
                            @else
                            <div class="text-center bg-arsa-800 text-arsa-400 font-bold px-5 py-3 rounded-lg border border-arsa-700">
                                Belum tampil publik
                            </div>
                            @endif
                            <a href="{{ route('admin.umkm.show', $profile) }}"
                               class="block text-center bg-arsa-800 text-white font-bold px-5 py-3 rounded-lg border border-arsa-700 hover:border-gold-500 transition-all">
                                Buka Detail UMKM
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
