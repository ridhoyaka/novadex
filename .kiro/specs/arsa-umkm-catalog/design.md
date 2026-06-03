# Design Document: ARSA UMKM Catalog Platform

## Overview

ARSA is a Laravel 11-based web application that serves as a digital catalog for MSMEs in Salatiga City. The architecture follows Laravel's MVC pattern with clear separation between public-facing catalog features, authenticated UMKM owner dashboards, and administrative interfaces.

The system is designed around four core user experiences:
1. **Public Catalog** - Unauthenticated browsing and discovery
2. **UMKM Dashboard** - Business owner profile management
3. **Admin Dashboard** - Government aggregate data and reporting
4. **Super Admin Panel** - System administration and master data management

The platform emphasizes simplicity, elegant design, and catalog functionality rather than transactional complexity. It uses Laravel 11's modern features including route model binding, form requests, policies, and Eloquent relationships to maintain clean, maintainable code.

## Architecture

### High-Level Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                        Web Browser                           │
└────────────────────┬────────────────────────────────────────┘
                     │ HTTP/HTTPS
┌────────────────────▼────────────────────────────────────────┐
│                    Laravel 11 Application                    │
│  ┌──────────────────────────────────────────────────────┐  │
│  │                    Routes Layer                       │  │
│  │  • web.php (Public + Auth routes)                    │  │
│  │  • Middleware (auth, role-based)                     │  │
│  └──────────────────┬───────────────────────────────────┘  │
│                     │                                        │
│  ┌──────────────────▼───────────────────────────────────┐  │
│  │                Controllers Layer                      │  │
│  │  • Public: Home, Catalog, Detail, Map                │  │
│  │  • Auth: Dashboard, Profile                          │  │
│  │  • Admin: Dashboard, Reports, Map                    │  │
│  │  • SuperAdmin: Users, Categories, Districts          │  │
│  └──────────────────┬───────────────────────────────────┘  │
│                     │                                        │
│  ┌──────────────────▼───────────────────────────────────┐  │
│  │              Business Logic Layer                     │  │
│  │  • Services (UmkmService, ReportService)             │  │
│  │  • Policies (UmkmProfilePolicy)                      │  │
│  │  • Form Requests (Validation)                        │  │
│  └──────────────────┬───────────────────────────────────┘  │
│                     │                                        │
│  ┌──────────────────▼───────────────────────────────────┐  │
│  │                  Data Layer                           │  │
│  │  • Eloquent Models (User, UmkmProfile, etc.)         │  │
│  │  • Relationships & Scopes                            │  │
│  └──────────────────┬───────────────────────────────────┘  │
└────────────────────┬┴───────────────────────────────────────┘
                     │
