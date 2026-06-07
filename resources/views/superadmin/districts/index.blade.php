<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight" style="font-family: 'Space Grotesk', sans-serif;">
            Kelola Kecamatan
        </h2>
    </x-slot>

    <div class="py-6 lg:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 sm:px-6 py-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 sm:px-6 py-4 rounded-lg mb-6">
                {{ session('error') }}
            </div>
            @endif

            <!-- Add District Form -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 sm:p-6 mb-6">
                <h3 class="text-lg font-bold text-white mb-4">Tambah Kecamatan Baru</h3>
                <form method="POST" action="{{ route('superadmin.districts.store') }}" class="grid gap-3 sm:grid-cols-[1.4fr_0.9fr_0.9fr_auto]">
                    @csrf
                    <input type="text" name="nama_kecamatan" placeholder="Nama Kecamatan" required 
                           class="flex-1 px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                    <input type="number" step="any" name="latitude" placeholder="Latitude"
                           class="px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                    <input type="number" step="any" name="longitude" placeholder="Longitude"
                           class="px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                    <button type="submit" class="bg-gradient-to-r from-gold-500 to-gold-600 text-black font-bold px-6 py-3 rounded-lg hover:from-gold-600 hover:to-gold-700 transition-all whitespace-nowrap">
                        + Tambah
                    </button>
                </form>
                @error('nama_kecamatan')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
                @error('latitude')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
                @error('longitude')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Districts List - Desktop -->
            <div class="hidden sm:block bg-arsa-900 border border-arsa-800 rounded-xl overflow-hidden">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-arsa-800 bg-arsa-800">
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-300 tracking-wide">NAMA KECAMATAN</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-300 tracking-wide">JUMLAH UMKM</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-300 tracking-wide">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($districts as $district)
                        <tr class="border-b border-arsa-800 hover:bg-arsa-800 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-white font-semibold">{{ $district->nama_kecamatan }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gold-400 font-bold">{{ $district->umkm_profiles_count }}</span>
                                <span class="text-gray-400 text-sm ml-1">UMKM</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button onclick="editDistrict({{ $district->id }}, '{{ addslashes($district->nama_kecamatan) }}', '{{ $district->latitude }}', '{{ $district->longitude }}')" 
                                            class="p-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500/20 transition-all" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    @if($district->umkm_profiles_count == 0)
                                    <form method="POST" action="{{ route('superadmin.districts.destroy', $district) }}" onsubmit="return confirm('Yakin hapus kecamatan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500/20 transition-all" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Districts List - Mobile -->
            <div class="sm:hidden space-y-3">
                @foreach($districts as $district)
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white font-semibold">{{ $district->nama_kecamatan }}</p>
                            <p class="text-gray-400 text-sm">{{ $district->umkm_profiles_count }} UMKM</p>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="editDistrict({{ $district->id }}, '{{ addslashes($district->nama_kecamatan) }}', '{{ $district->latitude }}', '{{ $district->longitude }}')" 
                                    class="p-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500/20 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            @if($district->umkm_profiles_count == 0)
                            <form method="POST" action="{{ route('superadmin.districts.destroy', $district) }}" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500/20 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6 w-full max-w-md">
            <h3 class="text-lg font-bold text-white mb-4">Edit Kecamatan</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="text" id="editNama" name="nama_kecamatan" required 
                       class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all mb-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                    <input type="number" step="any" id="editLatitude" name="latitude" placeholder="Latitude"
                           class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                    <input type="number" step="any" id="editLongitude" name="longitude" placeholder="Longitude"
                           class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-gold-500 to-gold-600 text-black font-bold px-6 py-3 rounded-lg hover:from-gold-600 hover:to-gold-700 transition-all">
                        Simpan
                    </button>
                    <button type="button" onclick="closeModal()" class="flex-1 bg-arsa-800 border-2 border-arsa-700 text-white font-bold px-6 py-3 rounded-lg hover:border-gold-500 transition-all">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editDistrict(id, nama, latitude, longitude) {
            document.getElementById('editForm').action = `/superadmin/districts/${id}`;
            document.getElementById('editNama').value = nama;
            document.getElementById('editLatitude').value = latitude || '';
            document.getElementById('editLongitude').value = longitude || '';
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
