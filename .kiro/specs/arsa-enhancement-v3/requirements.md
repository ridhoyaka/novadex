# NovaDex Platform Enhancement v3.0 - Requirements

## Project Overview

**Project Name:** NovaDex Platform Enhancement v3.0  
**Type:** System Enhancement (NOT Rebuild)  
**Client:** Solvia  
**Purpose:** Menyempurnakan fondasi digital UMKM dengan fokus pada discoverability, SEO, dan user experience

### Core Principles (WAJIB DIPATUHI)

❌ **TIDAK BOLEH:**
- Menambah role user baru
- Menambah fitur transaksi/pembayaran
- Mengelola data keuangan UMKM
- Menjadikan NovaDex sebagai sistem pembinaan pemerintah
- Rebuild sistem yang sudah ada

✅ **HARUS:**
- Fokus pada fondasi digital & identitas usaha
- SEO terintegrasi otomatis (tanpa beban UMKM)
- Semua update bersifat enhancement
- Sistem tetap ringan & inklusif
- Memperkuat katalog & discoverability

---

## User Stories & Acceptance Criteria

### 1. UMKM Role Enhancement

#### 1.1 Profile Completion Indicator
**As a** UMKM owner  
**I want to** see clear indicators of my profile completeness  
**So that** I understand what makes my profile "optimal" without technical jargon

**Acceptance Criteria:**
- [ ] Dashboard shows profile completion percentage (0-100%)
- [ ] Completion indicator uses friendly language:
  - "Profil Dasar" (< 50%)
  - "Profil Lengkap" (50-80%)
  - "Profil Optimal" (> 80%)
- [ ] Clear checklist of what's missing (in plain language)
- [ ] No technical terms like "SEO", "metadata", "slug"
- [ ] Visual progress bar with color coding:
  - Red/Orange: < 50%
  - Yellow: 50-80%
  - Green: > 80%

**Calculation Logic:**
- Nama usaha: 15%
- Kategori: 15%
- Kecamatan: 15%
- Deskripsi (min 50 karakter): 15%
- WhatsApp: 15%
- Logo/Foto: 15%
- Lokasi (opsional): 10%

#### 1.2 Maps Integration (Optional for UMKM)
**As a** UMKM owner  
**I want to** optionally add my business location  
**So that** customers can find me easily without being forced to share my address

**Acceptance Criteria:**
- [ ] Location field is OPTIONAL (not required for publish)
- [ ] Two input methods:
  - Manual pin on map
  - Address text → auto-pin (geocoding)
- [ ] UI copy: "Tambahkan lokasi usaha agar pelanggan lebih mudah menemukan Anda (opsional)"
- [ ] Clear privacy note: "Lokasi ini akan ditampilkan di peta publik"
- [ ] Can save profile without location
- [ ] Can update/remove location anytime
- [ ] Location stored as: latitude, longitude, address_display (optional)
- [ ] NO tracking or real-time location
- [ ] NO requirement to show home address

#### 1.3 Photo Management Enhancement
**As a** UMKM owner  
**I want to** have at least one photo to make my profile attractive  
**So that** customers can see my business visually

**Acceptance Criteria:**
- [ ] Minimum 1 photo recommended (not required)
- [ ] Elegant placeholder if no photo:
  - Category-based icon
  - Business name initial
  - Neutral background
- [ ] Photo upload UI shows:
  - "Foto pertama Anda akan menjadi foto utama"
  - "Minimal 1 foto dianjurkan"
- [ ] Maximum 3 photos (existing)
- [ ] Photo preview before upload
- [ ] Easy delete/reorder photos

#### 1.4 Dashboard UI/UX Improvements
**As a** UMKM owner  
**I want to** understand my dashboard without technical knowledge  
**So that** I can focus on my business, not learning technology

**Acceptance Criteria:**
- [ ] Remove all technical terms:
  - ❌ "SEO Score"
  - ❌ "Metadata"
  - ❌ "Slug"
  - ✅ "Profil Anda"
  - ✅ "Status"
  - ✅ "Kelengkapan"
- [ ] Status indicators use plain language:
  - "Profil Aktif" (published)
  - "Profil Tidak Aktif" (unpublished)
  - "Profil Optimal" (complete)
  - "Profil Perlu Dilengkapi" (incomplete)
- [ ] Quick actions clearly labeled:
  - "Lengkapi Profil"
  - "Lihat Profil Publik"
  - "Aktifkan/Nonaktifkan Profil"
- [ ] Help text uses friendly tone:
  - "Profil optimal membantu pelanggan menemukan Anda lebih mudah"
  - "Tambahkan foto untuk menarik perhatian"

---

### 2. SEO System (Internal & Automatic)

#### 2.1 Auto-Generate SEO Metadata
**As a** system  
**I want to** automatically generate SEO metadata for each UMKM profile  
**So that** profiles are discoverable via search engines without UMKM effort

