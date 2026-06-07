<x-guest-layout>
    <div class="min-h-screen bg-[#f6f2e8]">
        <section class="border-b border-[#ddd5c6] bg-[#10130f] py-12 text-white sm:py-14">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#d4a945]">Katalog UMKM</p>
                        <h1 class="mt-4 font-display text-4xl font-semibold leading-tight sm:text-5xl">Cari usaha lokal dengan tampilan yang lebih rapi.</h1>
                        <p class="mt-5 max-w-2xl text-base leading-7 text-white/70">Filter nama usaha, kategori, dan kecamatan tanpa kehilangan konteks hasil.</p>
                    </div>

                    <div class="inline-flex w-full border border-white/10 bg-white/[0.06] p-1 sm:w-auto">
                        <button onclick="switchView('list')" id="listViewBtn" class="inline-flex min-h-10 flex-1 items-center justify-center gap-2 bg-[#d4a945] px-4 text-sm font-semibold text-[#10130f] transition sm:flex-none">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            List
                        </button>
                        <button onclick="switchView('map')" id="mapViewBtn" class="inline-flex min-h-10 flex-1 items-center justify-center gap-2 px-4 text-sm font-semibold text-white/70 transition hover:text-white sm:flex-none">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            Peta
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
            <div id="listView">
                <form method="GET" class="border border-[#ded6c6] bg-white p-4 sm:p-5">
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-[1.4fr_0.85fr_0.85fr]">
                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-[#756b5b]">Cari Nama Usaha</label>
                            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nama usaha atau deskripsi" class="w-full border-[#d8cebd] bg-[#fbfaf7] px-4 py-3 text-[#141712] placeholder-[#9c9282] focus:border-[#2f9e8f] focus:ring-[#2f9e8f]">
                        </div>
                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-[#756b5b]">KATEGORI</label>
                            <select name="category" class="w-full border-[#d8cebd] bg-[#fbfaf7] px-4 py-3 text-[#141712] focus:border-[#2f9e8f] focus:ring-[#2f9e8f]">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ ($filters['category'] ?? '') == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-[#756b5b]">Kecamatan</label>
                            <select name="district" class="w-full border-[#d8cebd] bg-[#fbfaf7] px-4 py-3 text-[#141712] focus:border-[#2f9e8f] focus:ring-[#2f9e8f]">
                                <option value="">Semua Kecamatan</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}" {{ ($filters['district'] ?? '') == $district->id ? 'selected' : '' }}>{{ $district->nama_kecamatan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-col gap-3 border-t border-[#ede6da] pt-4 md:flex-row md:items-center md:justify-between">
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <button type="submit" class="inline-flex min-h-11 items-center justify-center bg-[#d4a945] px-5 text-sm font-semibold text-[#14130f] transition hover:bg-[#e2bd62]">
                                Terapkan Filter
                            </button>
                            <a href="{{ route('umkm.index') }}" class="inline-flex min-h-11 items-center justify-center border border-[#cfc5b4] px-5 text-sm font-semibold text-[#3a3f39] transition hover:border-[#141712] hover:text-[#141712]">
                                Reset
                            </a>
                        </div>

                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                            <label class="text-xs font-semibold uppercase tracking-[0.16em] text-[#756b5b]">Urutkan</label>
                            <select name="sort" onchange="this.form.submit()" class="min-h-11 border-[#d8cebd] bg-[#fbfaf7] px-4 text-[#141712] focus:border-[#2f9e8f] focus:ring-[#2f9e8f]">
                                <option value="newest" {{ ($filters['sort'] ?? 'newest') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ ($filters['sort'] ?? '') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="name_asc" {{ ($filters['sort'] ?? '') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="name_desc" {{ ($filters['sort'] ?? '') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                                <option value="completion" {{ ($filters['sort'] ?? '') == 'completion' ? 'selected' : '' }}>Profil Terlengkap</option>
                            </select>
                        </div>
                    </div>
                </form>

                @if($umkms->count() > 0)
                    @if(!empty($filters['search']) || !empty($filters['category']) || !empty($filters['district']))
                        <div class="mt-6 flex flex-wrap items-center gap-2">
                            <span class="text-xs font-semibold uppercase tracking-[0.16em] text-[#756b5b]">FILTER AKTIF:</span>
                            @if(!empty($filters['search']))
                                <span class="inline-flex items-center gap-2 border border-[#d4a945]/40 bg-[#fff8df] px-3 py-1 text-sm text-[#7d5c18]">"{{ $filters['search'] }}"</span>
                            @endif
                            @if(!empty($filters['category']))
                                <span class="inline-flex items-center gap-2 border border-[#2f9e8f]/30 bg-[#e7f7f4] px-3 py-1 text-sm text-[#1d675d]">{{ $categories->find($filters['category'])->nama_kategori ?? 'Kategori' }}</span>
                            @endif
                            @if(!empty($filters['district']))
                                <span class="inline-flex items-center gap-2 border border-[#2f9e8f]/30 bg-[#e7f7f4] px-3 py-1 text-sm text-[#1d675d]">{{ $districts->find($filters['district'])->nama_kecamatan ?? 'Kecamatan' }}</span>
                            @endif
                            <a href="{{ route('umkm.index') }}" class="text-sm font-semibold text-[#141712] underline decoration-[#d4a945] underline-offset-4">Hapus semua</a>
                        </div>
                    @endif

                    <div class="mt-7 flex items-center justify-between gap-4">
                        <p class="text-sm text-[#657066]">Menampilkan <span class="font-semibold text-[#141712]">{{ $umkms->total() }}</span> UMKM</p>
                    </div>

                    <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($umkms as $umkm)
                            <a href="{{ route('umkm.show', $umkm->slug) }}" class="group overflow-hidden border border-[#ded6c6] bg-white transition hover:-translate-y-0.5 hover:border-[#2f9e8f] hover:shadow-[0_16px_38px_rgba(20,23,18,0.08)]">
                                <div class="aspect-[4/3] bg-[#ebe4d7]">
                                    @if($umkm->logo_path)
                                        <img src="{{ Storage::url($umkm->logo_path) }}" alt="{{ $umkm->nama_usaha }}" class="h-full w-full object-cover" loading="lazy">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-[#10130f]">
                                            <span class="font-display text-4xl font-semibold text-[#d4a945]">{{ strtoupper(mb_substr($umkm->nama_usaha, 0, 2)) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <div class="flex items-center justify-between gap-3">
                                        @if(optional($umkm->category)->nama_kategori)
                                            <span class="truncate text-xs font-semibold uppercase tracking-[0.16em] text-[#a57924]">{{ $umkm->category->nama_kategori }}</span>
                                        @endif
                                        @if(optional($umkm->district)->nama_kecamatan)
                                            <span class="truncate text-xs text-[#657066]">{{ $umkm->district->nama_kecamatan }}</span>
                                        @endif
                                    </div>
                                    <h3 class="mt-3 text-lg font-semibold text-[#141712] group-hover:text-[#2f9e8f]">{{ $umkm->nama_usaha }}</h3>
                                    <span class="mt-4 inline-flex text-sm font-semibold text-[#141712] group-hover:text-[#2f9e8f]">Lihat detail</span>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-10 flex justify-center">
                        {{ $umkms->links() }}
                    </div>
                @else
                    <div class="mt-8 border border-[#ded6c6] bg-white p-10 text-center">
                        <h3 class="text-2xl font-semibold text-[#141712]">Tidak ada UMKM yang ditemukan</h3>
                        <p class="mx-auto mt-3 max-w-md text-[#657066]">
                            @if(!empty($filters['search']) || !empty($filters['category']) || !empty($filters['district']))
                                Coba ubah atau hapus filter pencarian untuk melihat lebih banyak hasil.
                            @else
                                Belum ada UMKM yang terdaftar di katalog.
                            @endif
                        </p>
                        <a href="{{ route('umkm.index') }}" class="mt-8 inline-flex min-h-11 items-center justify-center bg-[#d4a945] px-6 text-sm font-semibold text-[#14130f] transition hover:bg-[#e2bd62]">
                            Lihat Semua UMKM
                        </a>
                    </div>
                @endif
            </div>

            <div id="mapView" class="hidden">
                <form method="GET" class="mb-6 border border-[#ded6c6] bg-white p-4 sm:p-5">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-[1fr_1fr_auto]">
                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-[#756b5b]">Kategori</label>
                            <select id="map_category_filter" class="w-full border-[#d8cebd] bg-[#fbfaf7] px-4 py-3 text-[#141712] focus:border-[#2f9e8f] focus:ring-[#2f9e8f]">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="mb-2 block text-xs font-semibold uppercase tracking-[0.16em] text-[#756b5b]">Kecamatan</label>
                            <select id="map_district_filter" class="w-full border-[#d8cebd] bg-[#fbfaf7] px-4 py-3 text-[#141712] focus:border-[#2f9e8f] focus:ring-[#2f9e8f]">
                                <option value="">Semua Kecamatan</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->nama_kecamatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="button" onclick="applyMapFilters()" class="inline-flex min-h-11 w-full items-center justify-center bg-[#d4a945] px-5 text-sm font-semibold text-[#14130f] transition hover:bg-[#e2bd62] md:w-auto">
                                Terapkan Filter
                            </button>
                        </div>
                    </div>
                </form>

                <div class="overflow-hidden border border-[#ded6c6] bg-white">
                    <div id="catalog_map" class="w-full bg-[#ebe4d7]" style="height: 600px;"></div>
                </div>

                <div class="mt-4 border border-[#ded6c6] bg-white p-4">
                    <div class="flex flex-wrap items-center gap-4 text-sm text-[#657066]">
                        <div class="flex items-center gap-2">
                            <div class="h-3 w-3 bg-[#d4a945]"></div>
                            <span>UMKM dengan lokasi</span>
                        </div>
                        <div class="ml-auto">
                            <span id="map_umkm_count" class="font-semibold text-[#141712]">0</span> UMKM ditampilkan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

    <script>
        let catalogMap;
        let markerClusterGroup;
        let allMarkers = [];
        const umkmData = @json($umkms->items());

        function switchView(view) {
            const listView = document.getElementById('listView');
            const mapView = document.getElementById('mapView');
            const listBtn = document.getElementById('listViewBtn');
            const mapBtn = document.getElementById('mapViewBtn');
            const activeClasses = ['bg-[#d4a945]', 'text-[#10130f]'];
            const inactiveClasses = ['text-white/70', 'hover:text-white'];

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
                setTimeout(() => catalogMap && catalogMap.invalidateSize(), 100);
            }
        }

        function initCatalogMap() {
            catalogMap = L.map('catalog_map').setView([-7.3305, 110.5083], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(catalogMap);

            setTimeout(function() { catalogMap.invalidateSize(); }, 200);

            markerClusterGroup = L.markerClusterGroup({
                maxClusterRadius: 50,
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: false,
                zoomToBoundsOnClick: true
            });

            const novaIcon = L.divIcon({
                className: 'custom-marker',
                html: '<div style="background:#d4a945;width:28px;height:28px;border:3px solid #fff;box-shadow:0 8px 18px rgba(20,23,18,.28);"></div>',
                iconSize: [28, 28],
                iconAnchor: [14, 14],
                popupAnchor: [0, -14]
            });

            let umkmWithLocation = 0;
            umkmData.forEach(umkm => {
                if (umkm.latitude && umkm.longitude) {
                    umkmWithLocation++;
                    const marker = L.marker([umkm.latitude, umkm.longitude], { icon: novaIcon });
                    const logoHtml = umkm.logo_path
                        ? `<img src="/storage/${umkm.logo_path}" alt="${umkm.nama_usaha}" style="width:72px;height:72px;object-fit:cover;margin:0 auto 10px;">`
                        : `<div style="width:72px;height:72px;margin:0 auto 10px;background:#10130f;color:#d4a945;display:flex;align-items:center;justify-content:center;font-weight:700;">${umkm.nama_usaha.substring(0, 2).toUpperCase()}</div>`;

                    marker.bindPopup(`
                        <div style="text-align:center;padding:6px;min-width:210px;">
                            ${logoHtml}
                            <h3 style="font-weight:700;font-size:16px;margin:0 0 4px;color:#141712;">${umkm.nama_usaha}</h3>
                            <p style="font-size:13px;margin:0 0 3px;color:#657066;">${umkm.category.nama_kategori}</p>
                            <p style="font-size:12px;margin:0 0 12px;color:#7b8379;">${umkm.district.nama_kecamatan}</p>
                            <a href="/umkm/${umkm.slug}" style="display:inline-block;background:#10130f;color:white;padding:8px 12px;font-size:13px;font-weight:700;text-decoration:none;">Lihat Detail</a>
                        </div>
                    `, { maxWidth: 250, className: 'custom-popup' });

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
            document.getElementById('map_umkm_count').textContent = umkmWithLocation;

            const style = document.createElement('style');
            style.textContent = `
                .custom-popup .leaflet-popup-content-wrapper { border-radius: 0; box-shadow: 0 12px 30px rgba(20,23,18,.22); }
                .custom-popup .leaflet-popup-tip { background: white; }
                .marker-cluster-small, .marker-cluster-medium, .marker-cluster-large { background-color: rgba(212,169,69,.34); }
                .marker-cluster-small div, .marker-cluster-medium div, .marker-cluster-large div { background-color: #d4a945; color: #10130f; font-weight: 700; }
            `;
            document.head.appendChild(style);
        }

        function applyMapFilters() {
            const categoryId = document.getElementById('map_category_filter').value;
            const districtId = document.getElementById('map_district_filter').value;
            markerClusterGroup.clearLayers();

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

            document.getElementById('map_umkm_count').textContent = visibleCount;
            if (visibleCount > 0) {
                catalogMap.fitBounds(markerClusterGroup.getBounds(), { padding: [50, 50] });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('catalogView') === 'map') {
                switchView('map');
            }
        });
    </script>
</x-guest-layout>
