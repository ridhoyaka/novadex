@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-3 bg-arsa-800 border border-arsa-700 rounded-lg text-white placeholder-gray-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/20 focus:outline-none transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed']) }}>