┌────────────────────▼────────────────────────────────────────┐
│                    MySQL Database                            │
│  • users, umkm_profiles, categories, districts              │
│  • activity_logs (audit trail)                              │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                    File Storage (Local/S3)                   │
│  • Business logos, gallery photos                           │
└─────────────────────────────────────────────────────────────┘
```

### Technology Stack

- **Framework**: Laravel 11.x
- **PHP Version**: 8.2+
- **Database**: MySQL 8.0+
- **Frontend**: Blade templates with Alpine.js for interactivity
- **CSS Framework**: Tailwind CSS
- **Map Library**: Leaflet.js with OpenStreetMap tiles
- **File Storage**: Laravel Storage (local or S3-compatible)
- **Authentication**: Laravel Breeze (simplified)

### Directory Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Public/
│   │   │   ├── HomeController.php
│   │   │   ├── UmkmCatalogController.php
│   │   │   ├── UmkmDetailController.php
│   │   │   └── UmkmMapController.php
│   │   ├── Umkm/
│   │   │   ├── DashboardController.php
│   │   │   └── ProfileController.php
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── MapController.php
│   │   │   └── ReportController.php
│   │   └── SuperAdmin/
│   │       ├── UserController.php
│   │       ├── CategoryController.php
│   │       └── DistrictController.php
│   ├── Requests/
│   │   └── UmkmProfileRequest.php
│   └── Middleware/
│       └── RoleMiddleware.php
├── Models/
│   ├── User.php
│   ├── UmkmProfile.php
│   ├── Category.php
│   ├── District.php
│   └── ActivityLog.php
├── Policies/
│   └── UmkmProfilePolicy.php
├── Services/
│   ├── UmkmService.php
│   ├── ReportService.php
│   └── SlugService.php
└── Enums/
    └── UserRole.php

resources/
├── views/
│   ├── public/
│   │   ├── home.blade.php
│   │   ├── catalog.blade.php
│   │   ├── detail.blade.php
│   │   └── map.blade.php
│   ├── umkm/
│   │   ├── dashboard.blade.php
│   │   └── profile-form.blade.php
│   ├── admin/
│   │   ├── dashboard.blade.php
│   │   ├── map.blade.php
│   │   └── reports.blade.php
│   └── super-admin/
│       ├── users.blade.php
│       ├── categories.blade.php
│       └── districts.blade.php
└── css/
    └── app.css (Tailwind)

database/
├── migrations/
│   ├── 2024_01_01_create_users_table.php
│   ├── 2024_01_02_create_categories_table.php
│   ├── 2024_01_03_create_districts_table.php
│   ├── 2024_01_04_create_umkm_profiles_table.php
│   └── 2024_01_05_create_activity_logs_table.php
└── seeders/
    ├── CategorySeeder.php
    └── DistrictSeeder.php
```

## Components and Interfaces

### 1. Models and Relationships

#### User Model
```php
class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'role'];
    
    protected $casts = [
        'role' => UserRole::class,
    ];
    
    // Relationship
    public function umkmProfile(): HasOne
    
    // Helper methods
    public function isUmkm(): bool
    public function isAdmin(): bool
    public function isSuperAdmin(): bool
}
```

#### UmkmProfile Model
```php
class UmkmProfile extends Model
{
    protected $fillable = [
        'user_id', 'nama_usaha', 'slug', 'kategori_id', 
        'kecamatan_id', 'deskripsi', 'whatsapp', 
        'logo_path', 'is_published'
    ];
    
    protected $casts = [
        'is_published' => 'boolean',
        'photos' => 'array',
    ];
    
    // Relationships
    public function user(): BelongsTo
    public function category(): BelongsTo
    public function district(): BelongsTo
    
    // Scopes
    public function scopePublished($query)
    public function scopeByCategory($query, $categoryId)
    public function scopeByDistrict($query, $districtId)
    public function scopeSearch($query, $term)
    
    // Accessors
    public function getPublicUrlAttribute(): string
    public function getWhatsappLinkAttribute(): string
    public function getProfileCompletionAttribute(): int
}
```

#### Category Model
```php
class Category extends Model
{
    protected $fillable = ['nama_kategori', 'slug', 'icon'];
    
    // Relationships
    public function umkmProfiles(): HasMany
    
    // Helper
    public function canBeDeleted(): bool
}
```

#### District Model
```php
class District extends Model
{
    protected $fillable = ['nama_kecamatan', 'latitude', 'longitude'];
    
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];
    
    // Relationships
    public function umkmProfiles(): HasMany
    
    // Helper
    public function canBeDeleted(): bool
}
```

#### ActivityLog Model
```php
class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'action', 'model_type', 
        'model_id', 'changes', 'ip_address'
    ];
    
    protected $casts = [
        'changes' => 'array',
    ];
    
    // Relationships
    public function user(): BelongsTo
    public function subject(): MorphTo
}
```

### 2. Services

#### UmkmService
Handles business logic for UMKM operations:
```php
class UmkmService
{
    public function createProfile(User $user, array $data): UmkmProfile
    public function updateProfile(UmkmProfile $profile, array $data): UmkmProfile
    public function togglePublishStatus(UmkmProfile $profile): void
    public function uploadLogo(UmkmProfile $profile, UploadedFile $file): string
    public function uploadGalleryPhoto(UmkmProfile $profile, UploadedFile $file): void
    public function deleteGalleryPhoto(UmkmProfile $profile, string $photoPath): void
    public function getPublicCatalog(array $filters): LengthAwarePaginator
    public function calculateProfileCompletion(UmkmProfile $profile): int
}
```

