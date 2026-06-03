<?php

namespace App\Services;

class CategoryIconService
{
    /**
     * Get icon emoji for a category
     */
    public static function getIcon(string $categoryName): string
    {
        $categoryLower = strtolower($categoryName);
        
        // Kuliner & Makanan
        if (str_contains($categoryLower, 'kuliner') || 
            str_contains($categoryLower, 'makanan') || 
            str_contains($categoryLower, 'food') ||
            str_contains($categoryLower, 'restoran') ||
            str_contains($categoryLower, 'cafe') ||
            str_contains($categoryLower, 'katering')) {
            return '🍽️';
        }
        
        // Fashion & Pakaian
        if (str_contains($categoryLower, 'fashion') || 
            str_contains($categoryLower, 'pakaian') || 
            str_contains($categoryLower, 'baju') ||
            str_contains($categoryLower, 'busana') ||
            str_contains($categoryLower, 'tekstil')) {
            return '👗';
        }
        
        // Kerajinan Tangan
        if (str_contains($categoryLower, 'kerajinan') || 
            str_contains($categoryLower, 'handmade') || 
            str_contains($categoryLower, 'craft') ||
            str_contains($categoryLower, 'seni')) {
            return '🎨';
        }
        
        // Jasa
        if (str_contains($categoryLower, 'jasa') || 
            str_contains($categoryLower, 'service') || 
            str_contains($categoryLower, 'perbaikan') ||
            str_contains($categoryLower, 'konsultan')) {
            return '🔧';
        }
        
        // Teknologi & IT
        if (str_contains($categoryLower, 'teknologi') || 
            str_contains($categoryLower, 'it') || 
            str_contains($categoryLower, 'digital') ||
            str_contains($categoryLower, 'software') ||
            str_contains($categoryLower, 'komputer')) {
            return '💻';
        }
        
        // Pendidikan
        if (str_contains($categoryLower, 'pendidikan') || 
            str_contains($categoryLower, 'kursus') || 
            str_contains($categoryLower, 'bimbel') ||
            str_contains($categoryLower, 'les') ||
            str_contains($categoryLower, 'training')) {
            return '📚';
        }
        
        // Kesehatan & Kecantikan
        if (str_contains($categoryLower, 'kesehatan') || 
            str_contains($categoryLower, 'kecantikan') || 
            str_contains($categoryLower, 'salon') ||
            str_contains($categoryLower, 'spa') ||
            str_contains($categoryLower, 'beauty')) {
            return '💆';
        }
        
        // Pertanian & Perkebunan
        if (str_contains($categoryLower, 'pertanian') || 
            str_contains($categoryLower, 'perkebunan') || 
            str_contains($categoryLower, 'agro') ||
            str_contains($categoryLower, 'tani') ||
            str_contains($categoryLower, 'organik')) {
            return '🌾';
        }
        
        // Otomotif
        if (str_contains($categoryLower, 'otomotif') || 
            str_contains($categoryLower, 'bengkel') || 
            str_contains($categoryLower, 'motor') ||
            str_contains($categoryLower, 'mobil') ||
            str_contains($categoryLower, 'automotive')) {
            return '🚗';
        }
        
        // Properti & Real Estate
        if (str_contains($categoryLower, 'properti') || 
            str_contains($categoryLower, 'real estate') || 
            str_contains($categoryLower, 'rumah') ||
            str_contains($categoryLower, 'kontrakan')) {
            return '🏠';
        }
        
        // Perdagangan & Retail
        if (str_contains($categoryLower, 'perdagangan') || 
            str_contains($categoryLower, 'retail') || 
            str_contains($categoryLower, 'toko') ||
            str_contains($categoryLower, 'warung') ||
            str_contains($categoryLower, 'minimarket')) {
            return '🏪';
        }
        
        // Elektronik
        if (str_contains($categoryLower, 'elektronik') || 
            str_contains($categoryLower, 'gadget') || 
            str_contains($categoryLower, 'hp') ||
            str_contains($categoryLower, 'handphone')) {
            return '📱';
        }
        
        // Furniture & Interior
        if (str_contains($categoryLower, 'furniture') || 
            str_contains($categoryLower, 'mebel') || 
            str_contains($categoryLower, 'interior') ||
            str_contains($categoryLower, 'perabot')) {
            return '🪑';
        }
        
        // Fotografi & Videografi
        if (str_contains($categoryLower, 'foto') || 
            str_contains($categoryLower, 'video') || 
            str_contains($categoryLower, 'photography') ||
            str_contains($categoryLower, 'studio')) {
            return '📷';
        }
        
        // Event Organizer
        if (str_contains($categoryLower, 'event') || 
            str_contains($categoryLower, 'eo') || 
            str_contains($categoryLower, 'wedding') ||
            str_contains($categoryLower, 'organizer')) {
            return '🎉';
        }
        
        // Percetakan & Printing
        if (str_contains($categoryLower, 'cetak') || 
            str_contains($categoryLower, 'print') || 
            str_contains($categoryLower, 'sablon') ||
            str_contains($categoryLower, 'percetakan')) {
            return '🖨️';
        }
        
        // Minuman
        if (str_contains($categoryLower, 'minuman') || 
            str_contains($categoryLower, 'drink') || 
            str_contains($categoryLower, 'kopi') ||
            str_contains($categoryLower, 'coffee') ||
            str_contains($categoryLower, 'juice')) {
            return '☕';
        }
        
        // Oleh-oleh & Souvenir
        if (str_contains($categoryLower, 'oleh-oleh') || 
            str_contains($categoryLower, 'souvenir') || 
            str_contains($categoryLower, 'gift') ||
            str_contains($categoryLower, 'hampers')) {
            return '🎁';
        }
        
        // Laundry & Cuci
        if (str_contains($categoryLower, 'laundry') || 
            str_contains($categoryLower, 'cuci') || 
            str_contains($categoryLower, 'dry clean')) {
            return '🧺';
        }
        
        // Logistik & Pengiriman
        if (str_contains($categoryLower, 'logistik') || 
            str_contains($categoryLower, 'pengiriman') || 
            str_contains($categoryLower, 'ekspedisi') ||
            str_contains($categoryLower, 'cargo')) {
            return '📦';
        }
        
        // Default icon
        return '🏢';
    }
    
    /**
     * Get all category icons mapping
     */
    public static function getAllIcons(): array
    {
        return [
            'Kuliner' => '🍽️',
            'Fashion' => '👗',
            'Kerajinan' => '🎨',
            'Jasa' => '🔧',
            'Teknologi' => '💻',
            'Pendidikan' => '📚',
            'Kesehatan' => '💆',
            'Pertanian' => '🌾',
            'Otomotif' => '🚗',
            'Properti' => '🏠',
            'Perdagangan' => '🏪',
            'Elektronik' => '📱',
            'Furniture' => '🪑',
            'Fotografi' => '📷',
            'Event' => '🎉',
            'Percetakan' => '🖨️',
            'Minuman' => '☕',
            'Oleh-oleh' => '🎁',
            'Laundry' => '🧺',
            'Logistik' => '📦',
        ];
    }
}
