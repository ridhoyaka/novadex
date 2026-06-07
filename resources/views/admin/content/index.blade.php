<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-semibold text-xl text-white leading-tight" style="font-family: 'Space Grotesk', sans-serif;">
                    Monitoring Konten
                </h2>
                <p class="text-sm text-arsa-400 mt-1">Audit kualitas profil UMKM yang menjadi konten publik.</p>
            </div>
            <a href="{{ route('admin.content.map') }}"
               class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-arsa-800 border border-arsa-700 rounded-lg text-sm font-semibold text-gray-300 hover:text-white hover:border-gold-500/50 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
                Peta UMKM
            </a>
        </div>
    </x-slot>

    <div class="py-6 lg:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
                <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-4">
                    <p class="text-arsa-400 text-sm">Total Profil</p>
                    <p class="text-white text-2xl font-bold mt-1">{{ $stats['total'] }}</p>
                    <p class="text-gold-400 text-xs mt-1">{{ $stats['published'] }} tampil publik</p>
                </div>
                <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-4">
                    <p class="text-arsa-400 text-sm">Tanpa Foto</p>
                    <p class="text-white text-2xl font-bold mt-1">{{ $stats['no_photo'] }}</p>
                    <p class="text-arsa-500 text-xs mt-1">Logo dan galeri kosong</p>
                </div>
                <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-4">
                    <p class="text-arsa-400 text-sm">Perlu Dilengkapi</p>
                    <p class="text-white text-2xl font-bold mt-1">{{ $stats['low_completion'] }}</p>
                    <p class="text-arsa-500 text-xs mt-1">Skor kelengkapan di bawah 50%</p>
                </div>
                <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-4">
                    <p class="text-arsa-400 text-sm">Flag Aktif</p>
                    <p class="text-white text-2xl font-bold mt-1">{{ $stats['active_flags'] }}</p>
                    <p class="text-arsa-500 text-xs mt-1">Menunggu tindak lanjut UMKM</p>
                </div>
            </div>

            <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-4 sm:p-6 mb-6">
                <form method="GET" action="{{ route('admin.content.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-white mb-2 tracking-wide">CARI</label>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Nama UMKM..."
                               class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-white mb-2 tracking-wide">STATUS</label>
                        <select name="status" class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                            <option value="">Semua Status</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Dipublikasi</option>
                            <option value="unpublished" {{ request('status') == 'unpublished' ? 'selected' : '' }}>Belum Dipublikasi</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-white mb-2 tracking-wide">KATEGORI</label>
                        <select name="category" class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-white mb-2 tracking-wide">KECAMATAN</label>
                        <select name="district" class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                            <option value="">Semua Kecamatan</option>
                            @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ request('district') == $district->id ? 'selected' : '' }}>
                                {{ $district->nama_kecamatan }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-white mb-2 tracking-wide">KUALITAS</label>
                        <select name="quality" class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                            <option value="">Semua Kualitas</option>
                            <option value="no_photo" {{ request('quality') == 'no_photo' ? 'selected' : '' }}>Tanpa Foto</option>
                            <option value="short_desc" {{ request('quality') == 'short_desc' ? 'selected' : '' }}>Deskripsi Pendek</option>
                            <option value="no_location" {{ request('quality') == 'no_location' ? 'selected' : '' }}>Tanpa Lokasi</option>
                            <option value="low_completion" {{ request('quality') == 'low_completion' ? 'selected' : '' }}>Kelengkapan Rendah</option>
                            <option value="flagged" {{ request('quality') == 'flagged' ? 'selected' : '' }}>Ada Flag Aktif</option>
                        </select>
                    </div>

                    <div class="md:col-span-5 flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="bg-gradient-to-r from-gold-500 to-gold-600 text-black font-bold px-6 py-3 rounded-lg hover:from-gold-600 hover:to-gold-700 transition-all">
                            TERAPKAN FILTER
                        </button>
                        <a href="{{ route('admin.content.index') }}" class="text-center bg-arsa-800 text-white font-bold px-6 py-3 rounded-lg border-2 border-arsa-700 hover:border-gold-500 transition-all">
                            RESET
                        </a>
                    </div>
                </form>
            </div>

            <div class="bg-arsa-900 border border-arsa-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-arsa-800 bg-arsa-800">
                                <th class="text-left py-4 px-6 text-gray-300 font-bold text-sm tracking-wide">KONTEN UMKM</th>
                                <th class="text-left py-4 px-6 text-gray-300 font-bold text-sm tracking-wide">KATEGORI</th>
                                <th class="text-left py-4 px-6 text-gray-300 font-bold text-sm tracking-wide">STATUS</th>
                                <th class="text-left py-4 px-6 text-gray-300 font-bold text-sm tracking-wide">KUALITAS</th>
                                <th class="text-left py-4 px-6 text-gray-300 font-bold text-sm tracking-wide">MASALAH</th>
                                <th class="text-left py-4 px-6 text-gray-300 font-bold text-sm tracking-wide">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($profiles as $profile)
                            @php
                                $issues = [];
                                if (!$profile->logo_path && (empty($profile->photos) || count($profile->photos) === 0)) {
                                    $issues[] = 'Tanpa foto';
                                }
                                if (strlen(trim($profile->deskripsi ?? '')) < 50) {
                                    $issues[] = 'Deskripsi pendek';
                                }
                                if (!$profile->latitude || !$profile->longitude) {
                                    $issues[] = 'Tanpa lokasi';
                                }
                                if (($profile->profile_completion_score ?? 0) < 50) {
                                    $issues[] = 'Kelengkapan rendah';
                                }
                                if (($profile->active_flags_count ?? 0) > 0) {
                                    $issues[] = 'Ada flag aktif';
                                }
                            @endphp
                            <tr class="border-b border-arsa-800 hover:bg-arsa-800 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-arsa-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                            @if($profile->logo_path)
                                            <img src="{{ Storage::url($profile->logo_path) }}" alt="{{ $profile->nama_usaha }}" class="w-full h-full object-cover rounded-lg">
                                            @else
                                            <svg class="w-6 h-6 text-arsa-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2"/>
                                            </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold">{{ $profile->nama_usaha }}</p>
                                            <p class="text-gray-400 text-sm">{{ $profile->district->nama_kecamatan ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-gray-300">{{ $profile->category->nama_kategori ?? '-' }}</td>
                                <td class="py-4 px-6">
                                    @if($profile->is_published)
                                    <span class="px-3 py-1 bg-green-500/10 text-green-400 rounded-full text-xs font-bold">DIPUBLIKASI</span>
                                    @else
                                    <span class="px-3 py-1 bg-red-500/10 text-red-400 rounded-full text-xs font-bold">BELUM PUBLIK</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3 min-w-[150px]">
                                        <div class="flex-1 bg-arsa-800 rounded-full h-2">
                                            <div class="h-2 rounded-full {{ ($profile->profile_completion_score ?? 0) >= 80 ? 'bg-green-500' : (($profile->profile_completion_score ?? 0) >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                                 style="width: {{ $profile->profile_completion_score ?? 0 }}%"></div>
                                        </div>
                                        <span class="text-white text-sm font-bold">{{ $profile->profile_completion_score ?? 0 }}%</span>
                                    </div>
                                    <p class="text-arsa-500 text-xs mt-1">
                                        {{ $profile->photos && count($profile->photos) > 0 ? count($profile->photos) : 0 }} foto galeri
                                    </p>
                                </td>
                                <td class="py-4 px-6">
                                    @if(count($issues) > 0)
                                    <div class="flex flex-wrap gap-2 max-w-xs">
                                        @foreach($issues as $issue)
                                        <span class="px-2 py-1 bg-yellow-500/10 text-yellow-300 border border-yellow-500/20 rounded-full text-xs font-semibold">{{ $issue }}</span>
                                        @endforeach
                                    </div>
                                    @else
                                    <span class="px-2 py-1 bg-green-500/10 text-green-400 border border-green-500/20 rounded-full text-xs font-semibold">Tidak ada catatan</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <a href="{{ route('admin.content.show', $profile) }}"
                                       class="inline-flex items-center gap-2 px-3 py-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500/20 transition-all text-sm font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Review
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="text-gray-500">
                                        <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                                        </svg>
                                        <p class="text-lg font-semibold">Tidak ada konten ditemukan</p>
                                        <p class="text-sm mt-1">Coba ubah filter monitoring.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($profiles->hasPages())
                <div class="px-6 py-4 border-t border-arsa-800">
                    {{ $profiles->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
