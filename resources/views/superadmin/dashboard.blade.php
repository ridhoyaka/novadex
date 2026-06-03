<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight" style="font-family: 'Space Grotesk', sans-serif;">
            Dashboard Super Admin
        </h2>
    </x-slot>

    <div class="py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Quick Actions -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                <a href="{{ route('superadmin.umkm.index') }}" class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 hover:border-gold-500 transition-all text-center">
                    <span class="text-2xl">🏪</span>
                    <p class="text-sm text-white font-medium mt-2">Kelola UMKM</p>
                </a>
                <a href="{{ route('superadmin.users.index') }}" class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 hover:border-gold-500 transition-all text-center">
                    <span class="text-2xl">👥</span>
                    <p class="text-sm text-white font-medium mt-2">Kelola Users</p>
                </a>
                <a href="{{ route('superadmin.categories.index') }}" class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 hover:border-gold-500 transition-all text-center">
                    <span class="text-2xl">📦</span>
                    <p class="text-sm text-white font-medium mt-2">Kategori</p>
                </a>
                <a href="{{ route('superadmin.districts.index') }}" class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 hover:border-gold-500 transition-all text-center">
                    <span class="text-2xl">📍</span>
                    <p class="text-sm text-white font-medium mt-2">Kecamatan</p>
                </a>
            </div>

            <!-- Key Metrics Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Total UMKM -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-gold-500/10 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm font-medium mb-1">Total UMKM</p>
                    <p class="text-4xl font-black text-white">{{ $stats['total_umkm'] }}</p>
                    <div class="mt-3 flex gap-3 text-xs">
                        <span class="text-green-400">✓ {{ $stats['published_umkm'] }} Aktif</span>
                        <span class="text-gray-500">{{ $stats['unpublished_umkm'] }} Nonaktif</span>
                    </div>
                </div>

                <!-- Published Rate -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-green-500/10 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm font-medium mb-1">Tingkat Publikasi</p>
                    <p class="text-4xl font-black text-white">{{ $stats['published_rate'] }}%</p>
                    <p class="mt-3 text-xs text-gray-400">{{ $stats['published_umkm'] }} dari {{ $stats['total_umkm'] }} UMKM</p>
                </div>

                <!-- Avg Completion Score -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-500/10 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm font-medium mb-1">Rata-rata Kelengkapan</p>
                    <p class="text-4xl font-black text-white">{{ $stats['avg_completion_score'] }}%</p>
                    <p class="mt-3 text-xs text-gray-400">Skor profil rata-rata</p>
                </div>

                <!-- Total Users -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-purple-500/10 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm font-medium mb-1">Total Pengguna</p>
                    <p class="text-4xl font-black text-white">{{ $stats['total_users'] }}</p>
                    <div class="mt-3 flex gap-3 text-xs">
                        <span class="text-blue-400">{{ $stats['umkm_users'] }} UMKM</span>
                        <span class="text-purple-400">{{ $stats['admin_users'] }} Admin</span>
                    </div>
                </div>
            </div>

            <!-- Data Quality Metrics -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                <h3 class="text-xl font-bold text-white mb-6" style="font-family: 'Space Grotesk', sans-serif;">Kualitas Data</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-300 text-sm">Dengan Foto</span>
                            <span class="text-gold-400 font-bold">{{ $dataQuality['with_photos'] }}</span>
                        </div>
                        <div class="w-full bg-arsa-800 rounded-full h-3">
                            <div class="bg-gold-500 h-3 rounded-full" style="width: {{ $stats['total_umkm'] > 0 ? ($dataQuality['with_photos'] / $stats['total_umkm']) * 100 : 0 }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $stats['total_umkm'] > 0 ? round(($dataQuality['with_photos'] / $stats['total_umkm']) * 100, 1) : 0 }}% dari total</p>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-300 text-sm">Dengan Lokasi</span>
                            <span class="text-blue-400 font-bold">{{ $dataQuality['with_location'] }}</span>
                        </div>
                        <div class="w-full bg-arsa-800 rounded-full h-3">
                            <div class="bg-blue-500 h-3 rounded-full" style="width: {{ $stats['total_umkm'] > 0 ? ($dataQuality['with_location'] / $stats['total_umkm']) * 100 : 0 }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $stats['total_umkm'] > 0 ? round(($dataQuality['with_location'] / $stats['total_umkm']) * 100, 1) : 0 }}% dari total</p>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-300 text-sm">Profil Lengkap (≥80%)</span>
                            <span class="text-green-400 font-bold">{{ $dataQuality['complete_profiles'] }}</span>
                        </div>
                        <div class="w-full bg-arsa-800 rounded-full h-3">
                            <div class="bg-green-500 h-3 rounded-full" style="width: {{ $stats['total_umkm'] > 0 ? ($dataQuality['complete_profiles'] / $stats['total_umkm']) * 100 : 0 }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $stats['total_umkm'] > 0 ? round(($dataQuality['complete_profiles'] / $stats['total_umkm']) * 100, 1) : 0 }}% dari total</p>
                    </div>
                </div>
            </div>

            <!-- Charts Row 1 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- UMKM Growth Trend -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                    <h3 class="text-xl font-bold text-white mb-6" style="font-family: 'Space Grotesk', sans-serif;">Pertumbuhan UMKM (12 Bulan Terakhir)</h3>
                    <div style="height: 300px;">
                        <canvas id="umkmGrowthChart"></canvas>
                    </div>
                </div>

                <!-- Published vs Unpublished -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                    <h3 class="text-xl font-bold text-white mb-6" style="font-family: 'Space Grotesk', sans-serif;">Status Publikasi</h3>
                    <div style="height: 300px;">
                        <canvas id="publishedChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Charts Row 2 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- UMKM by Category -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                    <h3 class="text-xl font-bold text-white mb-6" style="font-family: 'Space Grotesk', sans-serif;">Distribusi per Kategori</h3>
                    <div style="height: 300px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                <!-- UMKM by District -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                    <h3 class="text-xl font-bold text-white mb-6" style="font-family: 'Space Grotesk', sans-serif;">Distribusi per Kecamatan</h3>
                    <div style="height: 300px;">
                        <canvas id="districtChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- New UMKM per Month -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                <h3 class="text-xl font-bold text-white mb-6" style="font-family: 'Space Grotesk', sans-serif;">UMKM Baru per Bulan (6 Bulan Terakhir)</h3>
                <div style="height: 250px;">
                    <canvas id="newUmkmChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Chart.js default config
        Chart.defaults.color = '#9CA3AF';
        Chart.defaults.borderColor = '#374151';
        Chart.defaults.font.family = "'Space Grotesk', sans-serif";

        // UMKM Growth Trend Chart
        const umkmGrowthCtx = document.getElementById('umkmGrowthChart').getContext('2d');
        new Chart(umkmGrowthCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($umkmGrowth->pluck('month')) !!},
                datasets: [{
                    label: 'Total UMKM',
                    data: {!! json_encode($umkmGrowth->pluck('count')) !!},
                    borderColor: '#F59E0B',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#F59E0B',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Published vs Unpublished Chart
        const publishedCtx = document.getElementById('publishedChart').getContext('2d');
        new Chart(publishedCtx, {
            type: 'doughnut',
            data: {
                labels: ['Aktif', 'Nonaktif'],
                datasets: [{
                    data: [{{ $publishedComparison['published'] }}, {{ $publishedComparison['unpublished'] }}],
                    backgroundColor: ['#10B981', '#6B7280'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 14
                            }
                        }
                    }
                }
            }
        });

        // Category Distribution Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($umkmByCategory->pluck('nama_kategori')) !!},
                datasets: [{
                    label: 'Jumlah UMKM',
                    data: {!! json_encode($umkmByCategory->pluck('total')) !!},
                    backgroundColor: '#F59E0B',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // District Distribution Chart
        const districtCtx = document.getElementById('districtChart').getContext('2d');
        new Chart(districtCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($umkmByDistrict->pluck('nama_kecamatan')) !!},
                datasets: [{
                    label: 'Jumlah UMKM',
                    data: {!! json_encode($umkmByDistrict->pluck('total')) !!},
                    backgroundColor: '#3B82F6',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // New UMKM per Month Chart
        const newUmkmCtx = document.getElementById('newUmkmChart').getContext('2d');
        new Chart(newUmkmCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($newUmkmPerMonth->pluck('month')) !!},
                datasets: [{
                    label: 'UMKM Baru',
                    data: {!! json_encode($newUmkmPerMonth->pluck('count')) !!},
                    backgroundColor: '#8B5CF6',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
