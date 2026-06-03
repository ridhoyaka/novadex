# Panduan Icon Kategori UMKM

## Overview
Setiap kategori UMKM di platform ARSA memiliki icon emoji yang unik untuk memudahkan identifikasi visual.

## Daftar Icon Kategori

| Kategori | Icon | Deskripsi |
|----------|------|-----------|
| Kuliner & Makanan | 🍽️ | Restoran, katering, makanan tradisional |
| Fashion & Pakaian | 👗 | Pakaian, busana, tekstil |
| Kerajinan Tangan | 🎨 | Handmade, craft, seni |
| Jasa & Layanan | 🔧 | Perbaikan, konsultan, service |
| Teknologi & IT | 💻 | Software, digital, komputer |
| Pendidikan | 📚 | Kursus, bimbel, training |
| Kesehatan & Kecantikan | 💆 | Salon, spa, beauty |
| Pertanian | 🌾 | Agro, organik, perkebunan |
| Otomotif | 🚗 | Bengkel, motor, mobil |
| Properti | 🏠 | Real estate, rumah, kontrakan |
| Perdagangan | 🏪 | Toko, warung, retail |
| Elektronik | 📱 | Gadget, HP, handphone |
| Furniture | 🪑 | Mebel, interior, perabot |
| Fotografi | 📷 | Photography, videografi, studio |
| Event Organizer | 🎉 | Wedding, organizer |
| Percetakan | 🖨️ | Printing, sablon |
| Minuman | ☕ | Kopi, juice, coffee shop |
| Oleh-oleh | 🎁 | Souvenir, gift, hampers |
| Laundry | 🧺 | Cuci, dry clean |
| Logistik | 📦 | Pengiriman, ekspedisi, cargo |
| Default | 🏢 | Kategori lainnya |

## Cara Kerja

### 1. CategoryIconService
Service ini secara otomatis menentukan icon berdasarkan nama kategori:

```php
use App\Services\CategoryIconService;

$icon = CategoryIconService::getIcon('Kuliner');
// Returns: 🍽️
```

### 2. Automatic Icon Assignment
Saat kategori baru dibuat, icon akan otomatis ditentukan berdasarkan nama kategori menggunakan pattern matching.

### 3. Manual Update
Admin dapat mengupdate icon kategori melalui:
- Database seeder: `php artisan db:seed --class=UpdateCategoryIconsSeeder`
- Manual edit di admin panel (jika fitur tersedia)

## Implementasi di View

### Home Page
```blade
<div class="text-5xl mb-4">{{ $category->icon ?? '🏢' }}</div>
```

### Categories Page
```blade
<span class="text-5xl">{{ $category->icon ?? '🏢' }}</span>
```

### Catalog Page
Icon kategori ditampilkan di card UMKM untuk identifikasi cepat.

## Menambah Icon Baru

Untuk menambah mapping icon baru, edit file `app/Services/CategoryIconService.php`:

```php
// Contoh: Menambah kategori Perhiasan
if (str_contains($categoryLower, 'perhiasan') || 
    str_contains($categoryLower, 'jewelry') || 
    str_contains($categoryLower, 'emas')) {
    return '💎';
}
```

Kemudian jalankan seeder untuk update:
```bash
php artisan db:seed --class=UpdateCategoryIconsSeeder
```

## Best Practices

1. **Konsistensi**: Gunakan emoji yang mudah dikenali dan relevan
2. **Fallback**: Selalu sediakan default icon (🏢) untuk kategori yang tidak cocok
3. **Testing**: Test tampilan icon di berbagai device dan browser
4. **Accessibility**: Icon hanya untuk visual, pastikan text label tetap ada

## Update History

- **2026-02-08**: Initial implementation dengan 20+ kategori icon
- Icon disimpan di database kolom `categories.icon`
- Automatic icon assignment berdasarkan nama kategori
