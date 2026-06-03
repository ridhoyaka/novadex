<x-guest-layout>
    {{-- HERO --}}
    <section class="bg-arsa-900 py-24 sm:py-32">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-block px-3 py-1 mb-8 text-xs font-semibold tracking-wider uppercase text-gold-400 bg-gold-500/10 border border-gold-500/20 rounded-full">
                Katalog Digital UMKM
            </span>

            <h1 class="text-5xl sm:text-6xl md:text-7xl font-black text-white leading-none mb-4 tracking-tight" style="font-family: 'Space Grotesk', sans-serif;">
                Nova<span class="text-gold-400">Dex</span>
            </h1>
            <p class="text-lg sm:text-xl text-gray-300 mb-4 font-medium">
                Temukan UMKM Lokal <span class="text-gold-400 font-bold">Salatiga</span>
            </p>

            <p class="max-w-lg mx-auto text-gray-500 text-sm sm:text-base mb-12">
                Direktori digital yang menghubungkan bisnis lokal dengan masyarakat. Jelajahi {{ $totalUmkm }} UMKM terpercaya di Kota Salatiga.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 max-w-sm mx-auto">
                <a href="{{ route('umkm.index') }}" class="w-full sm:w-auto px-7 py-3 bg-gold-500 hover:bg-gold-400 text-black font-bold text-sm rounded-lg text-center transition">
                    Jelajahi Katalog →
                </a>
                <a href="{{ route('umkm.map') }}" class="w-full sm:w-auto px-7 py-3 bg-arsa-800 border border-arsa-700 hover:border-gold-500 text-white text-sm font-semibold rounded-lg text-center transition">
                    📍 Lihat Peta
                </a>
            </div>
        </div>
    </section>

    {{-- KATEGORI --}}
    <section class="bg-arsa-950 py-12 sm:py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-xl sm:text-2xl font-bold text-white mb-1">Kategori UMKM</h2>
                <p class="text-sm text-gray-500">Temukan berbagai jenis usaha lokal di Salatiga</p>
            </div>

            <div class="swiper homeCategorySwiper overflow-hidden">
                <div class="swiper-wrapper">
                    @forelse($featuredCategories as $category)
                    <div class="swiper-slide" style="height:auto">
                        <a href="{{ route('umkm.index', ['category' => $category->id]) }}" class="block h-full p-4 rounded-xl bg-arsa-800 border border-arsa-700 hover:border-gold-500 transition">
                            <div class="w-10 h-10 rounded-lg bg-gold-500/10 flex items-center justify-center mb-2">
                                <span class="text-lg">{{ $category->icon ?? '🏢' }}</span>
                            </div>
                            <h3 class="font-semibold text-white text-sm mb-0.5">{{ $category->nama_kategori }}</h3>
                            <p class="text-xs text-gray-500">{{ $category->umkm_profiles_count }} UMKM</p>
                        </a>
                    </div>
                    @empty
                    <div class="swiper-slide">
                        <p class="text-center text-gray-500 py-6 text-sm">Belum ada kategori.</p>
                    </div>
                    @endforelse
                </div>
                <div class="swiper-pagination mt-4"></div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('umkm.categories') }}" class="text-xs text-gray-400 hover:text-gold-400 transition">
                    Lihat Semua Kategori →
                </a>
            </div>
        </div>
    </section>

    {{-- UMKM TERBARU --}}
    <section class="bg-arsa-900 py-12 sm:py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-xl sm:text-2xl font-bold text-white mb-1">UMKM Terbaru</h2>
                <p class="text-sm text-gray-500">Bisnis lokal yang baru bergabung dengan NovaDex</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($newestUmkm as $umkm)
                <a href="{{ route('umkm.show', $umkm->slug) }}" class="group block rounded-xl bg-arsa-800 border border-arsa-700 overflow-hidden hover:border-gold-500 transition">
                    {{-- Image --}}
                    <div class="relative h-40 bg-arsa-700">
                        @if($umkm->logo_path)
                        <img src="{{ Storage::url($umkm->logo_path) }}" alt="{{ $umkm->nama_usaha }}" class="w-full h-full object-cover" loading="lazy">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <div class="w-12 h-12 rounded-lg bg-gold-500/10 flex items-center justify-center">
                                <span class="text-sm font-bold text-gold-400">{{ strtoupper(mb_substr($umkm->nama_usaha, 0, 2)) }}</span>
                            </div>
                        </div>
                        @endif
                        <span class="absolute top-2 right-2 bg-gold-500 text-black text-xs font-bold px-2 py-0.5 rounded">Baru</span>
                    </div>

                    {{-- Content --}}
                    <div class="p-4">
                        <h3 class="font-semibold text-white text-sm mb-2 line-clamp-1 group-hover:text-gold-400 transition">{{ $umkm->nama_usaha }}</h3>

                        <div class="flex items-center gap-2 mb-2">
                            @if(optional($umkm->category)->nama_kategori)
                            <span class="text-xs text-gold-400 bg-gold-500/10 px-2 py-0.5 rounded">{{ $umkm->category->nama_kategori }}</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between text-xs text-gray-500">
                            @if(optional($umkm->district)->nama_kecamatan)
                            <span>📍 {{ $umkm->district->nama_kecamatan }}</span>
                            @else
                            <span></span>
                            @endif
                            <span class="group-hover:text-gold-400 transition">Lihat →</span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500 text-sm">Belum ada UMKM terdaftar.</p>
                </div>
                @endforelse
            </div>

            @if($newestUmkm->count() > 0)
            <div class="text-center mt-8">
                <a href="{{ route('umkm.index') }}" class="inline-block px-6 py-3 bg-gold-500 hover:bg-gold-400 text-black font-bold text-sm rounded-lg transition">
                    Lihat Semua UMKM →
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- ABOUT --}}
    <section class="bg-arsa-950 py-12 sm:py-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-xl bg-arsa-800 border border-arsa-700 p-6 sm:p-10 text-center">
                <h2 class="text-lg sm:text-xl font-bold text-white mb-3">Tentang NovaDex</h2>
                <p class="text-sm text-gray-400 leading-relaxed mb-2">
                    NovaDex adalah platform katalog digital yang membangun fondasi digital untuk UMKM di Kota Salatiga.
                </p>
                <p class="text-sm text-gray-400 leading-relaxed mb-6">
                    Direktori publik yang memudahkan masyarakat menemukan bisnis lokal, sekaligus membantu pemerintah memahami ekosistem UMKM.
                </p>

                <div class="grid grid-cols-3 gap-3 max-w-xs mx-auto">
                    <div class="py-3 rounded-lg bg-arsa-900 border border-arsa-700">
                        <p class="text-lg font-bold text-gold-400">{{ $totalUmkm }}</p>
                        <p class="text-xs text-gray-500">UMKM</p>
                    </div>
                    <div class="py-3 rounded-lg bg-arsa-900 border border-arsa-700">
                        <p class="text-lg font-bold text-gold-400">{{ $totalCategories }}</p>
                        <p class="text-xs text-gray-500">Kategori</p>
                    </div>
                    <div class="py-3 rounded-lg bg-arsa-900 border border-arsa-700">
                        <p class="text-lg font-bold text-gold-400">1</p>
                        <p class="text-xs text-gray-500">Kota</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SWIPER --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.homeCategorySwiper', {
            slidesPerView: 2,
            spaceBetween: 12,
            loop: true,
            autoplay: { delay: 4000, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
            breakpoints: {
                640: { slidesPerView: 3, spaceBetween: 12 },
                1024: { slidesPerView: 4, spaceBetween: 16 },
                1280: { slidesPerView: 5, spaceBetween: 16 },
            },
        });
    });
    </script>
    <style>
    .swiper-pagination { position: relative !important; margin-top: 16px; }
    .swiper-pagination-bullet { background: #6c757d; opacity: 1; }
    .swiper-pagination-bullet-active { background: #f59e0b; }
    .homeCategorySwiper { padding-bottom: 8px; }
    </style>
</x-guest-layout>
