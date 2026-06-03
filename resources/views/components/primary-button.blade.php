<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-gold-500 to-gold-600 border border-transparent rounded-lg font-bold text-sm text-black hover:from-gold-600 hover:to-gold-700 focus:outline-none focus:ring-2 focus:ring-gold-500/50 focus:ring-offset-2 focus:ring-offset-arsa-900 active:from-gold-700 active:to-gold-800 transition-all duration-200 shadow-sm hover:shadow-md']) }}>
    {{ $slot }}
</button>
