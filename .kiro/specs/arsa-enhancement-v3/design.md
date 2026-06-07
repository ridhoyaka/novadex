# NovaDex Platform Enhancement v3.0 - Design Document

## Overview

This design document outlines the technical implementation for NovaDex v3.0 enhancements, focusing on:
- SEO optimization (automatic)
- Profile completion indicators
- Maps integration (optional for UMKM)
- Admin role clarification
- Superadmin strategic dashboard
- Public catalog improvements

**Core Principle:** Enhancement, not rebuild. All changes build upon existing v2.0 system.

---

## Architecture Overview

### System Components

```
┌─────────────────────────────────────────────────────────┐
│                    NovaDex v3.0 Architecture                │
├─────────────────────────────────────────────────────────┤
│                                                           │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐  │
│  │   Public     │  │    UMKM      │  │    Admin     │  │
│  │   Catalog    │  │  Dashboard   │  │  Dashboard   │  │
│  └──────┬───────┘  └──────┬───────┘  └──────┬───────┘  │
│         │                  │                  │          │
│         └──────────────────┼──────────────────┘          │
│                            │                             │
│                   ┌────────▼────────┐                    │
│                   │  SEO Service    │ (Auto-generate)    │
│                   │  - Meta tags    │                    │
│                   │  - Sitemap      │                    │
│                   │  - Schema.org   │                    │
│                   └────────┬────────┘                    │
│                            │                             │
│         ┌──────────────────┼──────────────────┐          │
│         │                  │                  │          │
│  ┌──────▼───────┐  ┌──────▼───────┐  ┌──────▼───────┐  │
│  │   Models     │  │  Controllers │  │   Services   │  │
│  │  - UMKM      │  │  - Public    │  │  - Profile   │  │
│  │  - Category  │  │  - UMKM      │  │  - SEO       │  │
│  │  - District  │  │  - Admin     │  │  - Maps      │  │
│  └──────────────┘  └──────────────┘  └──────────────┘  │
│                                                           │
└─────────────────────────────────────────────────────────┘
```

---

## Database Design

### 1. Schema Changes

#### 1.1 Update `umkm_profiles` Table

**New Columns:**
```sql
ALTER TABLE umkm_profiles ADD COLUMN latitude DECIMAL(10, 8) NULL AFTER whatsapp;
ALTER TABLE umkm_profiles ADD COLUMN longitude DECIMAL(11, 8) NULL AFTER latitude;
ALTER TABLE umkm_profiles ADD COLUMN address_display VARCHAR(255) NULL AFTER longitude;
ALTER TABLE umkm_profiles ADD COLUMN seo_title VARCHAR(255) NULL AFTER address_display;
ALTER TABLE umkm_profiles ADD COLUMN seo_description TEXT NULL AFTER seo_title;
ALTER TABLE umkm_profiles ADD COLUMN profile_completion_score TINYINT UNSIGNED DEFAULT 0 AFTER seo_description;

-- Add indexes for performance
CREATE INDEX idx_location ON umkm_profiles(latitude, longitude);
CREATE INDEX idx_completion ON umkm_profiles(profile_completion_score);
```

**Column Details:**
- `latitude`: Decimal(10,8) - Latitude coordinate (-90 to 90)
- `longitude`: Decimal(11,8) - Longitude coordinate (-180 to 180)
- `address_display`: String(255) - Human-readable address for display
- `seo_title`: String(255) - Auto-generated SEO title
- `seo_description`: Text - Auto-generated SEO description
- `profile_completion_score`: TinyInt(0-100) - Calculated completion percentage

#### 1.2 Create `profile_flags` Table (Optional Validation)

```sql
CREATE TABLE profile_flags (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    umkm_profile_id BIGINT UNSIGNED NOT NULL,
    admin_user_id BIGINT UNSIGNED NOT NULL,
    flag_type ENUM('inappropriate', 'duplicate', 'incomplete', 'quality') NOT NULL,
    reason TEXT NULL,
    status ENUM('active', 'resolved', 'dismissed') DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    resolved_at TIMESTAMP NULL,
    
    FOREIGN KEY (umkm_profile_id) REFERENCES umkm_profiles(id) ON DELETE CASCADE,
    FOREIGN KEY (admin_user_id) REFERENCES users(id) ON DELETE CASCADE,
    
    INDEX idx_profile (umkm_profile_id),
    INDEX idx_status (status),
    INDEX idx_created (created_at)
);
```

