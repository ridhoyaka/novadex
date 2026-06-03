<x-guest-layout>
    <div class="min-h-screen bg-arsa-950">
        <!-- Leaflet CSS loaded inline to ensure availability -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
        <style>
            #map { z-index: 1; min-height: 400px; }
            .leaflet-routing-container { display: none !important; }
            @keyframes pulse-ring {
                0% { transform: scale(1); opacity: 1; }
                100% { transform: scale(1.8); opacity: 0; }
            }
        </style>

        <!-- Header -->
        <div class="bg-arsa-900 border-b border-arsa-800 py-8 sm:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-2xl sm:text-4xl font-black text-white mb-2 sm:mb-4" style="font-family: 'Space Grotesk', sans-serif;">
                    Peta UMKM Salatiga
                </h1>
                <p class="text-gray-400 text-sm sm:text-lg">
                    Temukan lokasi UMKM di sekitar Anda dan dapatkan rute menuju tujuan
                </p>
            </div>
        </div>

        <!-- Location Status Banner -->
        <div id="locationBanner" class="hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <div id="locationStatus" class="bg-blue-500/10 border border-blue-500/30 rounded-lg p-3 flex items-center gap-3">
                    <div class="animate-spin w-5 h-5 border-2 border-blue-400 border-t-transparent rounded-full"></div>
                    <p class="text-blue-300 text-sm font-medium">Mendeteksi lokasi Anda...</p>
                </div>
            </div>
        </div>

        <!-- Map Container -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-8">
                <!-- Sidebar - UMKM List -->
                <div class="lg:col-span-1 space-y-4 order-2 lg:order-1">
                    <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 sm:p-6">
                        <h2 class="text-lg sm:text-xl font-bold text-white mb-4" style="font-family: 'Space Grotesk', sans-serif;">
                            Filter Lokasi
                        </h2>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-white mb-2">KECAMATAN</label>
                            <select id="districtFilter" class="w-full px-4 py-3 bg-arsa-800 border border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                                <option value="">Semua Kecamatan</option>
                                @foreach($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->nama_kecamatan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-white mb-2">KATEGORI</label>
                            <select id="categoryFilter" class="w-full px-4 py-3 bg-arsa-800 border border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button onclick="applyFilters()" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-r from-gold-500 to-gold-600 rounded-lg font-bold text-sm text-black hover:from-gold-600 hover:to-gold-700 transition-all">
                            Terapkan Filter
                        </button>
                    </div>

                    <!-- UMKM List -->
                    <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 sm:p-6 max-h-[400px] lg:max-h-[500px] overflow-y-auto">
                        <h2 class="text-lg sm:text-xl font-bold text-white mb-4" style="font-family: 'Space Grotesk', sans-serif;">
                            Daftar UMKM
                            <span class="text-sm font-normal text-gray-400 ml-2">Klik untuk rute</span>
                        </h2>
                        <div id="umkmList" class="space-y-3">
                            @foreach($umkmList as $umkm)
                            <div class="umkm-item bg-arsa-800 border border-arsa-700 rounded-lg p-3 sm:p-4 hover:border-gold-500 transition-all cursor-pointer"
                                 data-id="{{ $umkm->id }}"
                                 data-lat="{{ $umkm->latitude ?? '' }}"
                                 data-lng="{{ $umkm->longitude ?? '' }}"
                                 data-district="{{ $umkm->kecamatan_id }}"
                                 data-category="{{ $umkm->kategori_id }}"
                                 data-name="{{ $umkm->nama_usaha }}"
                                 onclick="navigateToUmkm({{ $umkm->id }})">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-arsa-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                        @if($umkm->logo_path)
                                        <img src="{{ Storage::url($umkm->logo_path) }}" alt="{{ $umkm->nama_usaha }}" class="w-full h-full object-cover rounded-lg">
                                        @else
                                        <span class="text-xl sm:text-2xl">🏪</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-white text-sm truncate">{{ $umkm->nama_usaha }}</h3>
                                        <p class="text-xs text-gray-400">{{ $umkm->category->nama_kategori }}</p>
                                        <p class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $umkm->district->nama_kecamatan }}
                                        </p>
                                        <!-- Distance & Time Info -->
                                        <div class="distance-info mt-1.5 hidden" id="distance-{{ $umkm->id }}">
                                            <div class="flex items-center gap-2 text-xs">
                                                <span class="text-gold-400 font-semibold distance-value"></span>
                                                <span class="text-gray-600">•</span>
                                                <span class="text-gray-400 time-value"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="text-gold-400 text-xs font-bold bg-gold-500/10 px-2 py-1 rounded-lg">RUTE</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Map -->
                <div class="lg:col-span-2 order-1 lg:order-2">
                    <div class="bg-arsa-900 border border-arsa-800 rounded-xl overflow-hidden relative">
                        <div id="map" class="w-full" style="height:700px; min-height:400px; background:#1a1a2e;"></div>
                        
                        <!-- Route Info Panel -->
                        <div id="routeInfo" class="hidden absolute bottom-4 left-4 right-4 bg-arsa-900/95 backdrop-blur-md border border-arsa-800 rounded-xl p-4 z-[1000]">
                            <div class="flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <h4 id="routeDestination" class="text-white font-bold text-sm sm:text-base truncate"></h4>
                                    <div class="flex items-center gap-4 mt-1">
                                        <span id="routeDistance" class="text-gold-400 text-sm font-semibold"></span>
                                        <span id="routeDuration" class="text-gray-400 text-sm"></span>
                                    </div>
                                </div>
                                <div class="flex gap-2 flex-shrink-0">
                                    <button onclick="openInGoogleMaps()" class="inline-flex items-center gap-1 px-3 py-2 bg-blue-500/10 border border-blue-500/30 text-blue-400 rounded-lg text-xs font-bold hover:bg-blue-500/20 transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        <span class="hidden sm:inline">Maps</span>
                                    </button>
                                    <button onclick="clearRoute()" class="inline-flex items-center gap-1 px-3 py-2 bg-red-500/10 border border-red-500/30 text-red-400 rounded-lg text-xs font-bold hover:bg-red-500/20 transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        <span class="hidden sm:inline">Tutup</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Map Info -->
                    <div class="mt-4 bg-arsa-900 border border-arsa-800 rounded-xl p-3 sm:p-4">
                        <div class="flex flex-wrap items-center gap-3 sm:gap-4 text-xs sm:text-sm text-gray-400">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-gold-500 rounded-full"></div>
                                <span>UMKM</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                <span>Lokasi Anda</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                <span>Rute</span>
                            </div>
                            <div class="ml-auto">
                                <span class="font-semibold text-white">{{ $umkmList->count() }}</span> UMKM
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>

    <script>
        // State
        let userLat = null;
        let userLng = null;
        let userMarker = null;
        let routingControl = null;
        let currentDestination = null;
        let currentDestinationName = '';

        // Initialize map centered on Salatiga
        const map = L.map('map').setView([-7.3305, 110.5083], 13);

        // Add OpenStreetMap tiles
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 19
        }).addTo(map);

        // Force map to recalculate size
        window.addEventListener('load', function() {
            setTimeout(function() { map.invalidateSize(); }, 100);
            setTimeout(function() { map.invalidateSize(); }, 500);
        });

        // Custom marker icons
        const goldIcon = L.divIcon({
            className: 'custom-marker',
            html: '<div style="background:linear-gradient(135deg,#f59e0b,#d97706);width:32px;height:32px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid white;box-shadow:0 4px 8px rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;"><span style="transform:rotate(45deg);font-size:14px;">🏪</span></div>',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        const userIcon = L.divIcon({
            className: 'custom-marker',
            html: '<div style="position:relative;"><div style="background:#3b82f6;width:20px;height:20px;border-radius:50%;border:4px solid white;box-shadow:0 2px 8px rgba(59,130,246,0.5);"></div><div style="position:absolute;top:-4px;left:-4px;width:28px;height:28px;border-radius:50%;border:2px solid rgba(59,130,246,0.4);animation:pulse-ring 2s infinite;"></div></div>',
            iconSize: [20, 20],
            iconAnchor: [10, 10],
            popupAnchor: [0, -10]
        });

        // Store markers
        const markers = {};

        // Add markers for each UMKM
        const umkmData = @json($umkmList);
        
        umkmData.forEach(function(umkm) {
            if (!umkm.latitude || !umkm.longitude) return;
            
            const lat = parseFloat(umkm.latitude);
            const lng = parseFloat(umkm.longitude);
            
            const marker = L.marker([lat, lng], { icon: goldIcon }).addTo(map);

            const logoHtml = umkm.logo_path 
                ? '<img src="/storage/' + umkm.logo_path + '" alt="' + umkm.nama_usaha + '" style="width:60px;height:60px;object-fit:cover;border-radius:8px;margin:0 auto 8px;">'
                : '<div style="font-size:2.5rem;margin-bottom:8px;">🏪</div>';

            marker.bindPopup(
                '<div style="text-align:center;padding:4px;min-width:180px;">' +
                    logoHtml +
                    '<h3 style="font-weight:bold;font-size:14px;margin-bottom:4px;">' + umkm.nama_usaha + '</h3>' +
                    '<p style="font-size:12px;color:#666;margin-bottom:4px;">' + umkm.category.nama_kategori + '</p>' +
                    '<p style="font-size:11px;color:#999;margin-bottom:8px;">📍 ' + umkm.district.nama_kecamatan + '</p>' +
                    '<div style="display:flex;gap:6px;justify-content:center;flex-wrap:wrap;">' +
                        '<button onclick="navigateToUmkm(' + umkm.id + ')" style="background:linear-gradient(135deg,#f59e0b,#d97706);color:#000;padding:6px 12px;border-radius:6px;font-size:11px;font-weight:bold;border:none;cursor:pointer;">🧭 Rute</button>' +
                        '<a href="/umkm/' + umkm.slug + '" style="background:#3b82f6;color:#fff;padding:6px 12px;border-radius:6px;font-size:11px;font-weight:bold;text-decoration:none;display:inline-block;">Detail</a>' +
                    '</div>' +
                '</div>'
            , { maxWidth: 250 });

            markers[umkm.id] = { marker: marker, lat: lat, lng: lng, name: umkm.nama_usaha };
        });

        // ===== GEOLOCATION =====
        function initGeolocation() {
            var banner = document.getElementById('locationBanner');
            banner.classList.remove('hidden');

            if (!navigator.geolocation) {
                showLocationError('Browser Anda tidak mendukung geolokasi.');
                return;
            }

            navigator.geolocation.getCurrentPosition(
                onLocationSuccess,
                onLocationError,
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 }
            );
        }

        function onLocationSuccess(position) {
            userLat = position.coords.latitude;
            userLng = position.coords.longitude;

            if (userMarker) map.removeLayer(userMarker);
            userMarker = L.marker([userLat, userLng], { icon: userIcon }).addTo(map);
            userMarker.bindPopup('<div style="text-align:center;font-weight:bold;font-size:13px;">📍 Lokasi Anda</div>');

            map.setView([userLat, userLng], 14);
            showLocationSuccess();
            
            // Calculate distances to all UMKM
            calculateAllDistances();
        }

        function onLocationError(error) {
            var msg = 'Tidak dapat mendeteksi lokasi.';
            if (error.code === error.PERMISSION_DENIED) {
                msg = 'Akses lokasi ditolak. Aktifkan izin lokasi di browser.';
            } else if (error.code === error.POSITION_UNAVAILABLE) {
                msg = 'Informasi lokasi tidak tersedia.';
            } else if (error.code === error.TIMEOUT) {
                msg = 'Waktu permintaan lokasi habis.';
            }
            showLocationError(msg);
        }

        function showLocationSuccess() {
            var el = document.getElementById('locationStatus');
            el.className = 'bg-green-500/10 border border-green-500/30 rounded-lg p-3 flex items-center gap-3';
            el.innerHTML = '<svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><p class="text-green-300 text-sm font-medium">Lokasi terdeteksi! Pilih UMKM untuk melihat rute.</p>';
            setTimeout(function() { document.getElementById('locationBanner').classList.add('hidden'); }, 4000);
        }

        function showLocationError(msg) {
            var el = document.getElementById('locationStatus');
            el.className = 'bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-3 flex items-center gap-3';
            el.innerHTML = '<svg class="w-5 h-5 text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg><p class="text-yellow-300 text-sm font-medium">' + msg + ' Anda masih bisa melihat peta.</p>';
        }

        // ===== ROUTING =====
        function navigateToUmkm(id) {
            var umkm = markers[id];
            if (!umkm) return;

            currentDestination = { lat: umkm.lat, lng: umkm.lng };
            currentDestinationName = umkm.name;

            if (userLat === null || userLng === null) {
                map.setView([umkm.lat, umkm.lng], 16);
                umkm.marker.openPopup();
                
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(pos) {
                            userLat = pos.coords.latitude;
                            userLng = pos.coords.longitude;
                            if (userMarker) map.removeLayer(userMarker);
                            userMarker = L.marker([userLat, userLng], { icon: userIcon }).addTo(map);
                            showRoute(userLat, userLng, umkm.lat, umkm.lng, umkm.name);
                        },
                        function() {
                            alert('Aktifkan lokasi untuk melihat rute.');
                        },
                        { enableHighAccuracy: true, timeout: 5000 }
                    );
                }
                return;
            }

            showRoute(userLat, userLng, umkm.lat, umkm.lng, umkm.name);
        }

        function showRoute(fromLat, fromLng, toLat, toLng, destName) {
            if (routingControl) {
                map.removeControl(routingControl);
                routingControl = null;
            }

            routingControl = L.Routing.control({
                waypoints: [L.latLng(fromLat, fromLng), L.latLng(toLat, toLng)],
                routeWhileDragging: false,
                addWaypoints: false,
                draggableWaypoints: false,
                fitSelectedRoutes: true,
                showAlternatives: false,
                show: false,
                lineOptions: {
                    styles: [
                        { color: '#8b5cf6', opacity: 0.8, weight: 6 },
                        { color: '#a78bfa', opacity: 0.4, weight: 10 }
                    ]
                },
                createMarker: function() { return null; },
                router: L.Routing.osrmv1({
                    serviceUrl: 'https://router.project-osrm.org/route/v1',
                    profile: 'driving'
                })
            }).addTo(map);

            routingControl.on('routesfound', function(e) {
                var route = e.routes[0];
                document.getElementById('routeInfo').classList.remove('hidden');
                document.getElementById('routeDestination').textContent = destName;
                document.getElementById('routeDistance').textContent = formatDistance(route.summary.totalDistance);
                document.getElementById('routeDuration').textContent = formatDuration(route.summary.totalTime);
            });

            routingControl.on('routingerror', function() {
                drawStraightLine(fromLat, fromLng, toLat, toLng, destName);
            });
        }

        function drawStraightLine(fromLat, fromLng, toLat, toLng, destName) {
            clearRoute();
            var line = L.polyline([[fromLat, fromLng], [toLat, toLng]], {
                color: '#8b5cf6', weight: 4, dashArray: '10, 10', opacity: 0.7
            }).addTo(map);

            routingControl = { _line: line };
            var distance = L.latLng(fromLat, fromLng).distanceTo(L.latLng(toLat, toLng));

            document.getElementById('routeInfo').classList.remove('hidden');
            document.getElementById('routeDestination').textContent = destName;
            document.getElementById('routeDistance').textContent = formatDistance(distance) + ' (garis lurus)';
            document.getElementById('routeDuration').textContent = 'Rute jalan tidak tersedia';
            map.fitBounds([[fromLat, fromLng], [toLat, toLng]], { padding: [50, 50] });
        }

        function clearRoute() {
            if (routingControl) {
                if (routingControl._line) {
                    map.removeLayer(routingControl._line);
                } else {
                    map.removeControl(routingControl);
                }
                routingControl = null;
            }
            document.getElementById('routeInfo').classList.add('hidden');
            currentDestination = null;
            currentDestinationName = '';
        }

        function openInGoogleMaps() {
            if (!currentDestination) return;
            var url;
            if (userLat && userLng) {
                url = 'https://www.google.com/maps/dir/' + userLat + ',' + userLng + '/' + currentDestination.lat + ',' + currentDestination.lng;
            } else {
                url = 'https://www.google.com/maps/search/?api=1&query=' + currentDestination.lat + ',' + currentDestination.lng;
            }
            window.open(url, '_blank');
        }

        // ===== HELPERS =====
        function formatDistance(meters) {
            if (meters >= 1000) return (meters / 1000).toFixed(1) + ' km';
            return Math.round(meters) + ' m';
        }

        function formatDuration(seconds) {
            if (seconds >= 3600) {
                var hours = Math.floor(seconds / 3600);
                var mins = Math.round((seconds % 3600) / 60);
                return '~' + hours + ' jam ' + mins + ' menit';
            }
            return '~' + Math.round(seconds / 60) + ' menit';
        }

        // Estimate travel time based on distance (avg 30 km/h in city)
        function estimateTravelTime(meters) {
            var avgSpeedKmh = 30; // average city driving speed
            var hours = (meters / 1000) / avgSpeedKmh;
            var totalSeconds = hours * 3600;
            return formatDuration(totalSeconds);
        }

        // Calculate distances from user to all UMKM and display in sidebar
        function calculateAllDistances() {
            if (userLat === null || userLng === null) return;
            
            var userLatLng = L.latLng(userLat, userLng);
            var items = [];

            document.querySelectorAll('.umkm-item').forEach(function(item) {
                var lat = parseFloat(item.dataset.lat);
                var lng = parseFloat(item.dataset.lng);
                var id = item.dataset.id;
                var distanceEl = document.getElementById('distance-' + id);
                
                if (lat && lng && distanceEl) {
                    var umkmLatLng = L.latLng(lat, lng);
                    var distance = userLatLng.distanceTo(umkmLatLng); // meters
                    
                    // Show distance info
                    distanceEl.classList.remove('hidden');
                    distanceEl.querySelector('.distance-value').textContent = formatDistance(distance);
                    distanceEl.querySelector('.time-value').textContent = estimateTravelTime(distance);
                    
                    // Store for sorting
                    items.push({ element: item, distance: distance });
                }
            });

            // Sort UMKM list by distance (nearest first)
            if (items.length > 0) {
                var listContainer = document.getElementById('umkmList');
                items.sort(function(a, b) { return a.distance - b.distance; });
                items.forEach(function(item) {
                    listContainer.appendChild(item.element);
                });
            }
        }

        // Apply filters
        function applyFilters() {
            var districtId = document.getElementById('districtFilter').value;
            var categoryId = document.getElementById('categoryFilter').value;

            document.querySelectorAll('.umkm-item').forEach(function(item) {
                var itemDistrict = item.dataset.district;
                var itemCategory = item.dataset.category;
                var districtMatch = !districtId || itemDistrict === districtId;
                var categoryMatch = !categoryId || itemCategory === categoryId;
                
                if (districtMatch && categoryMatch) {
                    item.style.display = 'block';
                    var markerId = item.dataset.id;
                    if (markers[markerId]) markers[markerId].marker.addTo(map);
                } else {
                    item.style.display = 'none';
                    var markerId = item.dataset.id;
                    if (markers[markerId]) map.removeLayer(markers[markerId].marker);
                }
            });
        }

        // Initialize geolocation on page load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initGeolocation);
        } else {
            initGeolocation();
        }
    </script>
</x-guest-layout>
