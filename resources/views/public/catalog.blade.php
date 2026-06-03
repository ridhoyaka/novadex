<x-guest-layout>
    <div class="bg-arsa-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <!-- Header -->
            <div class="text-center mb-12 sm:mb-16">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-white mb-4">Katalog UMKM</h1>
                <div class="w-20 h-1 bg-gold-500 mx-auto mb-6 rounded-full"></div>
                <p class="text-base sm:text-lg text-gray-400">Temukan dan hubungi bisnis lokal pilihan Anda</p>
                
                <!-- View Toggle -->
                <div class="mt-8 inline-flex items-center bg-arsa-800 border border-arsa-700 rounded-xl p-1">
                    <button onclick="switchView('list')" id="listViewBtn" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gold-500 text-black font-bold rounded-lg text-sm transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        List
                    </button>
                    <button onclick="switchView('map')" id="mapViewBtn" class="inline-flex items-center gap-2 px-5 py-2.5 text-gray-400 font-bold rounded-lg text-sm hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        Peta
                    </button>
                </div>
            </div>

            <!-- List View Container -->
            <div id="listView">
            <!-- Filters -->
            <form method="GET" class="bg-arsa-800 border border-arsa-800 p-6 sm:p-8 rounded-xl mb-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 sm:gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-300 mb-2 tracking-wider">CARI NAMA USAHA</label>
                        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" 
                               placeholder="Ketik nama usaha atau deskripsi..." 
                               class="w-full px-4 py-3 bg-arsa-700 border border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2 tracking-wider">KATEGORI</label>
                        <select name="category" class="w-full px-4 py-3 bg-arsa-700 border border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ ($filters['category'] ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-2 tracking-wider">KECAMATAN</label>
                        <select name="district" class="w-full px-4 py-3 bg-arsa-700 border border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                            <option value="">Semua Kecamatan</option>
                            @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ ($filters['district'] ?? '') == $district->id ? 'selected' : '' }}>
                                {{ $district->nama_kecamatan }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex flex-col md:flex-row gap-3 items-start md:items-center justify-between">
                    <div class="flex gap-3 w-full md:w-auto">
                        <button type="submit" class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-gold-500 to-gold-500 rounded-lg font-bold text-sm text-black hover:from-gold-600 hover:to-gold-700 transition-all shadow-sm">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('umkm.index') }}" class="flex-1 md:flex-none inline-flex items-center justify-center px-6 py-3 bg-arsa-800 border border-arsa-700 rounded-lg font-bold text-sm text-gray-300 hover:text-white hover:border-gold-500/50 transition-all text-center">
                            Reset
                        </a>
                    </div>
                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <label class="text-sm font-bold text-gray-300 tracking-wider whitespace-nowrap">URUTKAN:</label>
                        <select name="sort" onchange="this.form.submit()" class="flex-1 md:flex-none px-4 py-3 bg-arsa-700 border border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                            <option value="newest" {{ ($filters['sort'] ?? 'newest') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ ($filters['sort'] ?? '') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="name_asc" {{ ($filters['sort'] ?? '') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                            <option value="name_desc" {{ ($filters['sort'] ?? '') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                            <option value="completion" {{ ($filters['sort'] ?? '') == 'completion' ? 'selected' : '' }}>Profil Terlengkap</option>
                        </select>
                    </div>
                </div>
            </form>

            <!-- Results -->
            @if($umkms->count() > 0)
            <!-- Active Filters Display -->
            @if(!empty($filters['search']) || !empty($filters['category']) || !empty($filters['district']))
            <div class="mb-6 flex flex-wrap items-center gap-3">
                <span class="text-sm font-bold text-gray-400">FILTER AKTIF:</span>
                @if(!empty($filters['search']))
                <span class="inline-flex items-center gap-2 bg-gold-500/20 border border-gold-500/30 text-gold-300 px-3 py-1 rounded-lg text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    "{{ $filters['search'] }}"
                    <a href="{{ route('umkm.index', array_merge($filters, ['search' => ''])) }}" class="hover:text-gold-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                </span>
                @endif
                @if(!empty($filters['category']))
                <span class="inline-flex items-center gap-2 bg-blue-500/20 border border-blue-500/30 text-blue-300 px-3 py-1 rounded-lg text-sm">
                    {{ $categories->find($filters['category'])->nama_kategori ?? 'Kategori' }}
                    <a href="{{ route('umkm.index', array_merge($filters, ['category' => ''])) }}" class="hover:text-blue-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                </span>
                @endif
                @if(!empty($filters['district']))
                <span class="inline-flex items-center gap-2 bg-green-500/20 border border-green-500/30 text-green-300 px-3 py-1 rounded-lg text-sm">
                    {{ $districts->find($filters['district'])->nama_kecamatan ?? 'Kecamatan' }}
                    <a href="{{ route('umkm.index', array_merge($filters, ['district' => ''])) }}" class="hover:text-green-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                </span>
                @endif
                <a href="{{ route('umkm.index') }}" class="text-sm text-gray-400 hover:text-gold-400 underline">
                    Hapus semua filter
                </a>
            </div>
            @endif
            
            <div class="mb-8 text-gray-400">
                Menampilkan <span class="font-bold text-white">{{ $umkms->total() }}</span> UMKM
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 mb-12">
                @foreach($umkms as $umkm)
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
                @endforeach
            </div>

            <div class="flex justify-center">
                {{ $umkms->links() }}
            </div>
            @else
            <div class="bg-arsa-800 border border-arsa-800 p-12 sm:p-16 rounded-xl text-center">
                <div class="text-6xl mb-6">🔍</div>
                <h3 class="text-2xl font-bold text-white mb-3">Tidak ada UMKM yang ditemukan</h3>
                <p class="text-gray-400 mb-8 max-w-md mx-auto">
                    @if(!empty($filters['search']) || !empty($filters['category']) || !empty($filters['district']))
                        Coba ubah atau hapus filter pencarian Anda untuk melihat lebih banyak hasil.
                    @else
                        Belum ada UMKM yang terdaftar di katalog.
                    @endif
                </p>
                
                @if(!empty($filters['search']) || !empty($filters['category']) || !empty($filters['district']))
                <div class="flex flex-col sm:flex-row gap-3 justify-center items-center">
                    <a href="{{ route('umkm.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-gold-500 to-gold-500 rounded-lg font-bold text-sm text-black hover:from-gold-600 hover:to-gold-700 transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Lihat Semua UMKM
                    </a>
                    <button onclick="window.history.back()" class="inline-flex items-center gap-2 px-6 py-3 bg-arsa-800 border border-arsa-700 rounded-lg font-bold text-sm text-gray-300 hover:text-white hover:border-gold-500/50 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </button>
                </div>
                
                @if($categories->count() > 0)
                <div class="mt-12 pt-8 border-t border-arsa-700">
                    <p class="text-sm font-bold text-gray-400 mb-4 tracking-wider">COBA KATEGORI POPULER:</p>
                    <div class="flex flex-wrap gap-3 justify-center">
                        @foreach($categories->take(5) as $category)
                        <a href="{{ route('umkm.index', ['category' => $category->id]) }}" 
                           class="px-4 py-2 bg-arsa-700 border border-arsa-700 rounded-lg text-gray-300 hover:border-gold-500/50 hover:text-gold-400 transition-all text-sm font-medium">
                            {{ $category->nama_kategori }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
                @endif
            </div>
            @endif
            </div>

            <!-- Map View Container -->
            <div id="mapView" class="hidden">
                <!-- Map Filters -->
                <form method="GET" class="bg-arsa-800 border border-arsa-800 p-6 rounded-xl mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2 tracking-wider">KATEGORI</label>
                            <select id="map_category_filter" class="w-full px-4 py-3 bg-arsa-700 border border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-2 tracking-wider">KECAMATAN</label>
                            <select id="map_district_filter" class="w-full px-4 py-3 bg-arsa-700 border border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                                <option value="">Semua Kecamatan</option>
                                @foreach($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->nama_kecamatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="button" onclick="applyMapFilters()" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-gold-500 to-gold-500 rounded-lg font-bold text-sm text-black hover:from-gold-600 hover:to-gold-700 transition-all shadow-sm">
                                Terapkan Filter
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Map Container -->
                <div class="bg-arsa-800 border border-arsa-800 rounded-xl overflow-hidden">
                    <div id="catalog_map" class="w-full bg-arsa-700" style="height: 600px;"></div>
                </div>

                <!-- Map Info -->
                <div class="mt-4 bg-arsa-800 border border-arsa-800 rounded-xl p-4">
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-gold-500 rounded-full"></div>
                            <span>UMKM dengan Lokasi</span>
                        </div>
                        <div class="ml-auto">
                            <span id="map_umkm_count" class="font-semibold text-white">0</span> UMKM ditampilkan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet MarkerCluster CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Leaflet MarkerCluster JS -->
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

    <script>
        let catalogMap;
        let markerClusterGroup;
        let allMarkers = [];

        // UMKM data from server
        const umkmData = @json($umkms->items());

        // Switch between list and map view
        function switchView(view) {
            const listView = document.getElementById('listView');
            const mapView = document.getElementById('mapView');
            const listBtn = document.getElementById('listViewBtn');
            const mapBtn = document.getElementById('mapViewBtn');

            const activeClasses = ['bg-gold-500', 'text-black'];
            const inactiveClasses = ['text-gray-400', 'hover:text-white'];

            if (view === 'list') {
                listView.classList.remove('hidden');
                mapView.classList.add('hidden');
                
                listBtn.classList.add(...activeClasses);
                listBtn.classList.remove(...inactiveClasses);
                mapBtn.classList.remove(...activeClasses);
                mapBtn.classList.add(...inactiveClasses);
                
                localStorage.setItem('catalogView', 'list');
            } else {
                listView.classList.add('hidden');
                mapView.classList.remove('hidden');
                
                mapBtn.classList.add(...activeClasses);
                mapBtn.classList.remove(...inactiveClasses);
                listBtn.classList.remove(...activeClasses);
                listBtn.classList.add(...inactiveClasses);
                
                if (!catalogMap) {
                    initCatalogMap();
                }
                
                localStorage.setItem('catalogView', 'map');
                
                setTimeout(() => {
                    if (catalogMap) {
                        catalogMap.invalidateSize();
                    }
                }, 100);
            }
        }

        // Initialize catalog map
        function initCatalogMap() {
            // Initialize the map centered on Salatiga
            catalogMap = L.map('catalog_map').setView([-7.3305, 110.5083], 13);

            // Add OpenStreetMap tiles
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(catalogMap);

            // Force recalculate size
            setTimeout(function() { catalogMap.invalidateSize(); }, 200);

            // Initialize marker cluster group
            markerClusterGroup = L.markerClusterGroup({
                maxClusterRadius: 50,
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: false,
                zoomToBoundsOnClick: true
            });

            // Custom marker icon
            const goldIcon = L.divIcon({
                className: 'custom-marker',
                html: '<div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); width: 30px; height: 30px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 3px solid white; box-shadow: 0 4px 6px rgba(0,0,0,0.3);"><div style="transform: rotate(45deg); margin-top: 3px; margin-left: 3px; font-size: 16px;">🏪</div></div>',
                iconSize: [30, 30],
                iconAnchor: [15, 30],
                popupAnchor: [0, -30]
            });

            // Add markers for UMKM with location
            let umkmWithLocation = 0;
            umkmData.forEach(umkm => {
                if (umkm.latitude && umkm.longitude) {
                    umkmWithLocation++;
                    
                    const marker = L.marker([umkm.latitude, umkm.longitude], {
                        icon: goldIcon
                    });

                    const logoHtml = umkm.logo_path 
                        ? `<img src="/storage/${umkm.logo_path}" alt="${umkm.nama_usaha}" class="w-16 h-16 object-cover rounded-lg mb-2 mx-auto">`
                        : '<div class="text-4xl mb-2">🏪</div>';

                    marker.bindPopup(`
                        <div class="text-center p-2">
                            ${logoHtml}
                            <h3 class="font-bold text-lg mb-1">${umkm.nama_usaha}</h3>
                            <p class="text-sm text-gray-600 mb-1">${umkm.category.nama_kategori}</p>
                            <p class="text-xs text-gray-500 mb-3">📍 ${umkm.district.nama_kecamatan}</p>
                            <a href="/umkm/${umkm.slug}" class="inline-block bg-gradient-to-r from-yellow-500 to-yellow-600 text-black px-4 py-2 rounded-lg text-sm font-bold hover:from-yellow-600 hover:to-yellow-700 transition-all">
                                Lihat Detail
                            </a>
                        </div>
                    `, {
                        maxWidth: 250,
                        className: 'custom-popup'
                    });

                    // Store marker with metadata for filtering
                    marker.umkmData = {
                        id: umkm.id,
                        category_id: umkm.kategori_id,
                        district_id: umkm.kecamatan_id
                    };

                    allMarkers.push(marker);
                    markerClusterGroup.addLayer(marker);
                }
            });

            catalogMap.addLayer(markerClusterGroup);

            // Update count
            document.getElementById('map_umkm_count').textContent = umkmWithLocation;

            // Add custom CSS for popup
            const style = document.createElement('style');
            style.textContent = `
                .custom-popup .leaflet-popup-content-wrapper {
                    background: white;
                    border-radius: 12px;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
                }
                .custom-popup .leaflet-popup-tip {
                    background: white;
                }
                .marker-cluster-small {
                    background-color: rgba(245, 158, 11, 0.6);
                }
                .marker-cluster-small div {
                    background-color: rgba(245, 158, 11, 0.8);
                    color: white;
                    font-weight: bold;
                }
                .marker-cluster-medium {
                    background-color: rgba(245, 158, 11, 0.6);
                }
                .marker-cluster-medium div {
                    background-color: rgba(245, 158, 11, 0.9);
                    color: white;
                    font-weight: bold;
                }
                .marker-cluster-large {
                    background-color: rgba(245, 158, 11, 0.6);
                }
                .marker-cluster-large div {
                    background-color: rgba(245, 158, 11, 1);
                    color: white;
                    font-weight: bold;
                }
            `;
            document.head.appendChild(style);
        }

        // Apply map filters
        function applyMapFilters() {
            const categoryId = document.getElementById('map_category_filter').value;
            const districtId = document.getElementById('map_district_filter').value;

            // Clear existing markers
            markerClusterGroup.clearLayers();

            // Filter and add markers
            let visibleCount = 0;
            allMarkers.forEach(marker => {
                const data = marker.umkmData;
                const categoryMatch = !categoryId || data.category_id == categoryId;
                const districtMatch = !districtId || data.district_id == districtId;

                if (categoryMatch && districtMatch) {
                    markerClusterGroup.addLayer(marker);
                    visibleCount++;
                }
            });

            // Update count
            document.getElementById('map_umkm_count').textContent = visibleCount;

            // Fit bounds to visible markers if any
            if (visibleCount > 0) {
                catalogMap.fitBounds(markerClusterGroup.getBounds(), { padding: [50, 50] });
            }
        }

        // Load saved view preference on page load
        document.addEventListener('DOMContentLoaded', function() {
            const savedView = localStorage.getItem('catalogView');
            if (savedView === 'map') {
                switchView('map');
            }
        });
    </script>
</x-guest-layout>
