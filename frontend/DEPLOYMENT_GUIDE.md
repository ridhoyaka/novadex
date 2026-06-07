# 🚀 NovaDex Frontend - Panduan Deploy ke Hosting Free

## 📋 Quick Start

Prototype frontend NovaDex sudah siap di-deploy ke hosting free. Ikuti salah satu cara di bawah:

---

## 🌐 Option 1: Netlify (RECOMMENDED - Paling Mudah)

### Langkah-langkah:

1. **Buat akun Netlify** (jika belum punya)
   - Kunjungi: https://netlify.com
   - Sign up dengan GitHub/GitLab/Email

2. **Deploy via Drag & Drop** (Cara Tercepat)
   - Login ke Netlify Dashboard
   - Scroll ke bawah ke "Want to deploy a new site without connecting to Git?"
   - **Drag & drop folder `frontend/`** ke area upload
   - Tunggu beberapa detik
   - ✅ **DONE!** Site Anda sudah live

3. **Deploy via GitHub** (Cara Otomatis)
   - Push folder `frontend/` ke GitHub repository
   - Di Netlify Dashboard, click "Add new site"
   - Pilih "Import an existing project"
   - Connect GitHub dan pilih repository
   - Settings:
     ```
     Base directory: frontend
     Build command: (kosongkan)
     Publish directory: .
     ```
   - Click "Deploy site"
   - ✅ **DONE!**

4. **Custom Domain** (Opsional)
   - Di Site settings → Domain management
   - Add custom domain atau gunakan subdomain Netlify gratis
   - Contoh: `arsa-salatiga.netlify.app`

### ✅ Keuntungan Netlify:
- ✅ Deploy dalam hitungan detik
- ✅ HTTPS otomatis
- ✅ CDN global
- ✅ Unlimited bandwidth
- ✅ Auto-deploy dari Git
- ✅ Free subdomain

---

## 🔷 Option 2: Vercel

### Langkah-langkah:

1. **Buat akun Vercel**
   - Kunjungi: https://vercel.com
   - Sign up dengan GitHub

2. **Deploy**
   - Push folder `frontend/` ke GitHub
   - Di Vercel Dashboard, click "New Project"
   - Import repository
   - Settings:
     ```
     Root Directory: frontend
     Framework Preset: Other
     Build Command: (kosongkan)
     Output Directory: .
     ```
   - Click "Deploy"
   - ✅ **DONE!**

### ✅ Keuntungan Vercel:
- ✅ Deploy super cepat
- ✅ Edge network global
- ✅ Analytics gratis
- ✅ Preview deployments

---

## 📄 Option 3: GitHub Pages

### Langkah-langkah:

1. **Push ke GitHub**
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git branch -M main
   git remote add origin https://github.com/username/arsa-frontend.git
   git push -u origin main
   ```

2. **Enable GitHub Pages**
   - Go to repository Settings
   - Scroll ke "Pages" section
   - Source: Deploy from a branch
   - Branch: `main` → folder: `/frontend`
   - Save

3. **Akses site**
   - URL: `https://username.github.io/arsa-frontend/`
   - Tunggu 1-2 menit untuk build

### ✅ Keuntungan GitHub Pages:
- ✅ Gratis selamanya
- ✅ Terintegrasi dengan Git
- ✅ Custom domain support

---

## 🖥️ Option 4: Local Testing

Sebelum deploy, test dulu di local:

### Menggunakan Python:
```bash
cd frontend
python -m http.server 8000
```

### Menggunakan PHP:
```bash
cd frontend
php -S localhost:8000
```

### Menggunakan Node.js:
```bash
cd frontend
npx http-server -p 8000
```

Buka browser: `http://localhost:8000`

---

## 📁 File Structure untuk Deploy

Pastikan struktur folder seperti ini:

```
frontend/
├── index.html          ✅ (Sudah ada)
├── katalog.html        ⏳ (Perlu dibuat)
├── detail.html         ⏳ (Perlu dibuat)
├── kategori.html       ⏳ (Perlu dibuat)
├── peta.html           ⏳ (Perlu dibuat)
├── netlify.toml        ✅ (Config file)
└── README.md           ✅ (Documentation)
```

**Note:** Saat ini baru `index.html` yang sudah dibuat. Halaman lain bisa ditambahkan nanti.

---

## 🎯 Rekomendasi Deploy

### Untuk Demo Cepat:
**→ Gunakan Netlify Drag & Drop**
- Paling cepat (< 1 menit)
- Tidak perlu Git
- Langsung dapat URL

### Untuk Development:
**→ Gunakan Netlify/Vercel + GitHub**
- Auto-deploy setiap push
- Preview deployments
- Rollback mudah

### Untuk Permanent:
**→ Gunakan Custom Domain + Netlify**
- Professional
- SEO-friendly
- Gratis HTTPS

---

## 🔗 Contoh URL Hasil Deploy

Setelah deploy, Anda akan dapat URL seperti:

- **Netlify**: `https://arsa-salatiga.netlify.app`
- **Vercel**: `https://arsa-frontend.vercel.app`
- **GitHub Pages**: `https://username.github.io/arsa-frontend/`

---

## ✅ Checklist Sebelum Deploy

- [x] File `index.html` sudah ada
- [x] File `netlify.toml` sudah ada (untuk Netlify)
- [x] Semua link internal sudah benar
- [x] Responsive design sudah di-test
- [ ] Halaman lain (katalog, detail, dll) sudah dibuat (opsional)

---

## 🐛 Troubleshooting

### Problem: 404 Not Found
**Solution:** Pastikan `netlify.toml` ada dan berisi redirect rules

### Problem: Styles tidak muncul
**Solution:** Pastikan CDN Tailwind CSS & Swiper.js bisa diakses

### Problem: Mobile menu tidak berfungsi
**Solution:** Pastikan JavaScript di `index.html` sudah benar

---

## 📞 Need Help?

Jika ada masalah saat deploy:
1. Check Netlify/Vercel build logs
2. Test di local dulu dengan `python -m http.server`
3. Pastikan semua file sudah ter-upload

---

## 🎉 Selamat!

Setelah deploy berhasil, Anda bisa:
- ✅ Share URL ke stakeholders
- ✅ Gunakan untuk user testing
- ✅ Presentasi ke client
- ✅ Collect feedback

**Next Steps:**
1. Deploy homepage (index.html) dulu
2. Test dan collect feedback
3. Tambahkan halaman lain (katalog, detail, dll)
4. Update dan re-deploy

---

**Happy Deploying! 🚀**

*Developed by Solvia*  
*© 2026 NovaDex Platform*
