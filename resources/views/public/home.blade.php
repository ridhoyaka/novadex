<x-guest-layout>
    <section class="relative overflow-hidden bg-[#10130f]">
        <div class="absolute inset-0">
            <img src="{{ asset('images/novadex-hero.png') }}" alt="NovaDex directory preview" class="h-full w-full object-cover opacity-45 md:opacity-70">
            <div class="absolute inset-0 bg-[linear-gradient(90deg,#10130f_0%,rgba(16,19,15,.94)_36%,rgba(16,19,15,.55)_68%,rgba(16,19,15,.22)_100%)]"></div>
            <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-[#10130f] to-transparent"></div>
        </div>

        <div class="relative mx-auto flex min-h-[620px] max-w-7xl items-center px-4 py-20 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <div class="mb-8 inline-flex items-center gap-3 border border-white/[0.15] bg-white/[0.08] px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-[#d4a945]">
                    <span class="h-2 w-2 bg-[#2f9e8f]"></span>
                    Direktori UMKM Salatiga
                </div>

                <h1 class="font-display text-5xl font-semibold leading-none text-white sm:text-6xl lg:text-7xl">
                    NovaDex
                </h1>

                <p class="mt-6 max-w-xl text-lg leading-8 text-white/80">
                    Direktori UMKM Salatiga yang siap dipakai warga, pelaku usaha, dan pengelola data kota. Fokus pada pencarian yang cepat, profil usaha yang jelas, dan tampilan data yang rapi.
                </p>

                <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('umkm.index') }}" class="inline-flex min-h-12 items-center justify-center bg-[#d4a945] px-6 text-sm font-semibold text-[#14130f] transition hover:bg-[#e2bd62] focus:outline-none focus:ring-2 focus:ring-[#d4a945] focus:ring-offset-2 focus:ring-offset-[#10130f]">
                        Buka Katalog
                    </a>
                    <a href="{{ route('umkm.map') }}" class="inline-flex min-h-12 items-center justify-center border border-white/20 bg-white/[0.08] px-6 text-sm font-semibold text-white transition hover:border-white/40 hover:bg-white/[0.12] focus:outline-none focus:ring-2 focus:ring-white/40 focus:ring-offset-2 focus:ring-offset-[#10130f]">
                        Lihat Peta
                    </a>
                </div>
            </div>
        </div>

        <div class="relative border-y border-white/10 bg-[#10130f]/95">
            <div class="mx-auto grid max-w-7xl grid-cols-3 divide-x divide-white/10 px-4 sm:px-6 lg:px-8">
                <div class="py-5">
                    <div class="text-2xl font-semibold text-white">{{ number_format($totalUmkm) }}</div>
                    <div class="mt-1 text-xs font-medium uppercase tracking-[0.18em] text-white/50">UMKM</div>
                </div>
                <div class="py-5 pl-5 sm:pl-8">
                    <div class="text-2xl font-semibold text-white">{{ number_format($totalCategories) }}</div>
                    <div class="mt-1 text-xs font-medium uppercase tracking-[0.18em] text-white/50">Kategori</div>
                </div>
                <div class="py-5 pl-5 sm:pl-8">
                    <div class="text-2xl font-semibold text-white">1</div>
                    <div class="mt-1 text-xs font-medium uppercase tracking-[0.18em] text-white/50">Kota</div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#f6f2e8] py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[0.78fr_1.22fr] lg:items-end">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#a57924]">Jalur Cepat</p>
                    <h2 class="mt-3 font-display text-3xl font-semibold text-[#141712] sm:text-4xl">Mulai dari kategori yang paling relevan.</h2>
                </div>
                <p class="max-w-2xl text-base leading-7 text-[#545d55] lg:justify-self-end">
                    Kategori dibuat ringkas agar pengguna langsung masuk ke daftar usaha, bukan berhenti di halaman pembuka.
                </p>
            </div>

            @if($featuredCategories->count() > 0)
                <div class="mt-10 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($featuredCategories as $category)
                        <a href="{{ route('umkm.index', ['category' => $category->id]) }}" class="group border border-[#ded6c6] bg-white p-5 transition hover:-translate-y-0.5 hover:border-[#2f9e8f] hover:shadow-[0_12px_30px_rgba(20,23,18,0.08)]">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex h-10 w-10 items-center justify-center bg-[#10130f] text-lg text-white">
                                    {{ $category->icon ?? strtoupper(mb_substr($category->nama_kategori, 0, 1)) }}
                                </div>
                                <span class="mt-1 text-xs font-semibold text-[#2f9e8f]">{{ $category->umkm_profiles_count }} usaha</span>
                            </div>
                            <h3 class="mt-5 text-lg font-semibold text-[#141712]">{{ $category->nama_kategori }}</h3>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    <a href="{{ route('umkm.categories') }}" class="inline-flex items-center border-b border-[#141712] pb-1 text-sm font-semibold text-[#141712] transition hover:border-[#2f9e8f] hover:text-[#2f9e8f]">
                        Lihat semua kategori
                    </a>
                </div>
            @endif
        </div>
    </section>

    <section class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#a57924]">Usaha Terbaru</p>
                    <h2 class="mt-3 font-display text-3xl font-semibold text-[#141712] sm:text-4xl">Profil yang siap dibaca client.</h2>
                </div>
                <a href="{{ route('umkm.index') }}" class="inline-flex min-h-11 items-center justify-center border border-[#141712] px-5 text-sm font-semibold text-[#141712] transition hover:bg-[#141712] hover:text-white">
                    Buka katalog penuh
                </a>
            </div>

            @if($newestUmkm->count() > 0)
                <div class="mt-10 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($newestUmkm as $umkm)
                        <article class="group overflow-hidden border border-[#e4ded2] bg-[#fbfaf7] transition hover:-translate-y-0.5 hover:border-[#2f9e8f] hover:shadow-[0_18px_42px_rgba(20,23,18,0.09)]">
                            <a href="{{ route('umkm.show', $umkm->slug) }}" class="block">
                                <div class="aspect-[4/3] bg-[#ebe4d7]">
                                    @if($umkm->logo_path)
                                        <img src="{{ Storage::url($umkm->logo_path) }}" alt="{{ $umkm->nama_usaha }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-[#10130f]">
                                            <span class="font-display text-5xl font-semibold text-[#d4a945]">{{ strtoupper(mb_substr($umkm->nama_usaha, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <div class="flex items-center justify-between gap-3">
                                        <span class="text-xs font-semibold uppercase tracking-[0.18em] text-[#a57924]">{{ $umkm->category->nama_kategori ?? 'UMKM' }}</span>
                                        @if($umkm->district)
                                            <span class="truncate text-xs text-[#687166]">{{ $umkm->district->nama_kecamatan }}</span>
                                        @endif
                                    </div>
                                    <h3 class="mt-3 text-xl font-semibold text-[#141712] group-hover:text-[#2f9e8f]">{{ $umkm->nama_usaha }}</h3>
                                    @if($umkm->deskripsi)
                                        <p class="mt-3 text-sm leading-6 text-[#5f675f]">{{ Str::limit(strip_tags($umkm->deskripsi), 118) }}</p>
                                    @endif
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="mt-10 border border-[#e4ded2] bg-[#fbfaf7] p-8 text-center text-[#5f675f]">
                    Belum ada UMKM yang ditampilkan.
                </div>
            @endif
        </div>
    </section>

    <section class="bg-[#10130f] py-16 text-white sm:py-20">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#d4a945]">Alur Penggunaan</p>
                <h2 class="mt-3 font-display text-3xl font-semibold sm:text-4xl">Dibuat untuk dipakai, bukan hanya dilihat.</h2>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <div class="border border-white/[0.12] p-5">
                    <div class="text-sm font-semibold text-[#d4a945]">Warga</div>
                    <p class="mt-3 text-sm leading-6 text-white/70">Cari usaha berdasarkan kategori, lokasi, dan kontak yang bisa langsung dihubungi.</p>
                </div>
                <div class="border border-white/[0.12] p-5">
                    <div class="text-sm font-semibold text-[#d4a945]">UMKM</div>
                    <p class="mt-3 text-sm leading-6 text-white/70">Profil usaha tampil bersih dengan foto, alamat, jam operasional, dan kanal digital.</p>
                </div>
                <div class="border border-white/[0.12] p-5">
                    <div class="text-sm font-semibold text-[#d4a945]">Admin</div>
                    <p class="mt-3 text-sm leading-6 text-white/70">Data mudah dikurasi, diverifikasi, dan dipresentasikan tanpa tampilan yang berisik.</p>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
