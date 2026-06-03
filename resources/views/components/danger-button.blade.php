<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-red-500/10 border border-red-500/30 rounded-lg font-bold text-sm text-red-400 hover:bg-red-500/20 hover:border-red-500/50 focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:ring-offset-2 focus:ring-offset-arsa-900 active:bg-red-500/30 transition-all duration-200']) }}>
    {{ $slot }}
</button>
