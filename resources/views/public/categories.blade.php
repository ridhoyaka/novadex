<x-guest-layout>
    <div class="min-h-screen bg-[#f6f2e8]">
        <section class="border-b border-[#ddd5c6] bg-[#10130f] py-14 text-white sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#d4a945]">Kategori UMKM</p>
                    <h1 class="mt-4 font-display text-4xl font-semibold leading-tight sm:text-5xl">
                        Pilih kelompok usaha yang ingin ditelusuri.
                    </h1>
                    <p class="mt-5 text-base leading-7 text-white/70">
                        Tampilan kategori dibuat lebih padat agar client bisa langsung membaca sebaran UMKM tanpa distraksi visual.
                    </p>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 sm:py-16 lg:px-8">
            @if($categories->count() > 0)
                @php
                    $totalUmkm = $categories->sum('umkm_profiles_count');
                @endphp

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($categories as $category)
                        @php
                            $percentage = $totalUmkm > 0 ? ($category->umkm_profiles_count / $totalUmkm) * 100 : 0;
                        @endphp

                        <a href="{{ route('umkm.index', ['category' => $category->id]) }}"
                           class="group border border-[#ded6c6] bg-white p-6 transition hover:-translate-y-0.5 hover:border-[#2f9e8f] hover:shadow-[0_14px_34px_rgba(20,23,18,0.08)]">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex h-12 w-12 items-center justify-center bg-[#10130f] text-xl text-white">
                                    {{ $category->icon ?? strtoupper(mb_substr($category->nama_kategori, 0, 1)) }}
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-semibold text-[#141712]">{{ $category->umkm_profiles_count }}</div>
                                    <div class="text-xs font-semibold uppercase tracking-[0.16em] text-[#8a7552]">UMKM</div>
                                </div>
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-[#141712] group-hover:text-[#2f9e8f]">
                                {{ $category->nama_kategori }}
                            </h2>

                            <div class="mt-5 h-1.5 bg-[#ebe3d6]">
                                <div class="h-1.5 bg-[#2f9e8f]" style="width: {{ $percentage }}%"></div>
                            </div>
                            <p class="mt-3 text-sm text-[#657066]">{{ round($percentage, 1) }}% dari total UMKM terdaftar</p>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="border border-[#ded6c6] bg-white p-10 text-center">
                    <h3 class="text-2xl font-semibold text-[#141712]">Belum Ada Kategori</h3>
                    <p class="mt-3 text-[#657066]">Kategori UMKM akan ditampilkan di sini.</p>
                    <a href="{{ route('home') }}" class="mt-8 inline-flex min-h-11 items-center justify-center bg-[#d4a945] px-6 text-sm font-semibold text-[#14130f] transition hover:bg-[#e2bd62]">
                        Kembali ke Beranda
                    </a>
                </div>
            @endif
        </section>

        <section class="border-t border-[#ddd5c6] bg-white py-12">
            <div class="mx-auto flex max-w-7xl flex-col gap-5 px-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <div>
                    <h2 class="text-2xl font-semibold text-[#141712]">Butuh pencarian lebih spesifik?</h2>
                    <p class="mt-2 text-sm leading-6 text-[#657066]">Gunakan katalog atau peta untuk mempersempit hasil berdasarkan nama usaha, kategori, dan kecamatan.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('umkm.index') }}" class="inline-flex min-h-11 items-center justify-center border border-[#141712] px-5 text-sm font-semibold text-[#141712] transition hover:bg-[#141712] hover:text-white">
                        Lihat Semua UMKM
                    </a>
                    <a href="{{ route('umkm.map') }}" class="inline-flex min-h-11 items-center justify-center bg-[#10130f] px-5 text-sm font-semibold text-white transition hover:bg-[#222820]">
                        Lihat Peta UMKM
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-guest-layout>
