<x-guest-layout>
    <div class="min-h-screen bg-arsa-950">
        <!-- Header -->
        <div class="relative bg-arsa-900 border-b border-arsa-800 py-20 overflow-hidden">
            <!-- Geometric Background -->
            <div class="absolute inset-0">
                <div class="absolute top-0 right-0 w-96 h-96 bg-gold-500/5 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-gold-500/5 rounded-full blur-3xl"></div>
            </div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <div class="inline-block mb-4 px-4 py-2 bg-gold-500/10 border border-gold-500/20 rounded-sm text-gold-400 text-xs font-bold tracking-widest">
                        JELAJAHI KATEGORI
                    </div>
                    <h1 class="text-5xl md:text-6xl font-black text-white mb-6" style="font-family: 'Space Grotesk', sans-serif;">
                        Kategori UMKM
                    </h1>
                    <div class="w-24 h-1 bg-gold-500 mx-auto mb-6"></div>
                    <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                        Temukan berbagai jenis usaha lokal di Salatiga
                    </p>
                </div>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            @if($categories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $category)
                <a href="{{ route('umkm.index', ['category' => $category->id]) }}" 
                   class="group relative bg-arsa-900 border border-arsa-800 rounded-xl p-8 hover:border-gold-500 transition-all overflow-hidden">
                    <!-- Hover Effect Background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-gold-500/0 to-gold-500/0 group-hover:from-gold-500/5 group-hover:to-gold-500/10 transition-all"></div>
                    
                    <!-- Content -->
                    <div class="relative">
                        <!-- Icon -->
                        <div class="mb-6 flex items-center justify-center w-20 h-20 bg-gold-500/10 rounded-xl group-hover:bg-gold-500/20 transition-all">
                            <span class="text-5xl group-hover:scale-110 transition-transform">{{ $category->icon ?? '🏢' }}</span>
                        </div>
                        
                        <!-- Category Name -->
                        <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-gold-400 transition-colors" style="font-family: 'Space Grotesk', sans-serif;">
                            {{ $category->nama_kategori }}
                        </h3>
                        
                        <!-- UMKM Count -->
                        <div class="flex items-center gap-2 text-gray-400 mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span class="font-semibold">{{ $category->umkm_profiles_count }} UMKM</span>
                        </div>
                        
                        <!-- Progress Bar -->
                        @php
                            $totalUmkm = $categories->sum('umkm_profiles_count');
                            $percentage = $totalUmkm > 0 ? ($category->umkm_profiles_count / $totalUmkm) * 100 : 0;
                        @endphp
                        <div class="w-full bg-arsa-800 rounded-full h-2 mb-3">
                            <div class="bg-gold-500 h-2 rounded-full transition-all group-hover:bg-gold-400" 
                                 style="width: {{ $percentage }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500">{{ round($percentage, 1) }}% dari total UMKM</p>
                        
                        <!-- Arrow Icon -->
                        <div class="absolute top-8 right-8 opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="text-6xl mb-6">📦</div>
                <h3 class="text-2xl font-bold text-white mb-3">Belum Ada Kategori</h3>
                <p class="text-gray-400 mb-8">Kategori UMKM akan ditampilkan di sini</p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-gold-500 text-black px-6 py-3 rounded-lg font-bold hover:bg-gold-400 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
            @endif
        </div>

        <!-- CTA Section -->
        <div class="bg-arsa-900 border-t border-arsa-800 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">Tidak Menemukan yang Anda Cari?</h2>
                <p class="text-gray-400 mb-8">Jelajahi semua UMKM atau gunakan pencarian untuk hasil yang lebih spesifik</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('umkm.index') }}" class="inline-flex items-center gap-2 bg-gold-500 text-black px-8 py-3 rounded-lg font-bold hover:bg-gold-400 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Lihat Semua UMKM
                    </a>
                    <a href="{{ route('umkm.map') }}" class="inline-flex items-center gap-2 bg-arsa-800 border-2 border-arsa-700 text-white px-8 py-3 rounded-lg font-bold hover:border-gold-500 hover:text-gold-400 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        Lihat Peta UMKM
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
