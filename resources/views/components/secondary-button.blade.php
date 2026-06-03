<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-arsa-800 border border-arsa-700 rounded-lg font-bold text-sm text-gray-300 hover:bg-arsa-700 hover:text-white hover:border-gold-500/50 focus:outline-none focus:ring-2 focus:ring-gold-500/30 focus:ring-offset-2 focus:ring-offset-arsa-900 disabled:opacity-50 transition-all duration-200']) }}>
    {{ $slot }}
</button>
