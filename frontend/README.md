# NovaDex Frontend Prototype

Prototype frontend statis untuk demo NovaDex Platform - Fondasi Digital UMKM Salatiga.

## 📁 Struktur File

```
frontend/
├── index.html          # Homepage (✅ Sudah dibuat)
├── katalog.html        # Halaman katalog UMKM (⏳ Dalam proses)
├── detail.html         # Detail UMKM
├── kategori.html       # Halaman kategori
├── peta.html           # Peta UMKM
├── assets/
│   ├── css/
│   │   └── style.css   # Custom styles
│   ├── js/
│   │   └── app.js      # Custom scripts
│   └── images/         # Images & icons
└── README.md           # This file
```

## 🚀 Cara Deploy

### Option 1: Netlify (Recommended)
1. Push folder `frontend/` ke GitHub repository
2. Login ke [Netlify](https://netlify.com)
3. Click "Add new site" → "Import an existing project"
4. Connect GitHub dan pilih repository
5. Set build settings:
   - Base directory: `frontend`
   - Build command: (kosongkan)
   - Publish directory: `.`
6. Click "Deploy site"

### Option 2: Vercel
1. Push folder `frontend/` ke GitHub repository
2. Login ke [Vercel](https://vercel.com)
3. Click "New Project"
4. Import repository
5. Set Root Directory: `frontend`
6. Click "Deploy"

### Option 3: GitHub Pages
1. Push folder `frontend/` ke GitHub repository
2. Go to repository Settings → Pages
3. Source: Deploy from a branch
4. Branch: `main` → folder: `/frontend`
5. Save

### Option 4: Local Testing
```bash
# Menggunakan Python
cd frontend
python -m http.server 8000

# Atau menggunakan PHP
php -S localhost:8000

# Atau menggunakan Node.js (http-server)
npx http-server -p 8000
```

Buka browser: `http://localhost:8000`

## 🎨 Features

### ✅ Sudah Dibuat:
- **Homepage (index.html)**
  - Hero section dengan CTA
  - Statistics cards
  - Category slider (Swiper.js)
  - Featured UMKM cards
  - Responsive navigation
  - Footer

### ⏳ Perlu Dilengkapi:
- **Katalog (katalog.html)** - List semua UMKM dengan filter
- **Detail (detail.html)** - Detail UMKM dengan maps & social sharing
- **Kategori (kategori.html)** - Grid kategori dengan statistik
- **Peta (peta.html)** - Interactive map dengan markers

## 🛠️ Technologies Used

- **HTML5** - Semantic markup
- **Tailwind CSS** - Utility-first CSS framework (via CDN)
- **Swiper.js** - Modern slider library
- **Vanilla JavaScript** - No framework dependencies
- **Google Fonts** - Space Grotesk & Inter

## 🎨 Design System

### Colors:
- **Primary Gold**: #D4AF37
- **Light Gold**: #F6E05E
- **Dark Background**: #0F1419
- **Card Background**: #1A1F26
- **Border**: #2D3748

### Typography:
- **Headings**: Space Grotesk (Bold, Black)
- **Body**: Inter (Light, Regular, Medium)

### Components:
- Cards dengan hover effects
- Gradient buttons
- Category badges
- Status indicators
- Responsive navigation

## 📱 Responsive Breakpoints

- **Mobile**: < 640px
- **Tablet**: 640px - 1024px
- **Desktop**: > 1024px

## 🔗 Demo Data

Prototype menggunakan sample data untuk:
- 12 UMKM (Kuliner, Fashion, Kerajinan, Jasa, Pertanian)
- 5 Kategori
- 4 Kecamatan (Sidorejo, Argomulyo, Sidomukti, Tingkir)

## 📝 Notes

- Ini adalah **prototype statis** untuk demo dan presentasi
- Tidak ada backend atau database
- Data hardcoded di JavaScript
- Cocok untuk hosting free (Netlify, Vercel, GitHub Pages)
- Bisa digunakan untuk user testing dan feedback

## 🚀 Next Steps

Untuk membuat prototype lengkap:
1. ✅ Homepage - DONE
2. ⏳ Katalog page dengan filter & search
3. ⏳ Detail page dengan maps & social sharing
4. ⏳ Kategori page dengan grid
5. ⏳ Peta page dengan Leaflet.js

## 📞 Support

Untuk pertanyaan atau bantuan:
- Email: support@arsa.id (contoh)
- Website: https://arsa.id (contoh)

---

**Developed by Solvia**  
© 2026 NovaDex Platform
