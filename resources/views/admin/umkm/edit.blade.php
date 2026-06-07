<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight" style="font-family: 'Space Grotesk', sans-serif;">
                Edit UMKM: {{ $umkm->nama_usaha }}
            </h2>
            <a href="{{ route('admin.umkm.show', $umkm) }}" class="text-gold-400 hover:text-gold-300 text-sm font-semibold">
                ← Kembali ke Detail
            </a>
        </div>
    </x-slot>

    <div class="py-6 lg:py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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

            @if($errors->any())
            <div class="mb-4 bg-red-900/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg