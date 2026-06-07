# Phase 7: Testing & Documentation Guide

## Overview
This document provides comprehensive testing instructions for NovaDex Platform Enhancement v3.0. Follow these steps to ensure all features work correctly before deployment.

---

## 1. SEO Optimization Testing (Task 17.4)

### 1.1 Google Rich Results Test
**URL:** https://search.google.com/test/rich-results

**Steps:**
1. Navigate to the Rich Results Test tool
2. Test the following pages:
   - Homepage: `https://your-domain.com/`
   - Catalog: `https://your-domain.com/katalog`
   - Sample UMKM Detail: `https://your-domain.com/umkm/[slug]`
3. Verify that structured data is detected:
   - ✅ LocalBusiness schema
   - ✅ Breadcrumb schema
   - ✅ Organization schema (homepage)
4. Fix any errors or warnings reported

**Expected Results:**
- All pages should pass validation
- No critical errors
- Structured data should be properly formatted

---

### 1.2 PageSpeed Insights
**URL:** https://pagespeed.web.dev/

**Performance Targets:**
- Homepage: > 80 (mobile & desktop)
- Catalog: > 80 (mobile & desktop)
- Detail Page: > 80 (mobile & desktop)
- Map Page: > 75 (mobile & desktop)

**Steps:**
1. Test each page URL
2. Check both Mobile and Desktop scores
3. Review Core Web Vitals:
   - LCP (Largest Contentful Paint) < 2.5s
   - FID (First Input Delay) < 100ms
   - CLS (Cumulative Layout Shift) < 0.1

**Common Issues & Fixes:**
- **Slow images:** Optimize images, use WebP format
- **Render-blocking resources:** Defer non-critical CSS/JS
- **Large JavaScript:** Code splitting, lazy loading
- **No caching:** Add cache headers

---

### 1.3 Mobile-Friendly Test
**URL:** https://search.google.com/test/mobile-friendly

**Steps:**
1. Test all public pages
2. Verify mobile usability
3. Check for:
   - ✅ Text is readable without zooming
   - ✅ Tap targets are appropriately sized
   - ✅ Content fits within viewport
   - ✅ No horizontal scrolling

**Expected Results:**
- All pages should be mobile-friendly
- No usability issues reported

---

### 1.4 Social Media Preview Testing

#### Facebook Debugger
**URL:** https://developers.facebook.com/tools/debug/

**Steps:**
1. Enter UMKM detail page URL
2. Click "Scrape Again" to refresh cache
3. Verify Open Graph tags:
   - ✅ og:title
   - ✅ og:description
   - ✅ og:image (shows correctly)
   - ✅ og:url
   - ✅ og:type = "business.business"

#### Twitter Card Validator
**URL:** https://cards-dev.twitter.com/validator

**Steps:**
1. Enter UMKM detail page URL
2. Verify Twitter Card preview
3. Check:
   - ✅ twitter:card = "summary_large_image"
   - ✅ twitter:title
   - ✅ twitter:description
   - ✅ twitter:image (displays correctly)

#### WhatsApp Preview
**Steps:**
1. Send a UMKM detail page link to yourself on WhatsApp
2. Verify link preview shows:
   - ✅ Title
   - ✅ Description
   - ✅ Image thumbnail

---

### 1.5 Sitemap Validation

**Steps:**
1. Access sitemap: `https://your-domain.com/sitemap.xml`
2. Verify XML format is valid
3. Check that all published UMKM are included
4. Validate using: https://www.xml-sitemaps.com/validate-xml-sitemap.html

**Expected Content:**
- Homepage
- Catalog page
- All published UMKM detail pages
- Valid lastmod dates
- Proper XML structure

---

## 2. Unit Testing (Task 20)

### 2.1 ProfileCompletionService Tests

**File:** `tests/Unit/Services/ProfileCompletionServiceTest.php`

**Test Cases:**
```php
// Test score calculation
- testCalculateScoreWithAllFields() // Should return 100
- testCalculateScoreWithMinimalFields() // Should return ~30
- testCalculateScoreWithPartialFields() // Should return 50-70

// Test status determination
- testGetStatusBasic() // Score < 50 = "Dasar"
- testGetStatusLengkap() // Score 50-79 = "Lengkap"
- testGetStatusOptimal() // Score >= 80 = "Optimal"

// Test missing fields detection
- testGetMissingFieldsEmpty() // Complete profile
- testGetMissingFieldsPartial() // Some fields missing
- testGetMissingFieldsAll() // Only required fields

// Edge cases
- testCalculateScoreWithNullValues()
- testCalculateScoreWithEmptyStrings()
```

**Run Tests:**
```bash
php artisan test --filter=ProfileCompletionServiceTest
```

