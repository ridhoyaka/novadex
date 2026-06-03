# Perubahan Layout - Sidebar Horizontal Modern

## Perubahan yang Dilakukan

Layout aplikasi telah diubah dari **top navigation** menjadi **sidebar horizontal di kiri** untuk semua halaman admin/UMKM/super admin. Halaman publik tetap menggunakan layout guest yang lama.

## Fitur Layout Baru

### 1. Sidebar Kiri (Width: 256px)
- **Logo ARSA** di bagian atas
- **Menu navigasi** dengan icon dan label
- **Active state** dengan background highlight dan warna gold
- **Hover effect** yang smooth
- **Divider** untuk memisahkan menu utama dan menu tambahan
- **User profile section** di bagian bawah dengan:
  - Avatar dengan initial
  - Nama dan email user
  - Link ke pengaturan
  - Tombol logout

### 2. Main Content Area
- **Top bar** dengan:
  - Page header/title
  - Role badge (Super Admin/Admin/UMKM)
- **Content area** yang scrollable
- Full height layout dengan overflow handling

### 3. Color Scheme
- Background sidebar: `arsa-950` (#050505) - Lebih gelap
- Background main: `arsa-900` (#0d0d0d)
- Border: `arsa-800` (#212529)
- Active/Hover: `arsa-800` dengan text `gold-400`

## Menu untuk Setiap Role

### Super Admin
- Dashboard
- Users (manajemen user)
- UMKM (lihat semua UMKM)
- Kategori (master data)
- Kecamatan (master data)
- Lihat Website (link ke public)

### Admin
- Dashboard
- UMKM (kelola UMKM)
- Kategori (kelola kategori)
- Lihat Website (link ke public)

### UMKM
- Dashboard
- Profil UMKM (kelola profil sendiri)
- Lihat Website (link ke public)

## Keuntungan Layout Baru

1. **Lebih Modern** - Mengikuti trend aplikasi web modern seperti Notion, Linear, dll
2. **Navigasi Lebih Jelas** - Menu selalu terlihat di sidebar
3. **Space Lebih Luas** - Content area lebih lebar untuk menampilkan data
4. **User Context Jelas** - Profile user selalu terlihat di bawah
5. **Role Badge** - User langsung tahu role mereka dari top bar
6. **Better UX** - Tidak perlu membuka dropdown untuk navigasi

## File yang Diubah

1. **resources/views/layouts/app.blade.php** - Layout baru dengan sidebar
2. **tailwind.config.js** - Menambahkan warna `arsa-950`
3. **resources/views/layouts/navigation.blade.php** - Tidak digunakan lagi (diganti dengan sidebar di app.blade.php)

## Halaman yang Menggunakan Layout Baru

Semua halaman yang menggunakan `<x-app-layout>`:
- Super Admin: Dashboard, Users, Districts
- Admin: Dashboard, UMKM, Categories
- UMKM: Dashboard, Profile

## Halaman yang Tetap Menggunakan Layout Lama

Semua halaman publik yang menggunakan `<x-guest-layout>`:
- Landing page
- Katalog UMKM
- Detail UMKM
- Peta UMKM
- Login & Register

## Testing

Untuk melihat layout baru:
1. Login sebagai Super Admin: `superadmin@arsa.com` / `password`
2. Login sebagai Admin: `admin@arsa.com` / `password`
3. Login sebagai UMKM: `busiti@example.com` / `password`

Setiap role akan melihat sidebar dengan menu yang sesuai dengan hak akses mereka.
