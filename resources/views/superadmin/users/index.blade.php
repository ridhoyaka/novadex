<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="font-semibold text-base text-white truncate">Kelola Users</h2>
            <a href="{{ route('superadmin.users.create') }}" class="flex-shrink-0 inline-flex items-center justify-center gap-2 px-4 py-2 bg-gold-500 hover:bg-gold-400 text-black font-bold rounded-lg text-xs transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah User
            </a>
        </div>
    </x-slot>

    <div class="py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/30 text-green-300 px-4 py-3 rounded-lg mb-6 text-sm font-medium">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 rounded-lg mb-6 text-sm font-medium">
                {{ session('error') }}
            </div>
            @endif

            <!-- Filters -->
            <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-4 sm:p-6 mb-6">
                <form method="GET" class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." 
                           class="flex-1 px-4 py-3 bg-arsa-800 border border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                    
                    <select name="role" class="px-4 py-3 bg-arsa-800 border border-arsa-700 rounded-lg text-white focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 transition-all">
                        <option value="">Semua Role</option>
                        <option value="umkm" {{ request('role') == 'umkm' ? 'selected' : '' }}>UMKM</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-r from-gold-500 to-gold-600 rounded-lg font-bold text-sm text-black hover:from-gold-600 hover:to-gold-700 transition-all">
                        Filter
                    </button>
                    <a href="{{ route('superadmin.users.index') }}" class="inline-flex items-center justify-center px-5 py-3 bg-arsa-800 border border-arsa-700 rounded-lg font-bold text-sm text-gray-300 hover:text-white hover:border-gold-500/50 transition-all text-center">
                        Reset
                    </a>
                </form>
            </div>

            <!-- Users Table - Desktop -->
            <div class="hidden md:block bg-arsa-900 border border-arsa-800 rounded-xl overflow-hidden">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-arsa-800 bg-arsa-800">
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-300 tracking-wide">USER</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-300 tracking-wide">EMAIL</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-300 tracking-wide">ROLE</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-300 tracking-wide">TERDAFTAR</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-300 tracking-wide">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="border-b border-arsa-800 hover:bg-arsa-800 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gold-500/10 rounded-full flex items-center justify-center text-gold-400 font-bold text-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-white font-semibold text-sm">{{ $user->name }}</p>
                                        @if($user->umkmProfile)
                                        <p class="text-gray-500 text-xs">{{ $user->umkmProfile->nama_usaha }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-300 text-sm">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if($user->role->value === 'umkm')
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-blue-500/10 text-blue-400">UMKM</span>
                                @elseif($user->role->value === 'admin')
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-purple-500/10 text-purple-400">Admin</span>
                                @else
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-gold-500/10 text-gold-400">Super Admin</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-400 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('superadmin.users.edit', $user) }}" 
                                       class="p-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500/20 transition-all" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('superadmin.users.destroy', $user) }}" onsubmit="return confirm('Yakin hapus user ini?')">
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
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                Tidak ada user ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Users Cards - Mobile -->
            <div class="md:hidden space-y-3">
                @forelse($users as $user)
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gold-500/10 rounded-full flex items-center justify-center text-gold-400 font-bold text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-white font-semibold text-sm">{{ $user->name }}</p>
                                <p class="text-gray-400 text-xs">{{ $user->email }}</p>
                            </div>
                        </div>
                        @if($user->role->value === 'umkm')
                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-blue-500/10 text-blue-400">UMKM</span>
                        @elseif($user->role->value === 'admin')
                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-purple-500/10 text-purple-400">Admin</span>
                        @else
                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-gold-500/10 text-gold-400">SA</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-arsa-800">
                        <span class="text-gray-500 text-xs">{{ $user->created_at->format('d M Y') }}</span>
                        <div class="flex gap-2">
                            <a href="{{ route('superadmin.users.edit', $user) }}" class="px-3 py-1.5 bg-blue-500/10 text-blue-400 rounded-lg text-xs font-bold hover:bg-blue-500/20 transition-all">Edit</a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('superadmin.users.destroy', $user) }}" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-red-500/10 text-red-400 rounded-lg text-xs font-bold hover:bg-red-500/20 transition-all">Hapus</button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-arsa-900 border border-arsa-800 rounded-xl p-8 text-center">
                    <p class="text-gray-500">Tidak ada user ditemukan.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <div class="mt-6">
                {{ $users->links() }}
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
