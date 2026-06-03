# Cara Login dan Akses Dashboard

## Masalah yang Diperbaiki
Route `/umkm/dashboard` sebelumnya konflik dengan route `/umkm/{slug}` (detail UMKM publik). Sekarang sudah diperbaiki dengan:
- Mengubah route katalog publik dari `/umkm` menjadi `/katalog`
- Memindahkan route UMKM dashboard sebelum route detail publik

## Credentials Login

### User UMKM
Gunakan salah satu dari akun berikut:

1. **Warung Makan Bu Siti**
   - Email: `busiti@example.com`
   - Password: `password`

2. **Batik Salatiga Indah**
   - Email: `batik@example.com`
   - Password: `password`

3. **Kerajinan Bambu Kreatif**
   - Email: `bambu@example.com`
   - Password: `password`

4. **Jasa Desain Grafis Digital**
   - Email: `design@example.com`
   - Password: `password`

5. **Salon Cantik Permata**
   - Email: `salon@example.com`
   - Password: `password`

### User Admin
- Email: `admin@arsa.com`
- Password: `password`

### Super Admin
- Email: `superadmin@arsa.com`
- Password: `password`

## Cara Akses Dashboard

### Untuk UMKM:
1. Login dengan salah satu akun UMKM di atas
2. Setelah login, Anda akan diarahkan ke `/umkm/dashboard`
3. Di dashboard, Anda bisa:
   - Melihat status profil (lengkap/belum)
   - Melihat persentase kelengkapan profil
   - Edit profil usaha
   - Upload logo dan foto galeri
   - Publish/unpublish profil

### Untuk Admin:
1. Login dengan akun admin
2. Setelah login, Anda akan diarahkan ke `/admin/dashboard`
3. Di dashboard admin, Anda bisa:
   - Melihat statistik UMKM
   - Kelola data UMKM (lihat, publish/unpublish, hapus)
   - Kelola kategori
   - Lihat grafik dan laporan

## URL Penting

### Public (Tanpa Login):
- Beranda: `http://127.0.0.1:8000/`
- Katalog UMKM: `http://127.0.0.1:8000/katalog` (sebelumnya `/umkm`)
- Peta UMKM: `http://127.0.0.1:8000/peta-umkm`
- Detail UMKM: `http://127.0.0.1:8000/umkm/{slug}`

### UMKM (Perlu Login):
- Dashboard: `http://127.0.0.1:8000/umkm/dashboard`
- Edit Profil: `http://127.0.0.1:8000/umkm/profil/edit`

### Admin (Perlu Login):
- Dashboard: `http://127.0.0.1:8000/admin/dashboard`
- Kelola UMKM: `http://127.0.0.1:8000/admin/umkm`
- Kelola Kategori: `http://127.0.0.1:8000/admin/categories`

## Troubleshooting

### Jika masih muncul 404:
1. Clear cache Laravel:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   ```

2. Pastikan server berjalan:
   ```bash
   php artisan serve
   ```

3. Cek route list:
   ```bash
   php artisan route:list --name=umkm
   ```

### Jika tidak bisa login:
1. Pastikan database sudah di-seed:
   ```bash
   php artisan migrate:fresh --seed
   ```

2. Pastikan table cache ada:
   ```bash
   php artisan tinker --execute="echo Schema::hasTable('cache') ? 'YES' : 'NO';"
   ```