---

### 2.2 SeoService Tests

**File:** `tests/Unit/Services/SeoServiceTest.php`

**Test Cases:**
```php
// Test metadata generation
- testGenerateMetadataComplete()
- testGenerateMetadataMinimal()

// Test title generation
- testGenerateTitleWithinLimit() // < 60 chars
- testGenerateTitleTruncation() // Long names

// Test description generation
- testGenerateDescriptionWithinLimit() // < 155 chars
- testGenerateDescriptionTruncation() // Long descriptions

// Test structured data
- testGenerateStructuredDataFormat() // Valid JSON-LD
- testGenerateStructuredDataFields() // All required fields

// Test alt text generation
- testGenerateAltTextForLogo()
- testGenerateAltTextForPhoto()

// Test placeholder generation
- testGeneratePlaceholderCategoryBased()
- testGeneratePlaceholderInitialBased()
```

**Run Tests:**
```bash
php artisan test --filter=SeoServiceTest
```

---

### 2.3 Controller Tests

**Files:**
- `tests/Feature/Umkm/DashboardControllerTest.php`
- `tests/Feature/Admin/ContentControllerTest.php`
- `tests/Feature/SuperAdmin/DashboardControllerTest.php`

**Test Cases:**
```php
// UMKM Dashboard
- testUmkmCanAccessDashboard()
- testUmkmCannotAccessOtherDashboard()
- testDashboardShowsCompletionScore()
- testDashboardShowsMissingFields()

// Admin Content Monitoring
- testAdminCanViewContent()
- testAdminCannotSeeContactInfo()
- testAdminCanFilterByQuality()
- testAdminCanFlagProfile()

// SuperAdmin Dashboard
- testSuperAdminCanViewDashboard()
- testSuperAdminCannotEditUmkm()
- testSuperAdminCanExportData()
- testSuperAdminCanViewAllData()

// Authorization
- testUnauthorizedAccessDenied()
- testRoleBasedAccess()
```

**Run Tests:**
```bash
php artisan test --filter=DashboardControllerTest
php artisan test --filter=ContentControllerTest
```

---

## 3. Integration Testing (Task 21)

### 3.1 UMKM Workflow Tests

**Scenario 1: Complete Registration Flow**
```
1. Register new UMKM account
2. Login with credentials
3. Complete profile (all fields)
4. Add location via map
5. Upload photos
6. Publish profile
7. Verify appears in public catalog
8. Verify SEO tags generated
```

**Scenario 2: Profile Update Flow**
```
1. Login as existing UMKM
2. Update business description
3. Add new photos
4. Update location
5. Save changes
6. Verify SEO regenerates
7. Verify changes appear in catalog
```

---

### 3.2 Admin Workflow Tests

**Scenario 1: Content Monitoring**
```
1. Login as Admin
2. View content monitoring page
3. Filter by "No Photo"
4. Flag a profile for quality
5. Verify UMKM sees flag
6. UMKM updates profile
7. Admin resolves flag
```

**Scenario 2: Category Management**
```
1. Login as Admin
2. Create new category
3. Verify UMKM can select it
4. Edit category name
5. Verify changes reflect everywhere
6. Try to delete (should fail if UMKM exists)
```

---

### 3.3 Public Workflow Tests

**Scenario 1: Search & Discovery**
```
1. Visit homepage
2. Click "Jelajahi Katalog"
3. Search for UMKM by name
4. Filter by category
5. Filter by district
6. Sort by newest
7. Verify results update correctly
```

**Scenario 2: UMKM Detail View**
```
1. Click on UMKM from catalog
2. Verify all information displays
3. Check breadcrumb navigation
4. Click WhatsApp button (opens chat)
5. View location on map
6. Click "Buka di Google Maps"
7. Share on social media
8. View related UMKM
```

**Scenario 3: Map View**
```
1. Switch to Map View
2. Verify markers load
3. Click on marker
4. Verify popup shows info
5. Click "Lihat Detail"
6. Filter by category
7. Verify markers update
```

---

### 3.4 SEO Tests

**Scenario 1: Sitemap Generation**
```
1. Access /sitemap.xml
2. Verify XML is valid
3. Verify all published UMKM included
4. Verify lastmod dates correct
5. Submit to Google Search Console
6. Monitor indexing status
```

**Scenario 2: Meta Tags**
```
1. View page source of UMKM detail
2. Verify <title> tag present
3. Verify meta description present
4. Verify Open Graph tags present
5. Verify Twitter Card tags present
6. Verify JSON-LD structured data present
```

---

## 4. Performance Testing (Task 22)

### 4.1 Page Load Time Tests

