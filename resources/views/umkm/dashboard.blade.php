<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Dashboard UMKM
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-gold-900/20 border border-gold-500 text-gold-300 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            @if(!$profile)
            <div class="bg-gold-900/20 border-l-4 border-gold-500 p-4 mb-6 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-gold-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gold-200">
                            Anda belum memiliki profil UMKM. <a href="{{ route('umkm.profile.edit') }}" class="font-medium underline hover:text-gold-100">Buat profil sekarang</a>
                        </p>
                    </div>
                </div>
            </div>
            @else
            <!-- Profile Completion -->
            <div class="bg-arsa-900 overflow-hidden shadow-xl sm:rounded-lg mb-6 border border-arsa-800">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-semibold text-white">Kelengkapan Profil Anda</h3>
                            <div class="group relative">
                                <svg class="w-5 h-5 text-arsa-400 hover:text-gold-400 cursor-help transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="absolute left-0 top-8 w-64 p-3 bg-arsa-800 border border-gold-500/30 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
                                    <p class="text-xs text-arsa-200">Profil yang lengkap membantu pelanggan menemukan dan mengenal usaha Anda lebih baik. Semakin lengkap, semakin mudah ditemukan!</p>
                                </div>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            @if($statusColor === 'green') bg-green-900/30 text-green-400 border border-green-500/30
                            @elseif($statusColor === 'yellow') bg-yellow-900/30 text-yellow-400 border border-yellow-500/30
                            @else bg-red-900/30 text-red-400 border border-red-500/30
                            @endif">
                            {{ $status }}
                        </span>
                    </div>
                    <p class="text-sm text-arsa-400 mb-4">
                        @if($completion >= 80)
                            🎉 Luar biasa! Profil Anda sudah optimal dan siap menarik perhatian pelanggan.
                        @elseif($completion >= 50)
                            👍 Bagus! Tinggal sedikit lagi untuk membuat profil Anda sempurna.
                        @else
                            💪 Ayo lengkapi profil Anda agar lebih mudah ditemukan pelanggan!
                        @endif
                    </p>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex-1">
                            <div class="w-full bg-arsa-800 rounded-full h-4">
                                <div class="h-4 rounded-full transition-all shadow-lg
                                    @if($statusColor === 'green') bg-gradient-to-r from-green-500 to-green-400
                                    @elseif($statusColor === 'yellow') bg-gradient-to-r from-yellow-500 to-yellow-400
                                    @else bg-gradient-to-r from-red-500 to-red-400
                                    @endif"
                                    style="width: {{ $completion }}%">
                                </div>
                            </div>
                        </div>
                        <span class="text-2xl font-bold text-white">{{ $completion }}%</span>
                    </div>

                    @if(count($missingFields) > 0)
                    <div class="mt-4 p-4 bg-arsa-800/50 rounded-lg border border-arsa-700">
                        <h4 class="text-sm font-semibold text-gold-400 mb-3">💡 Tingkatkan profil Anda dengan melengkapi:</h4>
                        <ul class="space-y-2">
                            @foreach($missingFields as $field)
                            <li class="flex items-start gap-2 text-sm text-arsa-300">
                                <span class="text-gold-500 mt-0.5">•</span>
                                <span>{{ $field }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <div class="mt-4">
                            <a href="{{ route('umkm.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-gold-600 hover:bg-gold-700 text-white text-sm font-medium rounded-lg transition-colors shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Lengkapi Sekarang
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="mt-4 p-4 bg-green-900/20 rounded-lg border border-green-500/30">
                        <p class="text-sm text-green-300">✨ Sempurna! Profil Anda sudah lengkap dan siap menarik banyak pelanggan.</p>
                    </div>
                    @endif
                </div>
            </div>

            @if($flags->count() > 0)
            <!-- Active Flags -->
            <div class="bg-yellow-900/20 border border-yellow-500/30 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-yellow-400 mb-4">⚠️ Perhatian dari Admin</h3>
                @foreach($flags as $flag)
                <div class="mb-4 last:mb-0 p-4 bg-arsa-900/50 rounded-lg">
                    <div class="flex items-start justify-between mb-2">
                        <span class="text-sm font-medium text-yellow-300">
                            @switch($flag->flag_type)
                                @case('inappropriate') Konten Tidak Sesuai @break
                                @case('duplicate') Duplikat @break
                                @case('incomplete') Profil Belum Lengkap @break
                                @case('quality') Kualitas Perlu Ditingkatkan @break
                            @endswitch
                        </span>
                        <span class="text-xs text-arsa-400">{{ $flag->created_at->diffForHumans() }}</span>
                    </div>
                    @if($flag->reason)
                    <p class="text-sm text-arsa-200 mb-3">{{ $flag->reason }}</p>
                    @endif
                    <a href="{{ route('umkm.profile.edit') }}" class="text-sm text-gold-400 hover:text-gold-300">
                        Perbarui Profil →
                    </a>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-arsa-900 overflow-hidden shadow-xl sm:rounded-lg border border-arsa-800 hover:border-gold-500 transition-all group">
                    <div class="p-6 text-center">
                        <div class="text-3xl mb-2">✏️</div>
                        <h4 class="font-semibold mb-2 text-white">Perbarui Profil</h4>
                        <p class="text-xs text-arsa-400 mb-3">Ubah informasi usaha Anda kapan saja</p>
                        <a href="{{ route('umkm.profile.edit') }}" class="text-gold-400 hover:text-gold-300 transition-colors font-medium">
                            Edit Informasi →
                        </a>
                    </div>
                </div>

                <div class="bg-arsa-900 overflow-hidden shadow-xl sm:rounded-lg border border-arsa-800 hover:border-gold-500 transition-all group">
                    <div class="p-6 text-center">
                        <div class="text-3xl mb-2">{{ $profile->is_published ? '👁️' : '🔒' }}</div>
                        <h4 class="font-semibold mb-2 text-white">
                            {{ $profile->is_published ? 'Profil Aktif' : 'Profil Tidak Aktif' }}
                        </h4>
                        <p class="text-xs text-arsa-400 mb-3">
                            {{ $profile->is_published ? 'Profil Anda terlihat oleh publik' : 'Profil Anda tersembunyi dari publik' }}
                        </p>
                        <form action="{{ route('umkm.profile.toggle-publish') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-gold-400 hover:text-gold-300 transition-colors font-medium">
                                {{ $profile->is_published ? 'Sembunyikan Profil' : 'Aktifkan Profil' }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="bg-arsa-900 overflow-hidden shadow-xl sm:rounded-lg border border-arsa-800 hover:border-gold-500 transition-all group">
                    <div class="p-6 text-center">
                        <div class="text-3xl mb-2">🔗</div>
                        <h4 class="font-semibold mb-2 text-white">Halaman Publik</h4>
                        <p class="text-xs text-arsa-400 mb-3">Lihat profil Anda seperti yang dilihat pelanggan</p>
                        @if($profile->is_published)
                        <a href="{{ route('umkm.show', $profile->slug) }}" target="_blank" class="text-gold-400 hover:text-gold-300 transition-colors font-medium">
                            Buka Halaman →
                        </a>
                        @else
                        <span class="text-arsa-500 text-sm">Aktifkan profil terlebih dahulu</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Profile Preview -->
            <div class="bg-arsa-900 overflow-hidden shadow-xl sm:rounded-lg border border-arsa-800">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-white">Tampilan Profil Anda</h3>
                        <div class="group relative">
                            <svg class="w-5 h-5 text-arsa-400 hover:text-gold-400 cursor-help transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="absolute right-0 top-8 w-64 p-3 bg-arsa-800 border border-gold-500/30 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-10">
                                <p class="text-xs text-arsa-200">Ini adalah tampilan singkat profil Anda. Pelanggan akan melihat informasi ini saat mencari usaha Anda.</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start gap-6">
                        <div class="w-32 h-32 bg-arsa-800 rounded-lg flex items-center justify-center flex-shrink-0 border border-arsa-700">
                            @if($profile->logo_path)
                            <img src="{{ Storage::url($profile->logo_path) }}" alt="{{ $profile->nama_usaha }}" class="w-full h-full object-cover rounded-lg">
                            @else
                            <div class="text-center">
                                <span class="text-4xl">🏪</span>
                                <p class="text-xs text-arsa-500 mt-1">Belum ada logo</p>
                            </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-white mb-2">{{ $profile->nama_usaha }}</h2>
                            <p class="text-arsa-300 mb-1">📦 {{ $profile->category->nama_kategori }}</p>
                            <p class="text-arsa-300 mb-3">📍 {{ $profile->district->nama_kecamatan }}</p>
                            @if($profile->deskripsi)
                            <p class="text-arsa-200">{{ Str::limit($profile->deskripsi, 200) }}</p>
                            @else
                            <p class="text-arsa-500 italic">Deskripsi belum ditambahkan</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
