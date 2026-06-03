<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="font-semibold text-base text-white truncate">Kelola UMKM</h2>
            <a href="{{ route('superadmin.umkm.export', request()->query()) }}" 
               class="flex-shrink-0 inline-flex items-center justify-center gap-2 px-4 py-2 bg-arsa-800 border border-arsa-700 hover:border-gold-500 text-white hover:text-gold-400 font-semibold rounded-lg text-xs transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export CSV
            </a>
        </div>
    </x-slot>

    <div class="py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Flash Messages -->
            @if(session('success'))
            <div class="mb-6 bg-green-500/10 border border-green-500/30 rounded-lg p-4">
                <p class="text-green-300 text-sm font-semibold">{{ session('success') }}</p>
            </div>
            @endif

            <!-- Filters -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 sm:p-6 mb-6">
                <form method="GET" action="{{ route('superadmin.umkm.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
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

                    <div class="sm:col-span-2 lg:col-span-4 flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="bg-gradient-to-r from-gold-500 to-gold-600 text-black font-bold px-6 py-3 rounded-lg hover:from-gold-600 hover:to-gold-700 transition-all">
                            TERAPKAN FILTER
                        </button>
                        <a href="{{ route('superadmin.umkm.index') }}" class="bg-arsa-800 text-white font-bold px-6 py-3 rounded-lg border-2 border-arsa-700 hover:border-gold-500 transition-all text-center">
                            RESET
                        </a>
                    </div>
                </form>
            </div>

            <!-- UMKM List - Card view for mobile, table for desktop -->
            <!-- Desktop Table -->
            <div class="hidden lg:block bg-arsa-900 border border-arsa-800 rounded-xl overflow-hidden">
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
                                        <p class="text-gray-500 text-xs">{{ $umkm->user->email }}</p>
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
                                        <a href="{{ route('superadmin.umkm.show', $umkm) }}" 
                                           class="p-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500/20 transition-all" title="Lihat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('superadmin.umkm.edit', $umkm) }}" 
                                           class="p-2 bg-gold-500/10 text-gold-400 rounded-lg hover:bg-gold-500/20 transition-all" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('superadmin.umkm.toggle-publish', $umkm) }}">
                                            @csrf
                                            <button type="submit" class="p-2 bg-purple-500/10 text-purple-400 rounded-lg hover:bg-purple-500/20 transition-all" title="{{ $umkm->is_published ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M{{ $umkm->is_published ? '18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636' : '9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' }}"/>
                                                </svg>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('superadmin.umkm.destroy', $umkm) }}" onsubmit="return confirm('Yakin hapus UMKM ini? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500/20 transition-all" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="text-gray-500">
                                        <p class="text-lg font-semibold">Tidak ada UMKM ditemukan</p>
                                        <p class="text-sm mt-1">Coba ubah filter pencarian Anda</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($umkmList->hasPages())
                <div class="px-6 py-4 border-t border-arsa-800">
                    {{ $umkmList->links() }}
                </div>
                @endif
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden space-y-4">
                @forelse($umkmList as $umkm)
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-4">
                    <div class="flex items-start gap-3 mb-3">
                        <div class="w-12 h-12 bg-arsa-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            @if($umkm->logo_path)
                            <img src="{{ Storage::url($umkm->logo_path) }}" alt="{{ $umkm->nama_usaha }}" class="w-full h-full object-cover rounded-lg">
                            @else
                            <span class="text-2xl">🏪</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white font-semibold truncate">{{ $umkm->nama_usaha }}</p>
                            <p class="text-gray-400 text-sm">{{ $umkm->category->nama_kategori }} • {{ $umkm->district->nama_kecamatan }}</p>
                        </div>
                        @if($umkm->is_published)
                        <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded-full text-xs font-bold flex-shrink-0">AKTIF</span>
                        @else
                        <span class="px-2 py-1 bg-red-500/10 text-red-400 rounded-full text-xs font-bold flex-shrink-0">OFF</span>
                        @endif
                    </div>
                    <div class="text-sm text-gray-400 mb-3">
                        <p>Pemilik: {{ $umkm->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $umkm->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="flex items-center gap-2 pt-3 border-t border-arsa-800">
                        <a href="{{ route('superadmin.umkm.show', $umkm) }}" class="flex-1 text-center py-2 bg-blue-500/10 text-blue-400 rounded-lg text-sm font-medium hover:bg-blue-500/20 transition-all">Lihat</a>
                        <a href="{{ route('superadmin.umkm.edit', $umkm) }}" class="flex-1 text-center py-2 bg-gold-500/10 text-gold-400 rounded-lg text-sm font-medium hover:bg-gold-500/20 transition-all">Edit</a>
                        <form method="POST" action="{{ route('superadmin.umkm.toggle-publish', $umkm) }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-2 bg-purple-500/10 text-purple-400 rounded-lg text-sm font-medium hover:bg-purple-500/20 transition-all">
                                {{ $umkm->is_published ? 'Off' : 'On' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('superadmin.umkm.destroy', $umkm) }}" onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500/20 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-8 text-center">
                    <p class="text-gray-500 text-lg font-semibold">Tidak ada UMKM ditemukan</p>
                    <p class="text-gray-600 text-sm mt-1">Coba ubah filter pencarian Anda</p>
                </div>
                @endforelse

                @if($umkmList->hasPages())
                <div class="mt-4">
                    {{ $umkmList->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
