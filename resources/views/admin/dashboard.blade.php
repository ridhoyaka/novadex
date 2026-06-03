<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight" style="font-family: 'Space Grotesk', sans-serif;">
            Dashboard Admin
        </h2>
    </x-slot>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart.js default config
            Chart.defaults.color = '#9CA3AF';
            Chart.defaults.borderColor = '#374151';
            
            // Category Chart
            const categoryCtx = document.getElementById('categoryChart');
            if (categoryCtx) {
                new Chart(categoryCtx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($umkmByCategory->pluck('nama_kategori')) !!},
                        datasets: [{
                            label: 'Jumlah UMKM',
                            data: {!! json_encode($umkmByCategory->pluck('umkm_profiles_count')) !!},
                            backgroundColor: 'rgba(234, 179, 8, 0.8)',
                            borderColor: 'rgba(234, 179, 8, 1)',
                            borderWidth: 1,
                            borderRadius: 4
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
                                    stepSize: 1
                                },
                                grid: {
                                    color: 'rgba(55, 65, 81, 0.5)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
            
            // District Chart
            const districtCtx = document.getElementById('districtChart');
            if (districtCtx) {
                new Chart(districtCtx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($umkmByDistrict->pluck('nama_kecamatan')) !!},
                        datasets: [{
                            label: 'Jumlah UMKM',
                            data: {!! json_encode($umkmByDistrict->pluck('umkm_profiles_count')) !!},
                            backgroundColor: 'rgba(234, 179, 8, 0.8)',
                            borderColor: 'rgba(234, 179, 8, 1)',
                            borderWidth: 1,
                            borderRadius: 4
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
                                    stepSize: 1
                                },
                                grid: {
                                    color: 'rgba(55, 65, 81, 0.5)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
            
            // Publication Status Pie Chart
            const statusCtx = document.getElementById('statusChart');
            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Aktif', 'Nonaktif'],
                        datasets: [{
                            data: [{{ $stats['published_umkm'] }}, {{ $stats['unpublished_umkm'] }}],
                            backgroundColor: [
                                'rgba(34, 197, 94, 0.8)',
                                'rgba(239, 68, 68, 0.8)'
                            ],
                            borderColor: [
                                'rgba(34, 197, 94, 1)',
                                'rgba(239, 68, 68, 1)'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 15,
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total UMKM -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6 hover:border-gold-500 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm font-medium">Total UMKM</p>
                            <p class="text-3xl font-black text-white mt-2" style="font-family: 'Space Grotesk', sans-serif;">{{ $stats['total_umkm'] }}</p>
                        </div>
                        <div class="w-14 h-14 bg-gold-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Published UMKM -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6 hover:border-green-500 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm font-medium">UMKM Aktif</p>
                            <p class="text-3xl font-black text-white mt-2" style="font-family: 'Space Grotesk', sans-serif;">{{ $stats['published_umkm'] }}</p>
                        </div>
                        <div class="w-14 h-14 bg-green-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Unpublished UMKM -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6 hover:border-red-500 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm font-medium">UMKM Nonaktif</p>
                            <p class="text-3xl font-black text-white mt-2" style="font-family: 'Space Grotesk', sans-serif;">{{ $stats['unpublished_umkm'] }}</p>
                        </div>
                        <div class="w-14 h-14 bg-red-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6 hover:border-blue-500 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm font-medium">Total Pengguna</p>
                            <p class="text-3xl font-black text-white mt-2" style="font-family: 'Space Grotesk', sans-serif;">{{ $stats['total_users'] }}</p>
                        </div>
                        <div class="w-14 h-14 bg-blue-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- UMKM by Category Chart -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4" style="font-family: 'Space Grotesk', sans-serif;">UMKM per Kategori</h3>
                    <div style="height: 300px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                <!-- UMKM by District Chart -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4" style="font-family: 'Space Grotesk', sans-serif;">UMKM per Kecamatan</h3>
                    <div style="height: 300px;">
                        <canvas id="districtChart"></canvas>
                    </div>
                </div>
                
                <!-- Publication Status Pie Chart -->
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-white mb-4" style="font-family: 'Space Grotesk', sans-serif;">Status Publikasi</h3>
                    <div style="height: 300px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Data Quality Indicators -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-white" style="font-family: 'Space Grotesk', sans-serif;">Indikator Kualitas Data</h3>
                    <a href="{{ route('admin.content.map') }}" class="flex items-center gap-2 px-4 py-2 bg-gold-600 hover:bg-gold-700 text-arsa-900 font-semibold rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        Lihat Peta UMKM
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Without Photos -->
                    <div class="bg-arsa-800 border border-arsa-700 rounded-lg p-4 hover:border-yellow-500 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-yellow-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-black text-white">{{ $stats['without_photos'] }}</p>
                                <p class="text-xs text-gray-400">Tanpa Foto</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Short Descriptions -->
                    <div class="bg-arsa-800 border border-arsa-700 rounded-lg p-4 hover:border-orange-500 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-orange-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-black text-white">{{ $stats['short_descriptions'] }}</p>
                                <p class="text-xs text-gray-400">Deskripsi Singkat</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Without Location -->
                    <div class="bg-arsa-800 border border-arsa-700 rounded-lg p-4 hover:border-red-500 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-red-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-black text-white">{{ $stats['without_location'] }}</p>
                                <p class="text-xs text-gray-400">Tanpa Lokasi</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Inactive Profiles -->
                    <div class="bg-arsa-800 border border-arsa-700 rounded-lg p-4 hover:border-purple-500 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-purple-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-black text-white">{{ $stats['inactive_profiles'] }}</p>
                                <p class="text-xs text-gray-400">Tidak Aktif 90hr</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Low Completion -->
                    <div class="bg-arsa-800 border border-arsa-700 rounded-lg p-4 hover:border-blue-500 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-black text-white">{{ $stats['low_completion'] }}</p>
                                <p class="text-xs text-gray-400">Kelengkapan < 50%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent UMKM -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-white" style="font-family: 'Space Grotesk', sans-serif;">UMKM Terbaru</h3>
                    <a href="{{ route('admin.umkm.index') }}" class="text-gold-400 hover:text-gold-300 text-sm font-semibold">
                        Lihat Semua →
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-arsa-800">
                                <th class="text-left py-3 px-4 text-gray-400 font-semibold text-sm">Nama Usaha</th>
                                <th class="text-left py-3 px-4 text-gray-400 font-semibold text-sm">Kategori</th>
                                <th class="text-left py-3 px-4 text-gray-400 font-semibold text-sm">Kecamatan</th>
                                <th class="text-left py-3 px-4 text-gray-400 font-semibold text-sm">Status</th>
                                <th class="text-left py-3 px-4 text-gray-400 font-semibold text-sm">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUmkm as $umkm)
                            <tr class="border-b border-arsa-800 hover:bg-arsa-800 transition-colors">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-arsa-800 rounded-lg flex items-center justify-center flex-shrink-0">
                                            @if($umkm->logo_path)
                                            <img src="{{ Storage::url($umkm->logo_path) }}" alt="{{ $umkm->nama_usaha }}" class="w-full h-full object-cover rounded-lg">
                                            @else
                                            <span class="text-xl">🏪</span>
                                            @endif
                                        </div>
                                        <span class="text-white font-medium">{{ $umkm->nama_usaha }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-gray-300">{{ $umkm->category->nama_kategori }}</td>
                                <td class="py-3 px-4 text-gray-300">{{ $umkm->district->nama_kecamatan }}</td>
                                <td class="py-3 px-4">
                                    @if($umkm->is_published)
                                    <span class="px-3 py-1 bg-green-500/10 text-green-400 rounded-full text-xs font-semibold">Aktif</span>
                                    @else
                                    <span class="px-3 py-1 bg-red-500/10 text-red-400 rounded-full text-xs font-semibold">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-gray-400 text-sm">{{ $umkm->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
