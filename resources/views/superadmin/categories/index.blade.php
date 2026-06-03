<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight" style="font-family: 'Space Grotesk', sans-serif;">
            Kelola Kategori UMKM
        </h2>
    </x-slot>

    <div class="py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Flash Messages -->
            @if(session('success'))
            <div class="mb-6 bg-green-500/10 border border-green-500/30 rounded-lg p-4">
                <p class="text-green-300 text-sm font-semibold">{{ session('success') }}</p>
            </div>
            @endif
            @if(session('error'))
            <div class="mb-6 bg-red-500/10 border border-red-500/30 rounded-lg p-4">
                <p class="text-red-300 text-sm font-semibold">{{ session('error') }}</p>
            </div>
            @endif

            <!-- Add Category Form -->
            <div class="mb-6 bg-arsa-900 border border-arsa-800 rounded-xl p-4 sm:p-6">
                <h3 class="text-lg font-bold text-white mb-4">Tambah Kategori Baru</h3>
                <form method="POST" action="{{ route('superadmin.categories.store') }}" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input type="text" name="nama_kategori" placeholder="Nama kategori..." required
                           class="flex-1 px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                    <button type="submit" class="bg-gradient-to-r from-gold-500 to-gold-600 text-black font-bold px-6 py-3 rounded-lg hover:from-gold-600 hover:to-gold-700 transition-all whitespace-nowrap">
                        + Tambah
                    </button>
                </form>
                @error('nama_kategori')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Categories List -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-arsa-800 bg-arsa-800">
                                <th class="text-left py-4 px-4 sm:px-6 text-gray-300 font-bold text-sm tracking-wide">KATEGORI</th>
                                <th class="text-left py-4 px-4 sm:px-6 text-gray-300 font-bold text-sm tracking-wide hidden sm:table-cell">JUMLAH UMKM</th>
                                <th class="text-left py-4 px-4 sm:px-6 text-gray-300 font-bold text-sm tracking-wide hidden md:table-cell">PERSENTASE</th>
                                <th class="text-right py-4 px-4 sm:px-6 text-gray-300 font-bold text-sm tracking-wide">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalUmkm = $categories->sum('umkm_profiles_count');
                            @endphp
                            @forelse($categories as $category)
                            <tr class="border-b border-arsa-800 hover:bg-arsa-800 transition-colors" x-data="{ editing: false }">
                                <td class="py-4 px-4 sm:px-6">
                                    <div x-show="!editing" class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gold-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <span class="text-xl">📦</span>
                                        </div>
                                        <div>
                                            <span class="text-white font-semibold">{{ $category->nama_kategori }}</span>
                                            <span class="sm:hidden text-gray-400 text-xs block">{{ $category->umkm_profiles_count }} UMKM</span>
                                        </div>
                                    </div>
                                    <form x-show="editing" method="POST" action="{{ route('superadmin.categories.update', $category) }}" class="flex gap-2" style="display: none;">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="nama_kategori" value="{{ $category->nama_kategori }}" 
                                               class="flex-1 px-3 py-2 bg-arsa-800 border border-arsa-700 rounded-lg text-white text-sm focus:border-gold-500">
                                        <button type="submit" class="px-3 py-2 bg-gold-500 text-black rounded-lg text-sm font-bold">Simpan</button>
                                        <button type="button" @click="editing = false" class="px-3 py-2 bg-arsa-700 text-white rounded-lg text-sm">Batal</button>
                                    </form>
                                </td>
                                <td class="py-4 px-4 sm:px-6 hidden sm:table-cell">
                                    <span class="text-gold-400 font-bold text-lg">{{ $category->umkm_profiles_count }}</span>
                                    <span class="text-gray-400 text-sm ml-1">UMKM</span>
                                </td>
                                <td class="py-4 px-4 sm:px-6 hidden md:table-cell">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 max-w-xs">
                                            <div class="w-full bg-arsa-700 rounded-full h-3">
                                                <div class="bg-gold-500 h-3 rounded-full transition-all" 
                                                     style="width: {{ $totalUmkm > 0 ? ($category->umkm_profiles_count / $totalUmkm) * 100 : 0 }}%"></div>
                                            </div>
                                        </div>
                                        <span class="text-gray-300 text-sm font-medium min-w-[3rem]">
                                            {{ $totalUmkm > 0 ? round(($category->umkm_profiles_count / $totalUmkm) * 100, 1) : 0 }}%
                                        </span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 sm:px-6 text-right">
                                    <div x-show="!editing" class="flex items-center justify-end gap-2">
                                        <button @click="editing = true" class="p-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500/20 transition-all" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        @if($category->umkm_profiles_count == 0)
                                        <form method="POST" action="{{ route('superadmin.categories.destroy', $category) }}" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500/20 transition-all" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center">
                                    <div class="text-gray-500">
                                        <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        <p class="text-lg font-semibold">Belum ada kategori</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Summary -->
                @if($categories->count() > 0)
                <div class="border-t border-arsa-800 bg-arsa-800 px-4 sm:px-6 py-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 text-sm">Total Kategori</span>
                        <span class="text-white font-bold text-lg">{{ $categories->count() }}</span>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