---

## Feature Implementation

### Phase 1: UMKM Dashboard Enhancements

#### 1.1 Profile Completion Service

**File:** `app/Services/ProfileCompletionService.php`

```php
class ProfileCompletionService
{
    public function calculateScore(UmkmProfile $profile): int
    {
        $score = 0;
        
        // Nama usaha (15%)
        if (!empty($profile->nama_usaha)) {
            $score += 15;
        }
        
        // Kategori (15%)
        if ($profile->kategori_id) {
            $score += 15;
        }
        
        // Kecamatan (15%)
        if ($profile->kecamatan_id) {
            $score += 15;
        }
        
        // Deskripsi min 50 chars (15%)
        if (strlen($profile->deskripsi) >= 50) {
            $score += 15;
        }
        
        // WhatsApp (15%)
        if (!empty($profile->whatsapp)) {
            $score += 15;
        }
        
        // Logo atau foto (15%)
        if ($profile->logo_path || !empty($profile->photos)) {
            $score += 15;
        }
        
        // Lokasi - optional (10%)
        if ($profile->latitude && $profile->longitude) {
            $score += 10;
        }
        
        return $score;
    }
    
    public function getStatus(int $score): string
    {
        if ($score < 50) {
            return 'Profil Dasar';
        } elseif ($score < 80) {
            return 'Profil Lengkap';
        } else {
            return 'Profil Optimal';
        }
    }
    
    public function getMissingFields(UmkmProfile $profile): array
    {
        $missing = [];
        
        if (empty($profile->nama_usaha)) {
            $missing[] = 'Nama usaha belum diisi';
        }
        
        if (!$profile->kategori_id) {
            $missing[] = 'Kategori belum dipilih';
        }
        
        if (!$profile->kecamatan_id) {
            $missing[] = 'Kecamatan belum dipilih';
        }
        
        if (strlen($profile->deskripsi) < 50) {
            $missing[] = 'Deskripsi terlalu singkat (minimal 50 karakter)';
        }
        
        if (empty($profile->whatsapp)) {
            $missing[] = 'Nomor WhatsApp belum diisi';
        }
        
        if (!$profile->logo_path && empty($profile->photos)) {
            $missing[] = 'Belum ada foto usaha (minimal 1 foto dianjurkan)';
        }
        
        if (!$profile->latitude || !$profile->longitude) {
            $missing[] = 'Lokasi usaha belum ditambahkan (opsional)';
        }
        
        return $missing;
    }
}
```

#### 1.2 UMKM Dashboard Controller Update

**File:** `app/Http/Controllers/Umkm/DashboardController.php`

```php
public function index()
{
    $user = auth()->user();
    $profile = $user->umkmProfile;
    
    if (!$profile) {
        return redirect()->route('umkm.profile.create')
            ->with('info', 'Silakan lengkapi profil usaha Anda');
    }
    
    $completionService = app(ProfileCompletionService::class);
    
    $completion = $completionService->calculateScore($profile);
    $status = $completionService->getStatus($completion);
    $missingFields = $completionService->getMissingFields($profile);
    
    // Update score in database
    $profile->update(['profile_completion_score' => $completion]);
    
    // Get flags if any
    $flags = $profile->flags()->where('status', 'active')->get();
    
    return view('umkm.dashboard', compact(
        'profile',
        'completion',
        'status',
        'missingFields',
        'flags'
    ));
}
```

#### 1.3 Maps Integration (Optional)

**File:** `app/Http/Controllers/Umkm/ProfileController.php`

Add methods for location management:

```php
public function updateLocation(Request $request)
{
    $validated = $request->validate([
        'latitude' => 'nullable|numeric|between:-90,90',
        'longitude' => 'nullable|numeric|between:-180,180',
        'address_display' => 'nullable|string|max:255',
    ]);
    
    $profile = auth()->user()->umkmProfile;
    
    $profile->update([
        'latitude' => $validated['latitude'],
        'longitude' => $validated['longitude'],
        'address_display' => $validated['address_display'],
    ]);
    
    return back()->with('success', 'Lokasi usaha berhasil diperbarui');
}

public function removeLocation()
{
    $profile = auth()->user()->umkmProfile;
    
    $profile->update([
        'latitude' => null,
        'longitude' => null,
        'address_display' => null,
    ]);
    
    return back()->with('success', 'Lokasi usaha berhasil dihapus');
}
```