**Tools:**
- Chrome DevTools (Network tab)
- PageSpeed Insights
- GTmetrix

**Targets:**
- Homepage: < 2 seconds
- Catalog: < 2 seconds
- Detail Page: < 2 seconds
- Map: < 3 seconds

**Steps:**
1. Clear browser cache
2. Open DevTools Network tab
3. Load page
4. Record "Load" time
5. Record "DOMContentLoaded" time
6. Repeat 3 times, take average

---

### 4.2 Database Query Optimization

**Check for N+1 Queries:**
```bash
# Enable query logging
php artisan tinker
DB::enableQueryLog();

# Visit pages and check queries
DB::getQueryLog();
```

**Common Issues:**
- Loading UMKM without eager loading category/district
- Loading related UMKM without eager loading relationships

**Fixes:**
```php
// Bad
$umkms = UmkmProfile::all();
foreach ($umkms as $umkm) {
    echo $umkm->category->nama_kategori; // N+1 query
}

// Good
$umkms = UmkmProfile::with(['category', 'district'])->get();
foreach ($umkms as $umkm) {
    echo $umkm->category->nama_kategori; // Single query
}
```

---

### 4.3 Caching Tests

**Verify Caching:**
```bash
# Check sitemap caching
php artisan tinker
Cache::has('sitemap');

# Check dashboard stats caching
Cache::has('admin_dashboard_stats');
```

**Cache Invalidation:**
```php
// When UMKM is created/updated/deleted
Cache::forget('sitemap');
Cache::forget('admin_dashboard_stats');
Cache::forget('superadmin_dashboard_stats');
```

---

### 4.4 Load Testing with 1000+ Profiles

**Steps:**
1. Create test data:
```bash
php artisan tinker
UmkmProfile::factory()->count(1000)->create();
```

2. Test catalog page load time
3. Test map with 1000+ markers
4. Verify marker clustering works
5. Test search performance
6. Test filter performance

**Expected Results:**
- Catalog pagination works smoothly
- Map uses marker clustering
- Search returns results < 1 second
- Filters apply < 500ms

---

## 5. Security Testing (Task 23)

### 5.1 Authorization Tests

**Test Cases:**
```
✅ UMKM cannot access admin routes
✅ UMKM cannot edit other UMKM profiles
✅ Admin cannot access superadmin routes
✅ Admin cannot edit UMKM profiles directly
✅ SuperAdmin cannot edit/delete UMKM
✅ SuperAdmin cannot edit/delete categories
✅ Public cannot access dashboards
✅ Unauthenticated users redirected to login
```

**Manual Testing:**
1. Login as UMKM
2. Try to access `/admin/dashboard` (should fail)
3. Try to access `/superadmin/dashboard` (should fail)
4. Try to edit another UMKM's profile (should fail)

---

### 5.2 Privacy Tests

**Contact Information Protection:**
```
✅ Admin cannot see UMKM WhatsApp number
✅ Admin cannot see UMKM email
✅ SuperAdmin sees aggregate data only
✅ Public sees only published profiles
✅ Unpublished profiles not in catalog
✅ Unpublished profiles not in sitemap
```

**Manual Testing:**
1. Login as Admin
2. View UMKM content monitoring
3. Verify WhatsApp field shows "***"
4. Verify email field shows "***"
5. Login as SuperAdmin
6. Verify cannot see individual contact info

---

### 5.3 Input Validation Tests

**XSS Prevention:**
```php
// Test inputs
<script>alert('XSS')</script>
<img src=x onerror=alert('XSS')>
javascript:alert('XSS')
```

**Test Fields:**
- UMKM name
- Description
- Address
- Category name
- District name

**Expected:** All HTML/JS should be escaped or stripped

---

**SQL Injection Prevention:**
```sql
-- Test inputs
' OR '1'='1
'; DROP TABLE users; --
1' UNION SELECT * FROM users--
```

**Test Fields:**
- Search queries
- Filter parameters
- Sort parameters

**Expected:** Laravel's query builder prevents SQL injection

---

**File Upload Validation:**
```
✅ Only images allowed (jpg, jpeg, png, gif, webp)
✅ File size limit enforced (max 2MB)
✅ File type validation (MIME type check)
✅ Malicious files rejected
```

**Test Files:**
- Upload .php file (should fail)
- Upload .exe file (should fail)
- Upload 10MB image (should fail)
- Upload valid image (should succeed)

---

## 6. User Acceptance Testing (Task 24)

### 6.1 UMKM User Testing

**Participants:** 3-5 real UMKM owners

**Tasks:**
1. Register new account
2. Complete profile
3. Add location on map
4. Upload photos
5. Publish profile
6. View profile in catalog