**Acceptance Criteria:**
- [ ] Auto-generate on profile save/update:
  - Meta title: "{Nama Usaha} - {Kategori} di {Kecamatan}"
  - Meta description: First 155 characters of deskripsi
  - OG tags for social sharing
- [ ] SEO-friendly URL structure:
  - `/umkm/{slug}` (existing)
  - Slug auto-generated from nama_usaha
- [ ] Alt text for images:
  - Logo: "{Nama Usaha} - Logo"
  - Photos: "{Nama Usaha} - Foto {number}"
- [ ] Structured data (JSON-LD):
  - LocalBusiness schema
  - Organization schema
- [ ] NO manual SEO settings for UMKM
- [ ] NO SEO dashboard for UMKM

#### 2.2 Sitemap Generation
**As a** system  
**I want to** automatically generate XML sitemap  
**So that** search engines can index all published UMKM profiles

**Acceptance Criteria:**
- [ ] Auto-generate sitemap at `/sitemap.xml`
- [ ] Include only published profiles
- [ ] Update frequency: daily
- [ ] Priority levels:
  - Homepage: 1.0
  - Catalog: 0.9
  - UMKM profiles: 0.8
  - Static pages: 0.7
- [ ] Last modified date from profile updated_at
- [ ] Cache sitemap for performance

#### 2.3 Internal Linking
**As a** system  
**I want to** create internal links between related UMKM  
**So that** users discover more businesses and SEO improves

**Acceptance Criteria:**
- [ ] "UMKM Sejenis" section on detail page
- [ ] Show 3-6 related UMKM based on:
  - Same category
  - Same district
  - Recently updated
- [ ] Links use descriptive anchor text
- [ ] Breadcrumb navigation:
  - Home > Katalog > {Kategori} > {Nama Usaha}

---

### 3. Admin Role Clarification

**Admin Role:** Operator sistem & penjaga kualitas katalog

#### 3.1 Admin Dashboard Focus
**As an** admin  
**I want to** focus on data quality and system health  
**So that** the catalog remains clean and useful

**Acceptance Criteria:**
- [ ] Dashboard shows:
  - Total UMKM (published vs unpublished)
  - UMKM per category (chart)
  - UMKM per district (chart)
  - Recent activities (last 10)
  - Data quality indicators:
    - Profiles without photos
    - Profiles with short descriptions (< 50 chars)
    - Unpublished profiles > 30 days
    - Profiles without location
- [ ] Admin CANNOT:
  - ❌ Edit UMKM profile data
  - ❌ See WhatsApp numbers (privacy protected)
  - ❌ See email addresses (privacy protected)
  - ❌ Input data for UMKM
  - ❌ Melakukan pembinaan UMKM
- [ ] Admin CAN:
  - ✅ Kelola kategori usaha (CRUD)
  - ✅ Kelola wilayah/kecamatan (CRUD)
  - ✅ Monitoring konten publik (view only)
  - ✅ Validasi data dasar (optional flagging)
  - ✅ Melihat sebaran UMKM di peta (overview)
  - ✅ Toggle publish/unpublish (with reason)
  - ✅ Delete spam/duplicate profiles
  - ✅ View aggregate data

#### 3.2 Category Management (Kelola Kategori)
**As an** admin  
**I want to** manage business categories  
**So that** UMKM can choose appropriate categories

**Acceptance Criteria:**
- [ ] CRUD operations for categories:
  - Create new category
  - Edit category name
  - Delete category (if no UMKM using it)
  - View UMKM count per category
- [ ] Category validation:
  - Unique category names
  - Cannot delete if UMKM exists
  - Confirmation before delete
- [ ] UI shows:
  - List of all categories
  - UMKM count for each
  - Last updated date
  - Action buttons (Edit, Delete)

#### 3.3 District Management (Kelola Wilayah)
**As an** admin  
**I want to** manage districts/areas  
**So that** UMKM can select their location accurately

**Acceptance Criteria:**
- [ ] CRUD operations for districts:
  - Create new district
  - Edit district name
  - Delete district (if no UMKM using it)
  - View UMKM count per district
- [ ] District validation:
  - Unique district names
  - Cannot delete if UMKM exists
  - Confirmation before delete
- [ ] UI shows:
  - List of all districts
  - UMKM count for each
  - Last updated date
  - Action buttons (Edit, Delete)

#### 3.4 Content Monitoring (Monitoring Konten Publik)
**As an** admin  
**I want to** monitor published content quality  
**So that** the public catalog maintains professional standards

**Acceptance Criteria:**
- [ ] View-only access to published UMKM profiles
- [ ] Filter and search capabilities:
  - By category
  - By district
  - By publish status
  - By completion score
  - By last updated date