---

### Phase 2: SEO System (Automatic)

#### 2.1 SEO Service

**File:** `app/Services/SeoService.php`

```php
class SeoService
{
    public function generateMetadata(UmkmProfile $profile): array
    {
        $title = $this->generateTitle($profile);
        $description = $this->generateDescription($profile);
        
        return [
            'seo_title' => $title,
            'seo_description' => $description,
        ];
    }
    
    private function generateTitle(UmkmProfile $profile): string
    {
        $parts = [
            $profile->nama_usaha,
            $profile->category->nama_kategori ?? '',
            'di ' . ($profile->district->nama_kecamatan ?? ''),
        ];
        
        $title = implode(' - ', array_filter($parts));
        
        // Add suffix
        $title .= ' | NovaDex';
        
        // Limit to 60 characters for SEO
        if (strlen($title) > 60) {
            $title = substr($title, 0, 57) . '...';
        }
        
        return $title;
    }
    
    private function generateDescription(UmkmProfile $profile): string
    {
        $description = strip_tags($profile->deskripsi);
        
        // Limit to 155 characters for SEO
        if (strlen($description) > 155) {
            $description = substr($description, 0, 152) . '...';
        }
        
        return $description;
    }
    
    public function generateStructuredData(UmkmProfile $profile): array
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $profile->nama_usaha,
            'description' => $profile->deskripsi,
            'telephone' => $profile->whatsapp,
            'url' => route('umkm.show', $profile->slug),
        ];
        
        // Add address if available
        if ($profile->latitude && $profile->longitude) {
            $data['address'] = [
                '@type' => 'PostalAddress',
                'addressLocality' => $profile->district->nama_kecamatan ?? '',
                'addressRegion' => 'Salatiga',
                'addressCountry' => 'ID',
            ];
            
            $data['geo'] = [
                '@type' => 'GeoCoordinates',
                'latitude' => $profile->latitude,
                'longitude' => $profile->longitude,
            ];
        }
        
        // Add image if available
        if ($profile->logo_path) {
            $data['image'] = asset('storage/' . $profile->logo_path);
        }
        
        return $data;
    }
    
    public function generateAltText(UmkmProfile $profile, string $type = 'logo', int $index = null): string
    {
        $base = $profile->nama_usaha;
        
        switch ($type) {
            case 'logo':
                return "{$base} - Logo";
            case 'photo':
                return "{$base} - Foto " . ($index + 1);
            default:
                return $base;
        }
    }
}
```

#### 2.2 Sitemap Controller

**File:** `app/Http/Controllers/SitemapController.php`

```php
class SitemapController extends Controller
{
    public function index()
    {
        $profiles = UmkmProfile::where('is_published', true)
            ->orderBy('updated_at', 'desc')
            ->get();
        
        return response()->view('sitemap.index', compact('profiles'))
            ->header('Content-Type', 'text/xml');
    }
}
```

**File:** `resources/views/sitemap/index.blade.php`

```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Homepage -->
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    
    <!-- Catalog -->
    <url>
        <loc>{{ route('umkm.index') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    
    <!-- UMKM Profiles -->
    @foreach($profiles as $profile)
    <url>
        <loc>{{ route('umkm.show', $profile->slug) }}</loc>
        <lastmod>{{ $profile->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
</urlset>
```

---

### Phase 3: Admin Dashboard Enhancements

#### 3.1 Admin Dashboard Controller

**File:** `app/Http/Controllers/Admin/DashboardController.php`

