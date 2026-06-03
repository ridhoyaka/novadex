<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-xl text-white leading-tight" style="font-family: 'Space Grotesk', sans-serif;">
                Manajemen UMKM
            </h2>
            <div class="flex gap-2 sm:gap-3">
                <a href="{{ route('admin.umkm.export', request()->query()) }}" 
                   class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2.5 bg-arsa-800 border border-arsa-700 rounded-lg font-bold text-sm text-gray-300 hover:text-white hover:border-gold-500/50 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="hidden sm:inline">Export</span>
                </a>
                <a href="{{ route('admin.umkm.create') }}" 
                   class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2.5 bg-gradient-to-r from-gold-500 to-gold-600 rounded-lg font-bold text-sm text-black hover:from-gold-600 hover:to-gold-700 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="hidden sm:inline">Tambah UMKM</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <!-- Filters -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6 mb-6">
                <form method="GET" action="{{ route('admin.umkm.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-bold text-white mb-2 tracking-wide">CARI</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Nama UMKM..."
                               class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-bold text-white mb-2 tracking-wide">STATUS</label>
                        <select name="status" class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                            <option value="">Semua Status</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Aktif</option>
                            <option value="unpublished" {{ request('status') == 'unpublished' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <!-- Category Filter -->
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

                    <!-- District Filter -->
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

                    <div class="md:col-span-4 flex gap-3">
                        <button type="submit" class="bg-gradient-to-r from-gold-500 to-gold-600 text-black font-bold px-6 py-3 rounded-lg hover:from-gold-600 hover:to-gold-700 transition-all">
                            TERAPKAN FILTER
                        </button>
                        <a href="{{ route('admin.umkm.index') }}" class="bg-arsa-800 text-white font-bold px-6 py-3 rounded-lg border-2 border-arsa-700 hover:border-gold-500 transition-all">
                            RESET
                        </a>
                    </div>
                </form>
            </div>

            <!-- UMKM List -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-arsa-800 bg-arsa-800">
                                <th class="text-left py-4 px-6 text-gray-300 font-bold text-sm tracking-wide">UMKM</th>
                                <th class="text-left py-4 px-6 text-gray-300 font-bold text-sm tracking-wide">KATEGORI</th>
                                <th class="text-left py-4 px-6 text-gray-300 font-bold text-sm tracking-wide">KECAMATAN</th>
                                <th class="text-left py-4 px-6 text-gray-300 font-bold text-sm tracking-wide">PEMILIK</th>
                                <th class="text-left py-4 px-6 text-gray-300 font-bold text-sm tracking-wide">STATUS</th>
                                <th class="text-left py-4 px-6 text-gray-300 font-bold text-sm tracking-wide">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($umkmList as $umkm)
                            <tr class="border-b border-arsa-800 hover:bg-arsa-800 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-arsa-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                            @if($umkm->logo_path)
                                            <img src="{{ Storage::url($umkm->logo_path) }}" alt="{{ $umkm->nama_usaha }}" class="w-full h-full object-cover rounded-lg">
                                            @else
                                            <span class="text-2xl">🏪</span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold">{{ $umkm->nama_usaha }}</p>
                                            <p class="text-gray-400 text-sm">{{ $umkm->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-gray-300">{{ $umkm->category->nama_kategori }}</td>
                                <td class="py-4 px-6 text-gray-300">{{ $umkm->district->nama_kecamatan }}</td>
                                <td class="py-4 px-6">
                                    <div>
                                        <p class="text-white font-medium">{{ $umkm->user->name }}</p>
                                        <p class="text-gray-500 text-xs">Data kontak dilindungi</p>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($umkm->is_published)
                                    <span class="px-3 py-1 bg-green-500/10 text-green-400 rounded-full text-xs font-bold">AKTIF</span>
                                    @else
                                    <span class="px-3 py-1 bg-red-500/10 text-red-400 rounded-full text-xs font-bold">NONAKTIF</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.umkm.show', $umkm) }}" 
                                           class="p-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500/20 transition-all"
                                           title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        
                                        <!-- Moderate Publish (simplified for list view) -->
                                        <form action="{{ route('admin.umkm.moderate-publish', $umkm) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="action" value="{{ $umkm->is_published ? 'unpublish' : 'publish' }}">
                                            @if(!$umkm->is_published)
                                                <input type="hidden" name="reason" value="Admin activated profile">
                                            @endif
                                            <button type="submit" 
                                                    class="p-2 {{ $umkm->is_published ? 'bg-red-500/10 text-red-400 hover:bg-red-500/20' : 'bg-green-500/10 text-green-400 hover:bg-green-500/20' }} rounded-lg transition-all"
                                                    title="{{ $umkm->is_published ? 'Nonaktifkan (perlu alasan di detail page)' : 'Aktifkan' }}"
                                                    @if($umkm->is_published) onclick="return confirm('Untuk menonaktifkan profil, sebaiknya buka halaman detail untuk memberikan alasan. Lanjutkan tanpa alasan?')" @endif>
                                                @if($umkm->is_published)
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                                </svg>
                                                @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                @endif
                                            </button>
                                        </form>
                                        
                                        <!-- Note: Delete button removed - only UMKM owners can delete their profiles -->
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="text-gray-500">
                                        <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        <p class="text-lg font-semibold">Tidak ada UMKM ditemukan</p>
                                        <p class="text-sm mt-1">Coba ubah filter pencarian Anda</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($umkmList->hasPages())
                <div class="px-6 py-4 border-t border-arsa-800">
                    {{ $umkmList->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