- [ ] Data quality indicators:
  - Profiles without photos (count & list)
  - Profiles with short descriptions (count & list)
  - Profiles without location (count & list)
  - Recently updated profiles
  - Long-inactive profiles (> 90 days)
- [ ] NO edit capabilities on UMKM data
- [ ] Privacy protection maintained (no contact info shown)

#### 3.5 Data Validation (Optional - Validasi Data Dasar)
**As an** admin  
**I want to** optionally flag profiles that need attention  
**So that** UMKM can improve their profile quality

**Acceptance Criteria:**
- [ ] Validation is OPTIONAL (not blocking publish)
- [ ] Admin can flag profiles for:
  - Inappropriate content
  - Duplicate business
  - Incomplete information
  - Quality concerns
- [ ] Flag system:
  - Add flag with reason/note
  - Flag visible to UMKM in dashboard
  - UMKM can respond or update
  - Admin can remove flag after review
- [ ] NO approval workflow (UMKM controls publish)
- [ ] Flags are suggestions, not requirements

#### 3.6 UMKM Map Overview (Sebaran UMKM di Peta)
**As an** admin  
**I want to** see UMKM distribution on a map  
**So that** I can understand geographic coverage

**Acceptance Criteria:**
- [ ] Map view showing all UMKM with location data
- [ ] Markers color-coded by:
  - Category (optional filter)
  - District (optional filter)
  - Publish status
- [ ] Cluster markers for performance
- [ ] Click marker shows basic info:
  - Business name
  - Category
  - District
  - Publish status
  - Link to view (read-only)
- [ ] Statistics overlay:
  - Total UMKM on map
  - UMKM without location
  - Coverage by district
- [ ] Export map as image (for reports)
- [ ] NO edit capabilities from map view

---

### 4. Superadmin Role Enhancement

#### 4.1 Read-Only Strategic Dashboard
**As a** superadmin (strategic stakeholder)  
**I want to** see aggregate data and trends  
**So that** I can make informed decisions without operational involvement

**Acceptance Criteria:**
- [ ] Dashboard is READ-ONLY (no edit buttons)
- [ ] Shows aggregate data only:
  - Total UMKM count
  - Growth trend (last 30/90 days)
  - Category distribution (pie chart)
  - District distribution (bar chart)
  - Publish rate (%)
  - Profile completion average (%)
- [ ] Heatmap/choropleth map showing UMKM density by district
- [ ] Export data as PDF report (aggregate only)
- [ ] NO access to:
  - Individual UMKM data
  - Contact information
  - Financial data
  - Edit capabilities
- [ ] Dashboard updates daily (cached)

#### 4.2 Trend Visualization
**As a** superadmin  
**I want to** see growth trends over time  
**So that** I can track NovaDex adoption and impact

**Acceptance Criteria:**
- [ ] Line chart: UMKM registration over time
- [ ] Bar chart: New UMKM per month
- [ ] Comparison: Published vs Unpublished trend
- [ ] Category growth comparison
- [ ] District adoption rate
- [ ] All data is aggregate (no individual details)

---

### 5. Public Catalog Enhancement

#### 5.1 SEO-Optimized Detail Pages
**As a** public visitor  
**I want to** find UMKM easily via search engines  
**So that** I can discover local businesses

**Acceptance Criteria:**
- [ ] SEO-friendly URL: `/umkm/{slug}`
- [ ] Meta tags properly set (from auto-generation)
- [ ] Structured data (JSON-LD) embedded
- [ ] Social sharing preview works (OG tags)
- [ ] Page title format: "{Nama Usaha} - {Kategori} di {Kecamatan} | NovaDex"
- [ ] Breadcrumb navigation visible
- [ ] Related UMKM section at bottom
- [ ] Clear CTA: "Hubungi via WhatsApp" button
- [ ] Map integration if location available:
  - Embedded map showing pin
  - "Buka di Google Maps" button
  - "Lokasi belum ditambahkan" if no location

#### 5.2 Enhanced Search & Filter
**As a** public visitor  
**I want to** find UMKM by various criteria  
**So that** I can discover businesses that match my needs

**Acceptance Criteria:**
- [ ] Search by:
  - Business name (fulltext)
  - Category
  - District
  - Keyword in description
- [ ] Filter combinations work together
- [ ] Results show:
  - Business name
  - Category badge
  - District badge
  - Photo/placeholder
  - Short description (100 chars)
- [ ] Sort options:
  - Terbaru (newest)
  - A-Z (alphabetical)
  - Kategori (grouped)
- [ ] Pagination (20 per page)
- [ ] "No results" state with suggestions

#### 5.3 Map View Enhancement
**As a** public visitor  
**I want to** see UMKM on a map  
**So that** I can find businesses near me

