<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                Peta Sebaran UMKM
            </h2>
            <a href="{{ route('admin.content.index') }}" class="text-arsa-300 hover:text-white transition-colors">
                ← Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-6 lg:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-arsa-400 text-sm">Total UMKM</p>
                            <p class="text-white text-2xl font-bold">{{ $stats['total_umkm'] }}</p>
                        </div>
                        <div class="bg-blue-900/30 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-arsa-400 text-sm">Dengan Lokasi</p>
                            <p class="text-white text-2xl font-bold">{{ $stats['with_location'] }}</p>
                            <p class="text-green-400 text-xs">{{ $stats['total_umkm'] > 0 ? round(($stats['with_location'] / $stats['total_umkm']) * 100, 1) : 0 }}%</p>
                        </div>
                        <div class="bg-green-900/30 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-arsa-400 text-sm">Tanpa Lokasi</p>
                            <p class="text-white text-2xl font-bold">{{ $stats['without_location'] }}</p>
                            <p class="text-red-400 text-xs">{{ $stats['total_umkm'] > 0 ? round(($stats['without_location'] / $stats['total_umkm']) * 100, 1) : 0 }}%</p>
                        </div>
                        <div class="bg-red-900/30 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-arsa-400 text-sm">Dipublikasi</p>
                            <p class="text-white text-2xl font-bold">{{ $stats['published_with_location'] }}</p>
                            <p class="text-gold-400 text-xs">Dengan lokasi</p>
                        </div>
                        <div class="bg-gold-900/30 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-4 mb-6">
                <form method="GET" action="{{ route('admin.content.map') }}" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm text-arsa-300 mb-1">Kategori</label>
                        <select name="category" class="w-full rounded-md bg-arsa-800 border-arsa-700 text-white text-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm text-arsa-300 mb-1">Kecamatan</label>
                        <select name="district" class="w-full rounded-md bg-arsa-800 border-arsa-700 text-white text-sm">
                            <option value="">Semua Kecamatan</option>
                            @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ request('district') == $district->id ? 'selected' : '' }}>
                                {{ $district->nama_kecamatan }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm text-arsa-300 mb-1">Status</label>
                        <select name="status" class="w-full rounded-md bg-arsa-800 border-arsa-700 text-white text-sm">
                            <option value="">Semua Status</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Dipublikasi</option>
                            <option value="unpublished" {{ request('status') == 'unpublished' ? 'selected' : '' }}>Belum Dipublikasi</option>
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="bg-gold-600 text-arsa-900 px-4 py-2 rounded-md hover:bg-gold-700 font-medium transition-colors">
                            Filter
                        </button>
                        <a href="{{ route('admin.content.map') }}" class="bg-arsa-800 text-arsa-300 px-4 py-2 rounded-md hover:bg-arsa-700 transition-colors">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Map Container -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-lg overflow-hidden">
                <div class="p-4 border-b border-arsa-800 flex items-center justify-between">
                    <h3 class="text-white font-semibold">Peta Lokasi UMKM</h3>
                    <button onclick="exportMapAsImage()" class="text-gold-400 hover:text-gold-300 text-sm transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export Gambar
                    </button>
                </div>
                <div id="umkm-map" class="w-full h-[600px]"></div>
            </div>

            <!-- Coverage by District -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-lg p-6 mt-6">
                <h3 class="text-white font-semibold mb-4">Cakupan per Kecamatan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($coverageByDistrict as $district)
                    <div class="bg-arsa-800 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-white font-medium">{{ $district->nama_kecamatan }}</h4>
                            <span class="text-arsa-400 text-sm">{{ $district->umkm_profiles_count }} UMKM</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="flex-1 bg-arsa-700 rounded-full h-2">
                                <div class="bg-gold-500 h-2 rounded-full" style="width: {{ $district->umkm_profiles_count > 0 ? ($district->with_location_count / $district->umkm_profiles_count) * 100 : 0 }}%"></div>
                            </div>
                            <span class="text-gold-400 text-sm font-medium">
                                {{ $district->with_location_count }}/{{ $district->umkm_profiles_count }}
                            </span>
                        </div>
                        <p class="text-arsa-400 text-xs mt-1">
                            {{ $district->umkm_profiles_count > 0 ? round(($district->with_location_count / $district->umkm_profiles_count) * 100, 1) : 0 }}% dengan lokasi
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        // Initialize map
        const map = L.map('umkm-map').setView([-7.5616, 110.5084], 13);

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);

        // Create marker cluster group
        const markers = L.markerClusterGroup({
            maxClusterRadius: 50,
            spiderfyOnMaxZoom: true,
            showCoverageOnHover: false,
            zoomToBoundsOnClick: true
        });

        // Category colors
        const categoryColors = {
            @foreach($categories as $category)
            '{{ $category->id }}': '{{ sprintf("#%06X", mt_rand(0, 0xFFFFFF)) }}',
            @endforeach
        };

        // Add markers
        const umkmData = @json($umkmWithLocation);
        
        umkmData.forEach(umkm => {
            const categoryColor = categoryColors[umkm.kategori_id] || '#D4AF37';
            
            // Create custom icon
            const icon = L.divIcon({
                className: 'custom-marker',
                html: `<div style="background-color: ${categoryColor}; width: 30px; height: 30px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>`,
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            });

            const marker = L.marker([umkm.latitude, umkm.longitude], { icon: icon });
            
            // Create popup content
            const popupContent = `
                <div class="p-2" style="min-width: 200px;">
                    <h4 class="font-bold text-lg mb-2">${umkm.nama_usaha}</h4>
                    <p class="text-sm text-gray-600 mb-1">
                        <strong>Kategori:</strong> ${umkm.category ? umkm.category.nama_kategori : '-'}
                    </p>
                    <p class="text-sm text-gray-600 mb-1">
                        <strong>Kecamatan:</strong> ${umkm.district ? umkm.district.nama_kecamatan : '-'}
                    </p>
                    <p class="text-sm text-gray-600 mb-3">
                        <strong>Status:</strong> 
                        <span class="${umkm.is_published ? 'text-green-600' : 'text-red-600'} font-medium">
                            ${umkm.is_published ? 'Dipublikasi' : 'Belum Dipublikasi'}
                        </span>
                    </p>
                    <a href="/admin/content/${umkm.id}" 
                       class="inline-block bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition-colors">
                        Lihat Detail
                    </a>
                </div>
            `;
            
            marker.bindPopup(popupContent);
            markers.addLayer(marker);
        });

        map.addLayer(markers);

        // Fit bounds to show all markers
        if (umkmData.length > 0) {
            map.fitBounds(markers.getBounds(), { padding: [50, 50] });
        }

        // Export map as image
        function exportMapAsImage() {
            const mapElement = document.getElementById('umkm-map');
            
            html2canvas(mapElement, {
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#1a1a2e'
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = `peta-umkm-${new Date().toISOString().split('T')[0]}.png`;
                link.href = canvas.toDataURL();
                link.click();
            });
        }
    </script>
</x-app-layout>