```php
public function index()
{
    $stats = [
        'total_umkm' => UmkmProfile::count(),
        'published_umkm' => UmkmProfile::where('is_published', true)->count(),
        'unpublished_umkm' => UmkmProfile::where('is_published', false)->count(),
        
        // Data quality indicators
        'without_photos' => UmkmProfile::whereNull('logo_path')
            ->whereJsonLength('photos', 0)
            ->count(),
        'short_descriptions' => UmkmProfile::whereRaw('LENGTH(deskripsi) < 50')->count(),
        'without_location' => UmkmProfile::whereNull('latitude')->count(),
        'inactive_profiles' => UmkmProfile::where('updated_at', '<', now()->subDays(90))->count(),
    ];
    
    // UMKM by category
    $byCategory = UmkmProfile::join('categories', 'umkm_profiles.kategori_id', '=', 'categories.id')
        ->select('categories.nama_kategori', DB::raw('COUNT(*) as total'))
        ->groupBy('categories.id', 'categories.nama_kategori')
        ->get();
    
    // UMKM by district
    $byDistrict = UmkmProfile::join('districts', 'umkm_profiles.kecamatan_id', '=', 'districts.id')
        ->select('districts.nama_kecamatan', DB::raw('COUNT(*) as total'))
        ->groupBy('districts.id', 'districts.nama_kecamatan')
        ->get();
    
    // Recent activities
    $recentActivities = ActivityLog::latest()->take(10)->get();
    
    return view('admin.dashboard', compact('stats', 'byCategory', 'byDistrict', 'recentActivities'));
}
```

#### 3.2 Content Monitoring

**File:** `app/Http/Controllers/Admin/ContentController.php`

```php
class ContentController extends Controller
{
    public function index(Request $request)
    {
        $query = UmkmProfile::with(['category', 'district', 'user'])
            ->where('is_published', true);
        
        // Filters
        if ($request->filled('category')) {
            $query->where('kategori_id', $request->category);
        }
        
        if ($request->filled('district')) {
            $query->where('kecamatan_id', $request->district);
        }
        
        if ($request->filled('quality')) {
            switch ($request->quality) {
                case 'no_photo':
                    $query->whereNull('logo_path')->whereJsonLength('photos', 0);
                    break;
                case 'short_desc':
                    $query->whereRaw('LENGTH(deskripsi) < 50');
                    break;
                case 'no_location':
                    $query->whereNull('latitude');
                    break;
                case 'low_completion':
                    $query->where('profile_completion_score', '<', 50);
                    break;
            }
        }
        
        $profiles = $query->paginate(20);
        $categories = Category::all();
        $districts = District::all();
        
        return view('admin.content.index', compact('profiles', 'categories', 'districts'));
    }
    
    public function show(UmkmProfile $profile)
    {
        // Read-only view
        $profile->load(['category', 'district', 'user']);
        
        // NO contact info shown (privacy)
        $profile->makeHidden(['whatsapp', 'user.email']);
        
        return view('admin.content.show', compact('profile'));
    }
}
```

#### 3.3 Profile Flagging System

**File:** `app/Http/Controllers/Admin/FlagController.php`

```php
class FlagController extends Controller
{
    public function store(Request $request, UmkmProfile $profile)
    {
        $validated = $request->validate([
            'flag_type' => 'required|in:inappropriate,duplicate,incomplete,quality',
            'reason' => 'nullable|string|max:500',
        ]);
        
        ProfileFlag::create([
            'umkm_profile_id' => $profile->id,
            'admin_user_id' => auth()->id(),
            'flag_type' => $validated['flag_type'],
            'reason' => $validated['reason'],
            'status' => 'active',
        ]);
        
        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'flag_profile',
            'description' => "Flagged profile: {$profile->nama_usaha}",
        ]);
        
        return back()->with('success', 'Profil berhasil ditandai untuk review');
    }
    
    public function resolve(ProfileFlag $flag)
    {
        $flag->update([
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);
        
        return back()->with('success', 'Flag berhasil diselesaikan');
    }
}
```

---

### Phase 4: Superadmin Strategic Dashboard

#### 4.1 Superadmin Dashboard Controller

**File:** `app/Http/Controllers/SuperAdmin/DashboardController.php`

Update to be READ-ONLY with aggregate data:

```php
public function index()
{
    // Aggregate statistics only
    $stats = [
        'total_umkm' => UmkmProfile::count(),
        'published_umkm' => UmkmProfile::where('is_published', true)->count(),
        'total_categories' => Category::count(),
        'total_districts' => District::count(),
        'avg_completion' => UmkmProfile::avg('profile_completion_score'),
    ];
    
    // Growth trend (last 90 days)
    $growthTrend = UmkmProfile::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->where('created_at', '>=', now()->subDays(90))
        ->groupBy('date')
        ->orderBy('date')
        ->get();
    
    // Category distribution
    $categoryDistribution = UmkmProfile::join('categories', 'umkm_profiles.kategori_id', '=', 'categories.id')
        ->select('categories.nama_kategori', DB::raw('COUNT(*) as total'))
        ->groupBy('categories.id', 'categories.nama_kategori')
        ->get();
    
    // District distribution
    $districtDistribution = UmkmProfile::join('districts', 'umkm_profiles.kecamatan_id', '=', 'districts.id')
        ->select('districts.nama_kecamatan', DB::raw('COUNT(*) as total'))
        ->groupBy('districts.id', 'districts.nama_kecamatan')
        ->get();
    
    // Publish rate trend
    $publishRate = [
        'published' => UmkmProfile::where('is_published', true)->count(),
        'unpublished' => UmkmProfile::where('is_published', false)->count(),
    ];
    
    return view('superadmin.dashboard', compact(
        'stats',
        'growthTrend',
        'categoryDistribution',
        'districtDistribution',
        'publishRate'
    ));
}

public function exportReport()
{
    // Generate PDF report with aggregate data only
    $data = [
        'stats' => [...],
        'charts' => [...],
        'generated_at' => now(),
    ];
    
    $pdf = PDF::loadView('superadmin.reports.aggregate', $data);
    
    return $pdf->download('arsa-report-' . now()->format('Y-m-d') . '.pdf');
}
```

---

## UI/UX Design Guidelines

### 1. UMKM Dashboard

**Copy Guidelines:**
- ❌ Avoid: "SEO Score", "Metadata", "Optimization"
- ✅ Use: "Profil Anda", "Kelengkapan", "Status"

**Status Indicators:**
- "Profil Aktif" (green badge) - Published
- "Profil Tidak Aktif" (gray badge) - Unpublished
- "Profil Optimal" (gold badge) - Completion > 80%
- "Profil Perlu Dilengkapi" (orange badge) - Completion < 50%

**Progress Bar:**
```html
<div class="progress-bar">
    <div class="progress-fill" style="width: {{ $completion }}%"></div>
</div>
<p class="text-sm">{{ $status }} - {{ $completion }}%</p>
```

**Missing Fields Checklist:**
```html
<ul class="checklist">
    @foreach($missingFields as $field)
    <li class="text-gray-400">
        <svg>...</svg> {{ $field }}
    </li>
    @endforeach
</ul>
```

### 2. Maps Integration UI

**Location Input:**
```html
<div class="location-section">
    <h3>Lokasi Usaha (Opsional)</h3>
    <p class="help-text">
        Tambahkan lokasi usaha agar pelanggan lebih mudah menemukan Anda
    </p>
    
    <div class="map-container">
        <div id="map" style="height: 400px;"></div>
    </div>
    
    <div class="location-input">
        <input type="text" name="address_display" 
               placeholder="Contoh: Jl. Diponegoro No. 123, Salatiga">
        <button type="button" onclick="geocodeAddress()">
            Cari di Peta
        </button>
    </div>
    
    <p class="privacy-note">
        <svg>...</svg>
        Lokasi ini akan ditampilkan di peta publik
    </p>
</div>
```

### 3. Admin Dashboard

**Data Quality Indicators:**
```html
<div class="quality-grid">
    <div class="quality-card">
        <div class="icon">📷</div>
        <div class="count">{{ $stats['without_photos'] }}</div>
        <div class="label">Tanpa Foto</div>
        <a href="?quality=no_photo">Lihat Detail</a>
    </div>
    
    <div class="quality-card">
        <div class="icon">📝</div>
        <div class="count">{{ $stats['short_descriptions'] }}</div>
        <div class="label">Deskripsi Singkat</div>
        <a href="?quality=short_desc">Lihat Detail</a>
    </div>
    
    <!-- More cards... -->
</div>
```

---

## Testing Strategy

### Unit Tests

