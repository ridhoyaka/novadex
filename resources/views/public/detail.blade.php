<x-guest-layout>
    @push('meta')
    <!-- SEO Meta Tags -->
    <title>{{ $umkm->seo_title ?? $umkm->nama_usaha . ' - ' . $umkm->category->nama_kategori . ' | NovaDex' }}</title>
    <meta name="description" content="{{ $umkm->seo_description ?? Str::limit(strip_tags($umkm->deskripsi), 155) }}">
    <meta name="keywords" content="{{ $umkm->nama_usaha }}, {{ $umkm->category->nama_kategori }}, {{ $umkm->district->nama_kecamatan }}, UMKM Salatiga, {{ $umkm->category->nama_kategori }} Salatiga">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="business.business">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $umkm->seo_title ?? $umkm->nama_usaha }}">
    <meta property="og:description" content="{{ $umkm->seo_description ?? Str::limit(strip_tags($umkm->deskripsi), 155) }}">
    @if($umkm->logo_path)
    <meta property="og:image" content="{{ Storage::url($umkm->logo_path) }}">
    @elseif($umkm->photos && count($umkm->photos) > 0)
    <meta property="og:image" content="{{ Storage::url($umkm->photos[0]) }}">
    @endif
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="NovaDex - Platform Digital UMKM Salatiga">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $umkm->seo_title ?? $umkm->nama_usaha }}">
    <meta name="twitter:description" content="{{ $umkm->seo_description ?? Str::limit(strip_tags($umkm->deskripsi), 155) }}">
    @if($umkm->logo_path)
    <meta name="twitter:image" content="{{ Storage::url($umkm->logo_path) }}">
    @elseif($umkm->photos && count($umkm->photos) > 0)
    <meta name="twitter:image" content="{{ Storage::url($umkm->photos[0]) }}">
    @endif
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {!! json_encode(app(\App\Services\SeoService::class)->generateStructuredData($umkm), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    
    <!-- Breadcrumb Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "Beranda",
                "item": "{{ route('home') }}"
            },
            {
                "@type": "ListItem",
                "position": 2,
                "name": "Katalog UMKM",
                "item": "{{ route('umkm.index') }}"
            },
            {
                "@type": "ListItem",
                "position": 3,
                "name": "{{ $umkm->category->nama_kategori }}",
                "item": "{{ route('umkm.index', ['kategori' => $umkm->kategori_id]) }}"
            },
            {
                "@type": "ListItem",
                "position": 4,
                "name": "{{ $umkm->nama_usaha }}",
                "item": "{{ url()->current() }}"
            }
        ]
    }
    </script>
    @endpush
    
    <div class="min-h-screen bg-[#f6f2e8]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Breadcrumb Navigation -->
            <nav class="mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="text-[#657066] transition-colors hover:text-[#2f9e8f]">
                            Beranda
                        </a>
                    </li>
                    <li class="text-[#a89985]">/</li>
                    <li>
                        <a href="{{ route('umkm.index') }}" class="text-[#657066] transition-colors hover:text-[#2f9e8f]">
                            Katalog UMKM
                        </a>
                    </li>
                    <li class="text-[#a89985]">/</li>
                    <li>
                        <a href="{{ route('umkm.index', ['kategori' => $umkm->kategori_id]) }}" class="text-[#657066] transition-colors hover:text-[#2f9e8f]">
                            {{ $umkm->category->nama_kategori }}
                        </a>
                    </li>
                    <li class="text-[#a89985]">/</li>
                    <li class="font-medium text-[#141712]" aria-current="page">
                        {{ Str::limit($umkm->nama_usaha, 30) }}
                    </li>
                </ol>
            </nav>
            
            <!-- Back Button -->
            <div class="mb-8">
                <a href="{{ route('umkm.index') }}" class="inline-flex items-center gap-2 font-medium text-[#657066] transition-colors hover:text-[#2f9e8f]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Katalog
                </a>
            </div>

            <!-- Header -->
            <div class="mb-8 border border-[#ded6c6] bg-white p-6 sm:p-8">
                <div class="flex flex-col md:flex-row items-start gap-8">
                    <div class="flex h-40 w-40 flex-shrink-0 items-center justify-center bg-[#10130f]">
                        @if($umkm->logo_path)
                        <img src="{{ Storage::url($umkm->logo_path) }}" 
                             alt="{{ app(\App\Services\SeoService::class)->generateAltText($umkm, 'logo') }}" 
                             class="h-full w-full object-cover">
                        @else
                        <div class="flex flex-col items-center justify-center">
                            <span class="text-7xl" role="img" aria-label="Ikon usaha">
                                {{ app(\App\Services\SeoService::class)->generatePlaceholder($umkm) }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h1 class="mb-4 font-display text-4xl font-semibold text-[#141712]">{{ $umkm->nama_usaha }}</h1>
                        <div class="flex flex-wrap gap-3 mb-4">
                            <span class="inline-flex items-center gap-2 border border-[#ded6c6] bg-[#fbfaf7] px-4 py-2 font-semibold text-[#657066]">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100 4v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2a2 2 0 100-4V6z"/>
                                </svg>
                                {{ $umkm->category->nama_kategori }}
                            </span>
                            <span class="inline-flex items-center gap-2 border border-[#ded6c6] bg-[#fbfaf7] px-4 py-2 font-semibold text-[#657066]">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                {{ $umkm->district->nama_kecamatan }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-8 border border-[#ded6c6] bg-white p-6 sm:p-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="flex items-center gap-2 text-2xl font-semibold text-[#141712]">
                        <svg class="w-6 h-6 text-[#d4a945]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tentang Usaha
                    </h2>
                    <!-- Social Sharing -->
                    <div class="flex items-center gap-2">
                        <span class="mr-2 text-sm text-[#657066]">Bagikan:</span>
                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                           target="_blank"
                           class="flex h-10 w-10 items-center justify-center bg-[#10130f] transition-colors hover:bg-[#222820]"
                           title="Bagikan ke Facebook">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <!-- Twitter -->
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($umkm->nama_usaha . ' - ' . $umkm->category->nama_kategori) }}" 
                           target="_blank"
                           class="flex h-10 w-10 items-center justify-center bg-[#2f9e8f] transition-colors hover:bg-[#1d675d]"
                           title="Bagikan ke Twitter">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <!-- WhatsApp -->
                        <a href="https://wa.me/?text={{ urlencode($umkm->nama_usaha . ' - ' . url()->current()) }}" 
                           target="_blank"
                           class="flex h-10 w-10 items-center justify-center bg-[#2f9e8f] transition-colors hover:bg-[#1d675d]"
                           title="Bagikan via WhatsApp">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                        <!-- Copy Link -->
                        <button onclick="copyToClipboard('{{ url()->current() }}')" 
                                class="flex h-10 w-10 items-center justify-center border border-[#ded6c6] bg-[#fbfaf7] transition-colors hover:border-[#2f9e8f]"
                                title="Salin Link">
                            <svg class="w-5 h-5 text-[#657066]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <p class="whitespace-pre-line text-lg leading-relaxed text-[#545d55]">{{ $umkm->deskripsi }}</p>
            </div>
            
            @push('scripts')
            <script>
                function copyToClipboard(text) {
                    navigator.clipboard.writeText(text).then(function() {
                        alert('Link berhasil disalin!');
                    }, function(err) {
                        console.error('Could not copy text: ', err);
                    });
                }
            </script>
            @endpush

            <!-- Photo Gallery -->
            @if($umkm->photos && count($umkm->photos) > 0)
            <div class="mb-8 border border-[#ded6c6] bg-white p-6 sm:p-8">
                <h2 class="mb-6 flex items-center gap-2 text-2xl font-semibold text-[#141712]">
                    <svg class="w-6 h-6 text-[#d4a945]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Galeri Foto
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach(array_slice($umkm->photos, 0, 3) as $index => $photo)
                    <div class="relative group overflow-hidden">
                        <img src="{{ Storage::url($photo) }}" 
                             alt="{{ app(\App\Services\SeoService::class)->generateAltText($umkm, 'photo', $index) }}" 
                             class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Location Map -->
            @if($umkm->latitude && $umkm->longitude)
            <div class="mb-8 border border-[#ded6c6] bg-white p-6 sm:p-8">
                <h2 class="mb-6 flex items-center gap-2 text-2xl font-semibold text-[#141712]">
                    <svg class="w-6 h-6 text-[#d4a945]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Lokasi Usaha
                </h2>
                <div class="space-y-4">
                    @if($umkm->alamat_lengkap)
                    <div class="flex items-start gap-3 text-[#545d55]">
                        <svg class="w-5 h-5 text-[#d4a945] mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="leading-relaxed">{{ $umkm->alamat_lengkap }}</p>
                    </div>
                    @endif
                    
                    <div class="border border-[#ded6c6] bg-[#fbfaf7] p-4">
                        <div class="mb-4 aspect-video overflow-hidden bg-[#ebe4d7]">
                            <iframe 
                                width="100%" 
                                height="100%" 
                                frameborder="0" 
                                scrolling="no" 
                                marginheight="0" 
                                marginwidth="0" 
                                src="https://www.openstreetmap.org/export/embed.html?bbox={{ $umkm->longitude - 0.01 }}%2C{{ $umkm->latitude - 0.01 }}%2C{{ $umkm->longitude + 0.01 }}%2C{{ $umkm->latitude + 0.01 }}&layer=mapnik&marker={{ $umkm->latitude }}%2C{{ $umkm->longitude }}"
                                style="border: 0"
                                allowfullscreen
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        <a href="https://www.google.com/maps?q={{ $umkm->latitude }},{{ $umkm->longitude }}" 
                           target="_blank"
                           class="inline-flex items-center gap-2 bg-[#10130f] px-6 py-3 font-semibold text-white transition-all hover:bg-[#222820]">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            Buka di Google Maps
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="mb-8 border border-[#ded6c6] bg-white p-6 sm:p-8">
                <h2 class="mb-4 flex items-center gap-2 text-2xl font-semibold text-[#141712]">
                    <svg class="w-6 h-6 text-[#a89985]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Lokasi Usaha
                </h2>
                <div class="flex items-center gap-3 border border-[#ded6c6] bg-[#fbfaf7] p-4 text-[#657066]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p>Lokasi belum ditambahkan oleh pemilik usaha</p>
                </div>
            </div>
            @endif

            <!-- Contact -->
            <div class="mb-8 border border-[#d4a945]/35 bg-[#10130f] p-6 text-white sm:p-8">
                <h2 class="mb-6 flex items-center gap-2 text-2xl font-semibold text-white">
                    <svg class="w-6 h-6 text-[#d4a945]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Hubungi Kami
                </h2>
                <p class="mb-6 text-white/70">Tertarik dengan produk atau layanan kami? Hubungi kami langsung melalui WhatsApp.</p>
                <a href="{{ $umkm->whatsapp_link }}" target="_blank" 
                   class="inline-flex items-center gap-3 bg-[#2f9e8f] px-8 py-4 text-lg font-bold text-white transition-all hover:bg-[#1d675d]">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Chat via WhatsApp
                </a>
            </div>
            
            <!-- Related UMKM -->
            @if($relatedUmkm->count() > 0)
            <div class="mb-8 border border-[#ded6c6] bg-white p-6 sm:p-8">
                <h2 class="mb-6 flex items-center gap-2 text-2xl font-semibold text-[#141712]">
                    <svg class="w-6 h-6 text-[#d4a945]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    UMKM Sejenis
                </h2>
                <p class="mb-6 text-[#657066]">Jelajahi UMKM lainnya yang mungkin Anda minati</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedUmkm as $related)
                    <a href="{{ route('umkm.show', $related->slug) }}" class="group overflow-hidden border border-[#ded6c6] bg-[#fbfaf7] transition-all hover:border-[#2f9e8f]">
                        <div class="flex aspect-video items-center justify-center overflow-hidden bg-[#ebe4d7]">
                            @if($related->logo_path)
                            <img src="{{ Storage::url($related->logo_path) }}" 
                                 alt="{{ app(\App\Services\SeoService::class)->generateAltText($related, 'logo') }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                            <span class="font-display text-4xl font-semibold text-[#d4a945]" aria-label="Ikon toko">{{ strtoupper(mb_substr($related->nama_usaha, 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="mb-2 line-clamp-1 font-bold text-[#141712] transition-colors group-hover:text-[#2f9e8f]">
                                {{ $related->nama_usaha }}
                            </h3>
                            <div class="flex flex-wrap gap-2 mb-2">
                                <span class="bg-[#fff8df] px-2 py-1 text-xs text-[#a57924]">
                                    {{ $related->category->nama_kategori }}
                                </span>
                                <span class="bg-[#e7f7f4] px-2 py-1 text-xs text-[#1d675d]">
                                    {{ $related->district->nama_kecamatan }}
                                </span>
                            </div>
                            <p class="line-clamp-2 text-sm text-[#657066]">
                                {{ Str::limit(strip_tags($related->deskripsi), 80) }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            
            <!-- Nearby UMKM Map -->
            @if($umkm->latitude && $umkm->longitude && $relatedUmkm->where('latitude', '!=', null)->count() > 0)
            <div class="border border-[#ded6c6] bg-white p-6 sm:p-8">
                <h2 class="mb-6 flex items-center gap-2 text-2xl font-semibold text-[#141712]">
                    <svg class="w-6 h-6 text-[#d4a945]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    UMKM Terdekat
                </h2>
                <p class="mb-6 text-[#657066]">Lihat lokasi UMKM sejenis di sekitar area ini</p>
                
                <!-- Map Container -->
                <div id="nearby-map" class="h-96 w-full border border-[#ded6c6]"></div>
                
                <!-- Leaflet CSS -->
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                
                <!-- Leaflet JS -->
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Initialize map centered on current UMKM
                        const map = L.map('nearby-map').setView([{{ $umkm->latitude }}, {{ $umkm->longitude }}], 14);
                        
                        // Add tile layer
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                            maxZoom: 19
                        }).addTo(map);
                        
                        // Custom icon for current UMKM (gold)
                        const currentIcon = L.divIcon({
                            className: 'custom-marker',
                            html: '<div style="background-color: #D4AF37; width: 40px; height: 40px; border-radius: 50%; border: 4px solid white; box-shadow: 0 3px 10px rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center;"><svg style="width: 20px; height: 20px; color: white;" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg></div>',
                            iconSize: [40, 40],
                            iconAnchor: [20, 20]
                        });
                        
                        // Add marker for current UMKM
                        const currentMarker = L.marker([{{ $umkm->latitude }}, {{ $umkm->longitude }}], { icon: currentIcon });
                        currentMarker.bindPopup(`
                            <div class="p-2" style="min-width: 200px;">
                                <h4 class="font-bold text-lg mb-2">{{ $umkm->nama_usaha }}</h4>
                                <p class="text-sm text-gray-600 mb-1">
                                    <strong>Kategori:</strong> {{ $umkm->category->nama_kategori }}
                                </p>
                                <p class="text-sm text-gray-600 mb-2">
                                    <strong>Kecamatan:</strong> {{ $umkm->district->nama_kecamatan }}
                                </p>
                                <span class="inline-block bg-[#fff8df] px-2 py-1 text-xs font-semibold text-[#a57924]">
                                    📍 Lokasi Saat Ini
                                </span>
                            </div>
                        `);
                        currentMarker.addTo(map);
                        
                        // Custom icon for nearby UMKM (blue)
                        const nearbyIcon = L.divIcon({
                            className: 'custom-marker',
                            html: '<div style="background-color: #3B82F6; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
                            iconSize: [30, 30],
                            iconAnchor: [15, 15]
                        });
                        
                        // Add markers for nearby UMKM
                        const nearbyUmkm = @json($relatedUmkm->where('latitude', '!=', null)->values());
                        
                        nearbyUmkm.forEach(umkm => {
                            if (umkm.latitude && umkm.longitude) {
                                const marker = L.marker([umkm.latitude, umkm.longitude], { icon: nearbyIcon });
                                
                                marker.bindPopup(`
                                    <div class="p-2" style="min-width: 200px;">
                                        <h4 class="font-bold text-lg mb-2">${umkm.nama_usaha}</h4>
                                        <p class="text-sm text-gray-600 mb-1">
                                            <strong>Kategori:</strong> ${umkm.category.nama_kategori}
                                        </p>
                                        <p class="text-sm text-gray-600 mb-3">
                                            <strong>Kecamatan:</strong> ${umkm.district.nama_kecamatan}
                                        </p>
                                        <a href="/umkm/${umkm.slug}" 
                                           class="inline-block bg-[#10130f] px-3 py-1 text-sm text-white transition-colors hover:bg-[#222820]">
                                            Lihat Detail
                                        </a>
                                    </div>
                                `);
                                
                                marker.addTo(map);
                            }
                        });
                        
                        // Fit bounds to show all markers
                        const allMarkers = [currentMarker];
                        nearbyUmkm.forEach(umkm => {
                            if (umkm.latitude && umkm.longitude) {
                                allMarkers.push(L.marker([umkm.latitude, umkm.longitude]));
                            }
                        });
                        
                        if (allMarkers.length > 1) {
                            const group = L.featureGroup(allMarkers);
                            map.fitBounds(group.getBounds().pad(0.1));
                        }
                    });
                </script>
            </div>
            @endif
            @endif
        </div>
    </div>
</x-guest-layout>
