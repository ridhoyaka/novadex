# PENYESUAIAN FITUR NovaDex
## Sesuai Requirement dengan 3 Role: Publik, UMKM, Admin

---

## ✅ YANG SUDAH SESUAI

### 🌍 1. PUBLIK (TANPA LOGIN) - 100% ✅
- ✅ Landing page dengan featured UMKM
- ✅ Katalog UMKM (filter kategori, kecamatan, search)
- ✅ Detail UMKM (foto, kontak WhatsApp)
- ✅ Peta UMKM sebagai pembeda
- ✅ Tidak ada fitur keuangan
- ✅ Cepat, familiar, tidak membebani sistem

### 👤 2. UMKM (USER LOGIN) - 100% ✅
- ✅ Registrasi & Login
- ✅ Dashboard UMKM (status profil, preview)
- ✅ Kelola profil (nama, kategori, kecamatan, deskripsi, WhatsApp, foto)
- ✅ Publish/Unpublish profil (kontrol privasi)
- ✅ Edit & update data
- ✅ Tidak ada fitur keuangan

### 🏛️ 3. ADMIN PROGRAM / DINAS - 90% ✅
- ✅ Dashboard kota (total UMKM, per kecamatan, per kategori)
- ✅ Peta UMKM internal
- ✅ Grafik agregat
- ✅ TIDAK bisa edit data UMKM langsung
- ✅ TIDAK ada akses data sensitif pribadi
- ✅ Hanya toggle publish & delete
- ⚠️ Belum ada export PDF/Excel

---

## 🔧 YANG PERLU DISESUAIKAN

### 1. Admin Dashboard - Tambah Export Laporan
**Requirement:** Laporan agregat (PDF/Excel)
**Status:** Belum ada
**Action:** Tambahkan tombol export di dashboard admin

### 2. Admin - Batasi Akses Data Pribadi
**Requirement:** Tidak boleh lihat kontak pribadi UMKM
**Status:** Saat ini admin bisa lihat semua data
**Action:** Sembunyikan WhatsApp & email owner dari admin view

### 3. Activity Logs
**Requirement:** Log perubahan untuk keamanan
**Status:** Model ada, UI belum
**Action:** Tambahkan activity logs UI

### 4. Moderasi Konten Ringan
**Requirement:** Mencegah spam, jaga kualitas
**Status:** Belum ada
**Action:** Tambahkan approval system untuk UMKM baru

---

## 🎯 IMPLEMENTASI PENYESUAIAN

### Priority 1: Batasi Akses Admin (CRITICAL)
- Sembunyikan WhatsApp dari admin detail view
- Sembunyikan email owner dari admin
- Admin hanya lihat: nama usaha, kategori, kecamatan, deskripsi, foto

### Priority 2: Export Laporan (HIGH)
- Export PDF: Laporan agregat UMKM
- Export Excel: Data UMKM (tanpa kontak pribadi)

### Priority 3: Activity Logs UI (MEDIUM)
- View untuk melihat log perubahan
- Filter by user, action, date

### Priority 4: Content Moderation (MEDIUM)
- Status: pending, approved, rejected
- Admin bisa approve/reject UMKM baru
- UMKM baru default pending

---

## 📊 ESTIMASI

- Priority 1: 30 menit
- Priority 2: 1 jam
- Priority 3: 1 jam
- Priority 4: 1.5 jam

**Total:** 4 jam untuk 100% sesuai requirement