1. **ProfileCompletionService Test**
```php
test('calculates profile completion score correctly', function () {
    $profile = UmkmProfile::factory()->create([
        'nama_usaha' => 'Test',
        'kategori_id' => 1,
        'kecamatan_id' => 1,
        'deskripsi' => str_repeat('a', 50),
        'whatsapp' => '081234567890',
        'logo_path' => 'logo.jpg',
        'latitude' => -7.123,
        'longitude' => 110.456,
    ]);
    
    $service = new ProfileCompletionService();
    $score = $service->calculateScore($profile);
    
    expect($score)->toBe(100);
});
```

2. **SEO Service Test**
```php
test('generates SEO metadata correctly', function () {
    $profile = UmkmProfile::factory()->create();
    
    $service = new SeoService();
    $metadata = $service->generateMetadata($profile);
    
    expect($metadata)->toHaveKeys(['seo_title', 'seo_description']);
    expect(strlen($metadata['seo_title']))->toBeLessThanOrEqual(60);
    expect(strlen($metadata['seo_description']))->toBeLessThanOrEqual(155);
});
```

### Integration Tests

1. **UMKM Dashboard Test**
```php
test('UMKM can see profile completion indicator', function () {
    $user = User::factory()->umkm()->create();
    $profile = UmkmProfile::factory()->for($user)->create();
    
    $response = $this->actingAs($user)->get(route('umkm.dashboard'));
    
    $response->assertOk();
    $response->assertSee('Kelengkapan Profil');
    $response->assertSee('%');
});
```

2. **Admin Content Monitoring Test**
```php
test('admin can view content but not edit', function () {
    $admin = User::factory()->admin()->create();
    $profile = UmkmProfile::factory()->create();
    
    $response = $this->actingAs($admin)->get(route('admin.content.show', $profile));
    
    $response->assertOk();
    $response->assertDontSee('Edit');
    $response->assertDontSee($profile->whatsapp); // Privacy protected
});
```

---

## Performance Optimization

### 1. Database Indexes

```sql
-- Already added in migration
CREATE INDEX idx_location ON umkm_profiles(latitude, longitude);
CREATE INDEX idx_completion ON umkm_profiles(profile_completion_score);
CREATE INDEX idx_published ON umkm_profiles(is_published);
```

### 2. Caching Strategy

```php
// Cache sitemap for 1 day
Cache::remember('sitemap', 86400, function () {
    return UmkmProfile::where('is_published', true)->get();
});

// Cache dashboard stats for 1 hour
Cache::remember('admin.dashboard.stats', 3600, function () {
    return [
        'total_umkm' => UmkmProfile::count(),
        // ...
    ];
});
```

### 3. Eager Loading

```php
// Avoid N+1 queries
$profiles = UmkmProfile::with(['category', 'district', 'user'])
    ->where('is_published', true)
    ->paginate(20);
```

---

## Security Considerations

### 1. Privacy Protection

```php
// Hide sensitive data from admin
$profile->makeHidden(['whatsapp', 'user.email']);

// Policy check
if (!auth()->user()->can('view', $profile)) {
    abort(403);
}
```

### 2. Input Validation

```php
// Location validation
$request->validate([
    'latitude' => 'nullable|numeric|between:-90,90',
    'longitude' => 'nullable|numeric|between:-180,180',
    'address_display' => 'nullable|string|max:255',
]);
```

### 3. XSS Prevention

```php
// Sanitize user input
$profile->deskripsi = strip_tags($request->deskripsi, '<p><br><strong><em>');
```

---

## Deployment Checklist

- [ ] Run database migrations
- [ ] Update `.env` with geocoding API key (if using)
- [ ] Clear all caches
- [ ] Rebuild assets
- [ ] Test all roles (UMKM, Admin, Superadmin)
- [ ] Verify SEO metadata generation
- [ ] Test sitemap generation
- [ ] Verify maps integration
- [ ] Check privacy protection
- [ ] Performance testing
- [ ] Security audit

---

## Rollback Plan

If issues occur:
1. Revert database migrations (rollback)
2. Restore previous code version
3. Clear caches
4. Notify users of temporary downtime

---

**Document Version:** 1.0  
**Created:** 2026-02-06  
**Status:** Ready for Implementation  
**Next Step:** Create Tasks Document