**Acceptance Criteria:**
- [ ] Map shows only UMKM with location data
- [ ] Markers clustered for performance
- [ ] Click marker shows popup:
  - Business name
  - Category
  - "Lihat Detail" link
- [ ] Filter by category on map
- [ ] Filter by district on map
- [ ] "List View" / "Map View" toggle
- [ ] Mobile-friendly map controls

---

## Technical Requirements

### 5.1 Database Changes

**New Columns for umkm_profiles:**
```sql
- latitude (decimal, nullable)
- longitude (decimal, nullable)
- address_display (string, nullable)
- seo_title (string, nullable, auto-generated)
- seo_description (text, nullable, auto-generated)
- profile_completion_score (integer, default 0)
```

**No new tables needed**

### 5.2 Performance Requirements

- [ ] Page load time < 2 seconds
- [ ] Map loads < 3 seconds
- [ ] Sitemap generation < 5 seconds
- [ ] Search results < 1 second
- [ ] Image optimization (WebP, lazy loading)
- [ ] Database query optimization (indexes)
- [ ] Cache frequently accessed data

### 5.3 SEO Requirements

- [ ] All pages have unique meta titles
- [ ] All pages have meta descriptions
- [ ] All images have alt text
- [ ] Structured data validates (Google Rich Results Test)
- [ ] Sitemap validates (XML Sitemap Validator)
- [ ] Mobile-friendly (Google Mobile-Friendly Test)
- [ ] Page speed score > 80 (Google PageSpeed Insights)

---

## Out of Scope (DO NOT IMPLEMENT)

❌ **Explicitly NOT Included:**
- Transaction features
- Payment processing
- Financial reporting
- Paid advertising
- Location tracking
- UMKM coaching/training system
- Approval workflows
- New user roles
- Mobile app
- API for third parties
- Email marketing
- CRM features
- Inventory management
- Booking system

---

## Success Criteria

Enhancement is successful if:

1. **For UMKM:**
   - ✅ Profile completion is clear and motivating
   - ✅ No technical jargon in UI
   - ✅ Location is optional but easy to add
   - ✅ Dashboard is simple and actionable

2. **For Public:**
   - ✅ UMKM profiles appear in Google search
   - ✅ Detail pages are shareable on social media
   - ✅ Map helps discover nearby businesses
   - ✅ Search is fast and relevant

3. **For Admin:**
   - ✅ Focus on data quality, not operations
   - ✅ Cannot interfere with UMKM autonomy
   - ✅ Dashboard shows system health

4. **For Superadmin:**
   - ✅ Strategic insights without operational access
   - ✅ Aggregate data only
   - ✅ Trend visualization is clear

5. **For System:**
   - ✅ SEO works automatically
   - ✅ Performance remains good
   - ✅ System stays lightweight
   - ✅ Ready for pilot implementation

---

## Risk Assessment

### Risks if System Deviates from NovaDex Concept:

1. **Scope Creep Risk:**
   - Adding transaction features → Becomes marketplace
   - Adding financial tools → Becomes accounting software
   - Adding training → Becomes LMS

2. **Complexity Risk:**
   - Too many features → UMKM overwhelmed
   - Technical UI → UMKM confused
   - Mandatory fields → UMKM discouraged

3. **Privacy Risk:**
   - Exposing contact data → UMKM distrust
   - Location tracking → Privacy violation
   - Admin overreach → UMKM lose control

### Mitigation:
- Stick to requirements strictly
- Regular review against core principles
- User testing with real UMKM
- Feedback loop with stakeholders

---

## Deliverables

1. **Enhanced UMKM Dashboard**
   - Profile completion indicator
   - Friendly UI copy
   - Optional location input

2. **SEO System**
   - Auto-generated metadata
   - XML sitemap
   - Structured data
   - Internal linking

3. **Enhanced Public Catalog**
   - SEO-optimized pages
   - Better search/filter
   - Map integration

4. **Admin Dashboard Updates**
   - Data quality focus
   - Clear limitations
   - Aggregate views

5. **Superadmin Dashboard**
   - Read-only strategic view
   - Trend visualization
   - Heatmap

6. **Documentation**
   - User guide for UMKM (non-technical)
   - Admin guide
   - SEO implementation notes
   - Testing checklist

---

## Implementation Priority

### Phase 1 (High Priority - Core Enhancements)
1. Profile completion indicator
2. UI/UX copy improvements
3. SEO auto-generation
4. Sitemap generation

### Phase 2 (Medium Priority - Discoverability)
1. Maps integration (optional for UMKM)
2. Enhanced search/filter
3. Internal linking
4. Structured data

### Phase 3 (Low Priority - Strategic)
1. Superadmin dashboard enhancements
2. Trend visualization
3. Heatmap
4. Export reports

---

**Document Version:** 1.0  
**Created:** 2026-02-06  
**Status:** Ready for Review  
**Next Step:** Design Document
