# Fitur Super Admin - ARSA Platform

## Overview
Super Admin memiliki akses penuh ke seluruh sistem ARSA, termasuk semua fitur admin ditambah manajemen user dan master data.

## Credentials
- Email: `superadmin@arsa.com`
- Password: `password`

## Fitur Lengkap Super Admin

### 1. Dashboard Super Admin
**URL:** `/superadmin/dashboard`

**Fitur:**
- Statistik sistem lengkap:
  - Total users (breakdown: UMKM, Admin)
  - Total UMKM (published vs unpublished)
  - Total kategori
  - Total kecamatan
- Grafik UMKM per kategori (bar chart)
- Grafik UMKM per kecamatan (bar chart)
- Quick actions untuk navigasi cepat

### 2. Manajemen Users
**URL:** `/superadmin/users`

**Fitur:**
- Lihat semua users (UMKM, Admin, Super Admin)
- Filter by role
- Search by nama atau email
- Tambah user baru dengan role apapun
- Edit user (nama, email, password, role)
- Hapus user (kecuali diri sendiri)
- Pagination

**CRUD Operations:**
- **Create:** Tambah user baru dengan form lengkap
- **Read:** List semua users dengan info lengkap
- **Update:** Edit data user termasuk ganti role
- **Delete:** Hapus user dengan konfirmasi

### 3. Manajemen UMKM
**URL:** `/admin/umkm`

**Fitur:** (Sama seperti Admin)
- Lihat semua UMKM
- Filter by kategori, kecamatan, status
- Search by nama usaha
- Lihat detail UMKM (tanpa kontak pribadi)
- Toggle publish/unpublish
- Hapus UMKM
- Pagination

**Privacy Protection:**
- WhatsApp dan email UMKM TIDAK ditampilkan
- Hanya data agregat untuk perencanaan

### 4. Manajemen Kategori
**URL:** `/admin/categories`

**Fitur:** (Sama seperti Admin)
- Lihat semua kategori
- Tambah kategori baru
- Edit kategori
- Hapus kategori (jika tidak ada UMKM)
- Lihat jumlah UMKM per kategori

### 5. Manajemen Kecamatan
**URL:** `/superadmin/districts`

**Fitur:**
- Lihat semua kecamatan
- Tambah kecamatan baru
- Edit kecamatan
- Hapus kecamatan (jika tidak ada UMKM)
- Lihat jumlah UMKM per kecamatan

## Perbedaan Super Admin vs Admin

| Fitur | Super Admin | Admin |
|-------|-------------|-------|
| Dashboard | ✅ Dashboard Super Admin | ✅ Dashboard Admin |
| Manajemen Users | ✅ Full CRUD | ❌ Tidak ada |
| Manajemen UMKM | ✅ Lihat, Toggle, Hapus | ✅ Lihat, Toggle, Hapus |
| Manajemen Kategori | ✅ Full CRUD | ✅ Full CRUD |
| Manajemen Kecamatan | ✅ Full CRUD | ❌ Tidak ada |
| Lihat Kontak UMKM | ❌ Dilindungi | ❌ Dilindungi |
| Edit Data UMKM | ❌ Tidak bisa | ❌ Tidak bisa |

## Menu Sidebar Super Admin

1. **Dashboard** - Statistik dan overview sistem
2. **Users** - Manajemen semua user
3. **UMKM** - Lihat dan kelola UMKM
4. **Kategori** - Master data kategori
5. **Kecamatan** - Master data kecamatan
6. **Lihat Website** - Link ke halaman publik

## Keamanan & Authorization

### Middleware
Super admin menggunakan middleware khusus:
- Route super admin: `role:super_admin`
- Route admin (shared): `role.any:admin,super_admin`

### Proteksi Data
- Tidak bisa hapus akun sendiri
- Tidak bisa lihat kontak pribadi UMKM
- Tidak bisa edit data UMKM langsung
- Hanya bisa toggle publish/unpublish dan hapus

### Activity Log
Semua aksi super admin dicatat di `activity_logs` table:
- User management (create, update, delete)
- UMKM management (toggle, delete)
- Master data changes (kategori, kecamatan)

## Best Practices

### Manajemen User
1. Gunakan email yang valid untuk setiap user
2. Password minimal 8 karakter
3. Pilih role yang sesuai dengan tanggung jawab
4. Jangan hapus user yang masih aktif tanpa backup data

### Master Data
1. Kategori: Gunakan nama yang jelas dan konsisten
2. Kecamatan: Sesuaikan dengan wilayah Salatiga
3. Jangan hapus kategori/kecamatan yang masih digunakan UMKM

### Monitoring
1. Cek dashboard secara berkala untuk melihat pertumbuhan
2. Monitor user baru yang mendaftar
3. Review UMKM yang unpublished
4. Pastikan data master tetap konsisten

## Troubleshooting

### Error 403 Unauthorized
- Pastikan login sebagai super admin
- Clear cache: `php artisan optimize:clear`
- Cek role di database: `SELECT role FROM users WHERE email = 'superadmin@arsa.com'`

### Menu Tidak Muncul
- Clear view cache: `php artisan view:clear`
- Rebuild assets: `npm run build`
- Hard refresh browser (Ctrl+Shift+R)

### Data Tidak Muncul
- Cek database connection di `.env`
- Pastikan seeder sudah dijalankan
- Cek query di controller dengan `dd()` atau log

## Development Notes

### File Penting
- Controller: `app/Http/Controllers/SuperAdmin/`
- Views: `resources/views/superadmin/`
- Middleware: `app/Http/Middleware/RoleOrMiddleware.php`
- Routes: `routes/web.php` (section Super Admin)

### Database Tables
- `users` - Data user dengan role
- `umkm_profiles` - Data UMKM
- `categories` - Master kategori
- `districts` - Master kecamatan
- `activity_logs` - Log aktivitas sistem

## Future Enhancements

Fitur yang bisa ditambahkan:
1. Export data ke Excel/PDF
2. Bulk operations (bulk delete, bulk toggle)
3. Advanced filtering dan sorting
4. Activity log viewer dengan filter
5. System settings management
6. Email notifications untuk admin
7. Backup & restore database
8. API access management
