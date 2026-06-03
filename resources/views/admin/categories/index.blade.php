<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight" style="font-family: 'Space Grotesk', sans-serif;">
            Manajemen Kategori
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-gold-900/20 border border-gold-500 text-gold-300 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 bg-red-900/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Add Category Form -->
                <div class="lg:col-span-1">
                    <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-6">
                        <h3 class="text-lg font-bold text-white mb-4" style="font-family: 'Space Grotesk', sans-serif;">
                            Tambah Kategori Baru
                        </h3>
                        <form action="{{ route('admin.categories.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-white mb-2 tracking-wide">NAMA KATEGORI</label>
                                <input type="text" 
                                       name="nama_kategori" 
                                       value="{{ old('nama_kategori') }}"
                                       required
                                       placeholder="Contoh: Kuliner"
                                       class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                                @error('nama_kategori')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-gold-500 to-gold-600 text-black font-bold py-3 rounded-lg hover:from-gold-600 hover:to-gold-700 transition-all">
                                TAMBAH KATEGORI
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Categories List -->
                <div class="lg:col-span-2">
                    <div class="bg-arsa-900 border border-arsa-800 rounded-xl overflow-hidden">
                        <div class="p-6 border-b border-arsa-800">
                            <h3 class="text-lg font-bold text-white" style="font-family: 'Space Grotesk', sans-serif;">
                                Daftar Kategori ({{ $categories->count() }})
                            </h3>
                        </div>
                        <div class="divide-y divide-arsa-800">
                            @forelse($categories as $category)
                            <div class="p-6 hover:bg-arsa-800 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-white font-semibold text-lg mb-1">{{ $category->nama_kategori }}</h4>
                                        <p class="text-gray-400 text-sm">
                                            {{ $category->umkm_profiles_count }} UMKM terdaftar
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <!-- Edit Button -->
                                        <button onclick="openEditModal({{ $category->id }}, '{{ $category->nama_kategori }}')"
                                                class="p-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500/20 transition-all"
                                                title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.categories.destroy', $category) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500/20 transition-all {{ $category->umkm_profiles_count > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                    title="Hapus"
                                                    {{ $category->umkm_profiles_count > 0 ? 'disabled' : '' }}>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="p-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <p class="text-lg font-semibold">Belum ada kategori</p>
                                    <p class="text-sm mt-1">Tambahkan kategori pertama Anda</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50" onclick="closeEditModal(event)">
        <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-8 max-w-md w-full mx-4" onclick="event.stopPropagation()">
            <h3 class="text-xl font-bold text-white mb-4" style="font-family: 'Space Grotesk', sans-serif;">
                Edit Kategori
            </h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-bold text-white mb-2 tracking-wide">NAMA KATEGORI</label>
                    <input type="text" 
                           id="editNamaKategori"
                           name="nama_kategori" 
                           required
                           class="w-full px-4 py-3 bg-arsa-800 border-2 border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                </div>
                <div class="flex gap-3">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-gold-500 to-gold-600 text-black font-bold py-3 rounded-lg hover:from-gold-600 hover:to-gold-700 transition-all">
                        SIMPAN
                    </button>
                    <button type="button" 
                            onclick="closeEditModal()"
                            class="flex-1 bg-arsa-800 text-white font-bold py-3 rounded-lg border-2 border-arsa-700 hover:border-gold-500 transition-all">
                        BATAL
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, nama) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
            document.getElementById('editForm').action = `/admin/categories/${id}`;
            document.getElementById('editNamaKategori').value = nama;
        }

        function closeEditModal(event) {
            if (!event || event.target.id === 'editModal') {
                document.getElementById('editModal').classList.add('hidden');
                document.getElementById('editModal').classList.remove('flex');
            }
        }
    </script>
</x-app-layout>