**Questions:**
- Is the dashboard easy to understand?
- Is the completion indicator helpful?
- Are the missing fields clear?
- Is the map easy to use?
- Is there any confusing technical jargon?

**Success Criteria:**
- 80%+ can complete profile without help
- 90%+ understand completion indicator
- 80%+ can add location successfully
- No technical jargon confusion

---

### 6.2 Admin User Testing

**Participants:** 2-3 admin users

**Tasks:**
1. View content monitoring
2. Filter by quality metrics
3. Flag a profile
4. Manage categories
5. View dashboard statistics

**Questions:**
- Are the data quality tools useful?
- Is the flagging system clear?
- Are the dashboard charts helpful?
- Can you easily find low-quality profiles?

**Success Criteria:**
- 90%+ find quality tools useful
- 100% can flag profiles correctly
- 80%+ understand dashboard metrics

---

### 6.3 Public User Testing

**Participants:** 5-10 potential customers

**Tasks:**
1. Search for specific UMKM
2. Filter by category
3. View UMKM detail
4. Contact via WhatsApp
5. View location on map
6. Share on social media

**Questions:**
- Is it easy to find UMKM?
- Is the search/filter intuitive?
- Is the UMKM information complete?
- Is the mobile experience good?

**Success Criteria:**
- 90%+ can find UMKM easily
- 80%+ find information complete
- 90%+ mobile experience is good

---

## 7. Documentation (Task 25)

### 7.1 User Guide for UMKM

**File:** `docs/PANDUAN_UMKM.md` (already exists)

**Verify Content:**
- ✅ How to register
- ✅ How to complete profile
- ✅ How to add location
- ✅ How to upload photos
- ✅ How to publish profile
- ✅ No technical jargon
- ✅ Screenshots included

---

### 7.2 Admin Guide

**File:** `docs/PANDUAN_ADMIN.md` (already exists)

**Verify Content:**
- ✅ How to monitor content
- ✅ How to manage categories
- ✅ How to manage districts
- ✅ How to flag profiles
- ✅ Privacy guidelines
- ✅ Screenshots included

---

### 7.3 Technical Documentation

**Create:** `docs/TECHNICAL_DOCUMENTATION.md`

**Content:**
- Architecture overview
- Database schema
- SEO implementation details
- API endpoints (if any)
- Service classes
- Deployment instructions

---

### 7.4 Update README

**File:** `README.md`

**Add:**
- New features list (v3.0)
- Updated screenshots
- Installation instructions
- Configuration guide
- Testing instructions
- Changelog

---

## Testing Checklist

### SEO Testing
- [ ] Google Rich Results Test (homepage)
- [ ] Google Rich Results Test (catalog)
- [ ] Google Rich Results Test (UMKM detail)
- [ ] PageSpeed Insights (all pages)
- [ ] Mobile-Friendly Test (all pages)
- [ ] Facebook Debugger (UMKM detail)
- [ ] Twitter Card Validator (UMKM detail)
- [ ] WhatsApp Preview (UMKM detail)
- [ ] Sitemap validation

### Unit Testing
- [ ] ProfileCompletionService tests
- [ ] SeoService tests
- [ ] Controller tests
- [ ] All tests passing

### Integration Testing
- [ ] UMKM registration flow
- [ ] Profile update flow
- [ ] Admin content monitoring
- [ ] Category management
- [ ] Public search & filter
- [ ] UMKM detail view
- [ ] Map view
- [ ] Sitemap generation

### Performance Testing
- [ ] Page load times < targets
- [ ] No N+1 queries
- [ ] Caching works correctly
- [ ] Load test with 1000+ profiles

### Security Testing
- [ ] Authorization tests pass
- [ ] Privacy protection verified
- [ ] XSS prevention verified
- [ ] SQL injection prevention verified
- [ ] File upload validation verified

### User Acceptance Testing
- [ ] UMKM user testing completed
- [ ] Admin user testing completed
- [ ] Public user testing completed
- [ ] Feedback collected and addressed

### Documentation
- [ ] UMKM guide verified
- [ ] Admin guide verified
- [ ] Technical documentation created
- [ ] README updated
- [ ] Changelog updated

---

## Next Steps After Testing

1. **Fix Critical Issues:** Address any critical bugs or security issues immediately
2. **Optimize Performance:** Implement caching, optimize queries, compress images
3. **Update Documentation:** Ensure all guides are accurate and complete
4. **Prepare for Deployment:** Follow Phase 8 deployment checklist
5. **Monitor Post-Deployment:** Track errors, performance, and user feedback

---

**Document Version:** 1.0  
**Created:** 2026-02-08  
**Status:** Ready for Testing