#### SlugService
Handles slug generation and uniqueness:
```php
class SlugService
{
    public function generateUniqueSlug(string $text, string $model): string
    public function slugify(string $text): string
    private function ensureUnique(string $slug, string $model, int $attempt = 0): string
}
```

#### ReportService
Handles aggregate data and report generation:
```php
class ReportService
{
    public function getCityStatistics(): array
    public function getUmkmByDistrict(): Collection
    public function getUmkmByCategory(): Collection
    public function getDigitalReadinessStats(): array
    public function exportToPdf(array $data): Response
    public function exportToExcel(array $data): Response
    public function getMapData(array $filters = []): array
}
```

### 3. Controllers

#### Public Controllers

**HomeController**
- `index()`: Display landing page with featured categories and newest UMKMs

**UmkmCatalogController**
- `index(Request $request)`: Display paginated catalog with filters and search

**UmkmDetailController**
- `show(string $slug)`: Display UMKM detail page by slug

**UmkmMapController**
- `index()`: Display public map with district-level aggregates

#### UMKM Controllers

**DashboardController**
- `index()`: Display UMKM owner dashboard with profile status

**ProfileController**
- `edit()`: Show profile edit form
- `update(UmkmProfileRequest $request)`: Update profile
- `togglePublish()`: Toggle publication status
- `uploadLogo(Request $request)`: Handle logo upload
- `uploadPhoto(Request $request)`: Handle gallery photo upload
- `deletePhoto(Request $request)`: Delete gallery photo

#### Admin Controllers

**Admin\DashboardController**
- `index()`: Display city statistics dashboard

**Admin\MapController**
- `index(Request $request)`: Display internal map with filters

**Admin\ReportController**
- `index()`: Display reports interface
- `exportPdf()`: Generate PDF report
- `exportExcel()`: Generate Excel report

#### Super Admin Controllers

**SuperAdmin\UserController**
- `index()`: List all users
- `create()`: Show user creation form
- `store(Request $request)`: Create new user
- `edit(User $user)`: Show user edit form
- `update(Request $request, User $user)`: Update user
- `destroy(User $user)`: Delete user

**SuperAdmin\CategoryController**
- Standard resource controller for categories

**SuperAdmin\DistrictController**
- Standard resource controller for districts

### 4. Policies

#### UmkmProfilePolicy
```php
class UmkmProfilePolicy
{
    public function view(User $user, UmkmProfile $profile): bool
    public function update(User $user, UmkmProfile $profile): bool
    public function delete(User $user, UmkmProfile $profile): bool
    public function publish(User $user, UmkmProfile $profile): bool
}
```

Policy rules:
- UMKM owners can only view/update their own profile
- Admins can view all profiles (read-only)
- Super admins can view/update/publish any profile

### 5. Middleware

#### RoleMiddleware
```php
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || $request->user()->role->value !== $role) {
            abort(403, 'Unauthorized action.');
        }
        
        return $next($request);
    }
}
```

### 6. Form Requests

#### UmkmProfileRequest
```php
class UmkmProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama_usaha' => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'kecamatan_id' => 'required|exists:districts,id',
            'deskripsi' => 'required|string|max:1000',
            'whatsapp' => 'required|string|regex:/^[0-9]{10,15}$/',
            'logo' => 'nullable|image|max:2048',
            'photos.*' => 'nullable|image|max:2048',
        ];
    }
}
```

## Data Models

### Database Schema

#### users
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('umkm', 'admin', 'super_admin') NOT NULL DEFAULT 'umkm',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_role (role)
);
```

#### categories
```sql
CREATE TABLE categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nama_kategori VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    icon VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_slug (slug)
);
```

#### districts
```sql
CREATE TABLE districts (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nama_kecamatan VARCHAR(255) NOT NULL,
    latitude DECIMAL(10, 8) NOT NULL,
    longitude DECIMAL(11, 8) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

#### umkm_profiles
```sql
CREATE TABLE umkm_profiles (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED UNIQUE NOT NULL,
    nama_usaha VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    kategori_id BIGINT UNSIGNED NOT NULL,
    kecamatan_id BIGINT UNSIGNED NOT NULL,
    deskripsi TEXT NOT NULL,
    whatsapp VARCHAR(20) NOT NULL,
    logo_path VARCHAR(255) NULL,
    photos JSON NULL,
    is_published BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (kategori_id) REFERENCES categories(id) ON DELETE RESTRICT,
    FOREIGN KEY (kecamatan_id) REFERENCES districts(id) ON DELETE RESTRICT,
    INDEX idx_slug (slug),
    INDEX idx_is_published (is_published),
    INDEX idx_kategori (kategori_id),
    INDEX idx_kecamatan (kecamatan_id),
    FULLTEXT INDEX idx_nama_usaha (nama_usaha)
);
```

#### activity_logs
```sql
CREATE TABLE activity_logs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NULL,
    action VARCHAR(255) NOT NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,
    changes JSON NULL,
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_model (model_type, model_id),
    INDEX idx_user (user_id),
    INDEX idx_created_at (created_at)
);
```

### Data Relationships

```
User (1) ──────── (1) UmkmProfile
                       │
                       ├── (N) ──── (1) Category
                       │
                       └── (N) ──── (1) District

User (1) ──────── (N) ActivityLog
```

### Data Flow Examples

#### Public Catalog Browsing
1. User visits `/umkm` with optional filters (category, district, search)
2. Controller calls `UmkmService::getPublicCatalog($filters)`
3. Service builds query with scopes: `published()`, `byCategory()`, `byDistrict()`, `search()`
4. Query eager loads `category` and `district` relationships
5. Results paginated and returned to view
6. View renders cards with business data

#### UMKM Profile Update
1. UMKM owner submits profile form
2. `UmkmProfileRequest` validates input
3. `UmkmProfilePolicy` checks ownership
4. Controller calls `UmkmService::updateProfile($profile, $data)`
5. Service updates profile, handles file uploads if present
6. Service logs change via `ActivityLog::create()`
7. Redirect to dashboard with success message

#### Admin Report Generation
1. Admin clicks "Export PDF" on reports page
2. Controller calls `ReportService::exportToPdf()`
3. Service gathers statistics: total UMKMs, by district, by category
4. Service generates PDF using Laravel's PDF library
5. PDF downloaded to admin's device

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system—essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*


### Property 1: Catalog Filtering Correctness
*For any* set of UMKM businesses and any filter combination (category, district, or both), all returned results should match the applied filter criteria, and no matching businesses should be excluded.
**Validates: Requirements 2.3, 2.4, 9.2, 9.3**

### Property 2: Search Query Matching
*For any* search query string, all returned UMKM businesses should have names that contain the search term (case-insensitive), and the search should combine correctly with active filters.
**Validates: Requirements 2.5, 20.1, 20.5**

### Property 3: Publication Status Visibility
*For any* UMKM business profile, it should appear in public catalog results, public map data, and exported reports if and only if its publication status is set to published.
**Validates: Requirements 2.6, 10.5, 13.3**

### Property 4: UMKM Card Content Completeness
*For any* published UMKM business, its catalog card should display the business logo/photo, business name, category name, and district name.
**Validates: Requirements 2.2**

### Property 5: Detail Page Routing
*For any* UMKM business with a unique slug, accessing the URL `/umkm/{slug}` should load that specific business's detail page with correct data.
**Validates: Requirements 3.1**

### Property 6: Detail Page Content Completeness
*For any* UMKM business detail page, it should display the business name, category, district, description, and respect the maximum of 3 photos in the gallery.
**Validates: Requirements 3.2, 3.3**

### Property 7: WhatsApp Link Generation
*For any* UMKM business with a WhatsApp number, the detail page should generate a correctly formatted WhatsApp URL (wa.me format) that pre-fills the business's phone number.
**Validates: Requirements 3.4, 17.1, 17.2**

### Property 8: Sensitive Data Exclusion
*For any* public-facing page or API endpoint, the response should not contain email addresses, internal identifiers, financial data, or other sensitive business information.
**Validates: Requirements 3.5, 14.5**

### Property 9: Map District Aggregation
*For any* set of UMKM businesses, the map should display district-level markers with accurate counts, and clicking a marker should show the correct number of businesses in that district.
**Validates: Requirements 4.2, 4.3**

### Property 10: Geographic Privacy
*For any* UMKM business on the public map, the system should not display precise coordinates or detailed addresses, only district-level information.
**Validates: Requirements 4.4**

### Property 11: User Registration and Authentication
*For any* valid registration data (name, email, password), the system should create a new UMKM_Owner account, and subsequent login with those credentials should grant authenticated access.
**Validates: Requirements 5.1, 5.2**

### Property 12: Password Security Validation
*For any* password input during registration or reset, the system should enforce security requirements (minimum length, complexity) and reject non-compliant passwords.
**Validates: Requirements 5.4, 17.3**

### Property 13: Profile Completion Status
*For any* UMKM business profile, the dashboard should accurately calculate and display whether the profile is Complete (all required fields filled) or Incomplete.
**Validates: Requirements 6.1**

### Property 14: Public Profile Preview Consistency
*For any* UMKM business profile, the preview shown in the owner's dashboard should match exactly what Public_Users see on the detail page.
**Validates: Requirements 6.2**

### Property 15: Publication Toggle Effect
*For any* UMKM business profile, toggling the publication status should immediately update the is_published field and affect catalog visibility accordingly.
**Validates: Requirements 6.5**

### Property 16: Profile Data Persistence
*For any* valid UMKM profile form submission, all provided data (business name, category, district, description, WhatsApp, photos) should be saved correctly and retrievable.
**Validates: Requirements 7.2**

### Property 17: Photo Upload Limits
*For any* UMKM business profile, the system should allow uploading exactly 1 logo and up to 3 gallery photos, rejecting additional uploads beyond these limits.
**Validates: Requirements 7.3, 19.3**

### Property 18: Slug Generation and Uniqueness
*For any* business name, the system should generate a URL-safe slug (lowercase, alphanumeric, hyphens only), and when collisions occur, append a numeric suffix to ensure uniqueness.
**Validates: Requirements 7.4, 18.1, 18.2, 18.3**

### Property 19: Slug Stability
*For any* existing UMKM business profile, updating the business name should preserve the original slug unchanged.
**Validates: Requirements 18.4**

### Property 20: Prohibited Data Collection
*For any* UMKM profile form, the system should not include fields for financial data, transaction records, or legal documents.
**Validates: Requirements 7.5**

### Property 21: Dashboard Statistics Accuracy
*For any* set of UMKM businesses, the admin dashboard should display accurate counts for total MSMEs, MSMEs per district, and MSMEs per category.
**Validates: Requirements 8.1, 8.2, 8.3**

### Property 22: Statistics Data Freshness
*For any* change to UMKM data (creation, update, deletion, publication status change), the admin dashboard statistics should reflect the updated values.
**Validates: Requirements 8.5**

### Property 23: Report Content Completeness
*For any* exported report (PDF or Excel), it should include district-based breakdowns, category-based breakdowns, and only published UMKM data.
**Validates: Requirements 10.4**

### Property 24: Role-Based Access Control
*For any* user and any route, access should be granted if and only if the user's role has permission for that route (public routes for all, dashboard routes for authenticated users, admin routes for admins, super admin routes for super admins).
**Validates: Requirements 11.5, 14.1, 14.4**

### Property 25: UMKM Owner Data Isolation
*For any* UMKM_Owner user, they should be able to view and edit only their own Business_Profile, and attempts to access other profiles should be denied.
**Validates: Requirements 14.2**

### Property 26: Admin Read-Only Access
*For any* Admin user, they should have read access to all UMKM data but write operations (create, update, delete) on UMKM profiles should be blocked.
**Validates: Requirements 9.5, 14.3**

### Property 27: Super Admin User Management
*For any* user account, a Super_Admin should be able to create, modify roles, and delete the account.
**Validates: Requirements 11.2, 11.3, 11.4**

### Property 28: Master Data CRUD Operations
*For any* category or district record, a Super_Admin should be able to create, update, and delete it, unless it is referenced by existing UMKM profiles.
**Validates: Requirements 12.2, 12.4, 12.5**

### Property 29: Super Admin Publication Control
*For any* UMKM business profile, a Super_Admin should be able to change its publication status, overriding the owner's setting.
**Validates: Requirements 13.2**

### Property 30: Audit Logging Completeness
*For any* modification to UMKM profiles, master data, or publication status, the system should create an audit log entry with timestamp, user identifier, action type, and changed data.
**Validates: Requirements 13.4, 15.1, 15.2, 15.3**

### Property 31: File Type Validation
*For any* uploaded file (logo or gallery photo), the system should validate that it is an accepted image format (JPEG, PNG, WebP) and reject non-image files.
**Validates: Requirements 19.1**

### Property 32: File Size Validation
*For any* uploaded image file, the system should enforce a maximum size of 2MB and reject larger files.
**Validates: Requirements 19.2**

### Property 33: Image Optimization
*For any* uploaded image, the system should generate optimized versions (thumbnail, medium, large) for different display contexts.
**Validates: Requirements 19.5**

### Property 34: Search Result Highlighting
*For any* search query with matching results, the displayed business names should highlight the matching text portions.
**Validates: Requirements 20.3**

## Error Handling

### Error Categories

1. **Validation Errors**
   - Invalid form input (missing required fields, incorrect formats)
   - File upload errors (wrong type, too large, too many files)
   - Slug collision errors
   - Response: Return to form with specific error messages, preserve user input

2. **Authentication Errors**
   - Invalid credentials
   - Expired sessions
   - Unverified email
   - Response: Redirect to login with error message, provide password reset option

3. **Authorization Errors**
   - Insufficient permissions for route
   - Attempting to access another user's data
   - Response: HTTP 403 Forbidden, redirect to appropriate dashboard

4. **Not Found Errors**
   - Invalid UMKM slug
   - Non-existent resource ID
   - Response: HTTP 404 with helpful message and navigation options

5. **Database Errors**
   - Connection failures
   - Constraint violations (foreign key, unique)
   - Response: Log error, show generic error page, notify administrators

6. **File Storage Errors**
   - Disk space full
   - Permission issues
   - Response: Log error, show user-friendly message, allow retry

7. **External Service Errors**
   - Map tile loading failures
   - Email sending failures
   - Response: Graceful degradation, show cached data or alternative UI

### Error Handling Strategy

**User-Facing Errors:**
- Display clear, actionable error messages in Indonesian
- Preserve user input when validation fails
- Provide suggestions for resolution
- Use toast notifications for non-critical errors
- Use error pages for critical errors

**System Errors:**
- Log all errors with context (user, request, stack trace)
- Send critical errors to monitoring service
- Display generic error message to users (don't expose internals)
- Provide error reference ID for support

**Validation:**
- Use Laravel Form Requests for centralized validation
- Return JSON responses for AJAX requests
- Return redirects with error bags for form submissions
- Validate on both client-side (UX) and server-side (security)

**Database Integrity:**
- Use foreign key constraints to prevent orphaned records
- Use unique constraints for slugs and emails
- Handle constraint violations gracefully with user-friendly messages
- Use database transactions for multi-step operations

## Testing Strategy

### Dual Testing Approach

ARSA will use both unit testing and property-based testing to ensure comprehensive coverage:

**Unit Tests** focus on:
- Specific examples of correct behavior
- Edge cases (empty data, boundary conditions)
- Error conditions and validation
- Integration between components
- Specific UI elements and page content

**Property Tests** focus on:
- Universal properties that hold for all inputs
- Comprehensive input coverage through randomization
- Business logic correctness across all scenarios
- Data integrity and consistency

Both approaches are complementary and necessary. Unit tests catch concrete bugs and verify specific examples, while property tests verify general correctness across all possible inputs.

### Property-Based Testing Configuration

**Library**: Use **Pest PHP** with **Pest Property Testing Plugin** for Laravel 11
- Pest is the modern testing framework for Laravel
- Property testing plugin provides generators and property test syntax
- Integrates seamlessly with Laravel's testing features

**Configuration**:
- Minimum 100 iterations per property test (due to randomization)
- Each property test must reference its design document property
- Tag format: `// Feature: arsa-umkm-catalog, Property {number}: {property_text}`

**Example Property Test Structure**:
```php
use function Pest\Property\forAll;

test('catalog filtering returns only matching businesses', function () {
    // Feature: arsa-umkm-catalog, Property 1: Catalog Filtering Correctness
    
    forAll(
        umkmBusinessGenerator(),
        categoryIdGenerator()
    )->then(function ($businesses, $categoryId) {
        // Create test data
        foreach ($businesses as $business) {
            UmkmProfile::factory()->create($business);
        }
        
        // Apply filter
        $results = UmkmService::getPublicCatalog(['category' => $categoryId]);
        
        // Assert all results match filter
        expect($results->every(fn($umkm) => $umkm->kategori_id === $categoryId))
            ->toBeTrue();
    })->runs(100);
});
```

### Test Organization

**Unit Tests** (`tests/Unit/`):
- `Models/` - Model relationships, accessors, scopes
- `Services/` - Service class methods
- `Policies/` - Authorization rules
- `Requests/` - Form validation rules

**Feature Tests** (`tests/Feature/`):
- `Public/` - Public catalog, detail pages, map
- `Umkm/` - UMKM dashboard and profile management
- `Admin/` - Admin dashboard, reports, map
- `SuperAdmin/` - User management, master data

**Property Tests** (`tests/Property/`):
- `CatalogPropertiesTest.php` - Properties 1-10
- `AuthenticationPropertiesTest.php` - Properties 11-15
- `ProfilePropertiesTest.php` - Properties 16-20
- `AdminPropertiesTest.php` - Properties 21-23
- `AuthorizationPropertiesTest.php` - Properties 24-29
- `AuditPropertiesTest.php` - Property 30
- `FileUploadPropertiesTest.php` - Properties 31-33
- `SearchPropertiesTest.php` - Property 34

### Test Data Generators

For property-based testing, create generators for:
- UMKM business profiles (with various completeness levels)
- User accounts (with different roles)
- Categories and districts
- Search queries
- Filter combinations
- File uploads (valid and invalid)

### Coverage Goals

- Minimum 80% code coverage
- 100% coverage of critical paths (authentication, authorization, data modification)
- All 34 correctness properties implemented as property tests
- Edge cases covered by unit tests
- Integration tests for key user flows

### Testing Best Practices

1. **Isolation**: Each test should be independent, use database transactions
2. **Clarity**: Test names should clearly describe what is being tested
3. **Arrange-Act-Assert**: Follow AAA pattern for test structure
4. **Factories**: Use Laravel factories for test data generation
5. **Mocking**: Mock external services (email, file storage) in unit tests
6. **Real Integration**: Use real database and services in feature tests
7. **Performance**: Keep test suite fast, use parallel execution
8. **CI/CD**: Run tests automatically on every commit

### Manual Testing Checklist

While automated tests cover most functionality, manual testing should verify:
- Visual design and responsive layout across devices
- Map interactivity and performance
- WhatsApp link behavior on mobile devices
- PDF and Excel export formatting
- Email delivery and formatting
- Overall user experience and flow
