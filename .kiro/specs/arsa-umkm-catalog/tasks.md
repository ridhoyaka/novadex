# Implementation Plan: ARSA UMKM Catalog Platform

## Overview

This implementation plan breaks down the ARSA platform into incremental, testable steps. The approach follows Laravel 11 best practices with a focus on building core functionality first, then layering on features progressively. Each major section includes property-based tests to validate correctness properties from the design document.

The implementation follows this sequence:
1. Project setup and database foundation
2. Authentication and user management
3. UMKM profile management (core feature)
4. Public catalog and discovery features
5. Admin dashboard and reporting
6. Super admin functionality
7. Final integration and polish

## Tasks

- [x] 1. Initialize Laravel 11 project and configure environment
  - Install Laravel 11 with PHP 8.2+
  - Configure database connection (MySQL)
  - Set up Tailwind CSS and Alpine.js
  - Install Pest PHP and Pest Property Testing plugin
  - Configure file storage (local for development)
  - Set up basic .env configuration
  - _Requirements: Foundation for all features_

- [ ] 2. Create database migrations and seeders
  - [x] 2.1 Create users table migration with role enum
    - Add fields: id, name, email, password, role (enum: umkm, admin, super_admin)
    - Add indexes on email and role
    - _Requirements: 5.1, 11.1_
  
  - [x] 2.2 Create categories table migration
    - Add fields: id, nama_kategori, slug, icon
    - Add unique index on slug
    - _Requirements: 12.1_
  
  - [x] 2.3 Create districts table migration
    - Add fields: id, nama_kecamatan, latitude, longitude
    - _Requirements: 12.3_
  
  - [x] 2.4 Create umkm_profiles table migration
    - Add fields: id, user_id, nama_usaha, slug, kategori_id, kecamatan_id, deskripsi, whatsapp, logo_path, photos (JSON), is_published
    - Add foreign keys with appropriate constraints
    - Add indexes on slug, is_published, kategori_id, kecamatan_id
    - Add fulltext index on nama_usaha
    - _Requirements: 2.1, 7.1_
  
  - [x] 2.5 Create activity_logs table migration
    - Add fields: id, user_id, action, model_type, model_id, changes (JSON), ip_address, created_at
    - Add indexes on model, user_id, created_at
    - _Requirements: 15.1_
  
  - [x] 2.6 Create seeders for categories and districts
    - Seed common UMKM categories (Food & Beverage, Fashion, Services, etc.)
    - Seed Salatiga districts with coordinates
    - _Requirements: 12.1, 12.3_

- [ ] 3. Create Eloquent models with relationships
  - [x] 3.1 Create User model with role enum
    - Define fillable fields and casts
    - Add umkmProfile() relationship (hasOne)
    - Add helper methods: isUmkm(), isAdmin(), isSuperAdmin()
    - _Requirements: 5.1, 11.5_
  
  - [x] 3.2 Create UmkmProfile model
    - Define fillable fields and casts (is_published as boolean, photos as array)
    - Add relationships: user(), category(), district()
    - Add scopes: published(), byCategory(), byDistrict(), search()
    - Add accessors: getPublicUrlAttribute(), getWhatsappLinkAttribute(), getProfileCompletionAttribute()
    - _Requirements: 2.1, 2.3, 2.4, 2.5, 2.6, 3.4, 6.1_
  
  - [x] 3.3 Create Category and District models
    - Define fillable fields
    - Add umkmProfiles() relationship (hasMany)
    - Add canBeDeleted() helper method
    - _Requirements: 12.2, 12.4, 12.5_
  
  - [x] 3.4 Create ActivityLog model
    - Define fillable fields and casts
    - Add user() and subject() relationships
    - _Requirements: 15.1_

- [ ] 4. Implement authentication system
  - [x] 4.1 Install and configure Laravel Breeze
    - Install Breeze with Blade stack
    - Customize registration to include role selection
    - _Requirements: 5.1_
  
  - [x] 4.2 Create RoleMiddleware for role-based access control
    - Implement middleware to check user role
    - Register middleware in bootstrap/app.php
    - _Requirements: 11.5, 14.1_
  
  - [x] 4.3 Customize authentication views
    - Update login, register, and password reset views with ARSA branding
    - Apply Tailwind CSS styling
    - _Requirements: 5.1, 5.2, 5.3_
  
  - [ ]* 4.4 Write property test for user registration and authentication
    - **Property 11: User Registration and Authentication**
    - **Validates: Requirements 5.1, 5.2**
  
  - [ ]* 4.5 Write property test for password security validation
    - **Property 12: Password Security Validation**
    - **Validates: Requirements 5.4**

- [ ] 5. Create service classes for business logic
  - [x] 5.1 Create SlugService for slug generation
    - Implement generateUniqueSlug() method
    - Implement slugify() method with proper character handling
    - Implement ensureUnique() for collision resolution
    - _Requirements: 7.4, 18.1, 18.2, 18.3_
  
  - [ ]* 5.2 Write property tests for slug generation
    - **Property 18: Slug Generation and Uniqueness**
    - **Property 19: Slug Stability**
    - **Validates: Requirements 7.4, 18.1, 18.2, 18.3, 18.4**
  
  - [x] 5.3 Create UmkmService for UMKM operations
    - Implement createProfile() method
    - Implement updateProfile() method
    - Implement togglePublishStatus() method
    - Implement uploadLogo() and uploadGalleryPhoto() methods
    - Implement deleteGalleryPhoto() method
    - Implement getPublicCatalog() with filtering and search
    - Implement calculateProfileCompletion() method
    - _Requirements: 2.1, 2.3, 2.4, 2.5, 6.1, 6.5, 7.2, 7.3_
  
  - [ ] 5.4 Create ReportService for admin reports
    - Implement getCityStatistics() method
    - Implement getUmkmByDistrict() method
    - Implement getUmkmByCategory() method
    - Implement getDigitalReadinessStats() method
    - Implement getMapData() method with filters
    - _Requirements: 8.1, 8.2, 8.3, 8.4, 9.2, 9.3_

- [ ] 6. Implement UMKM profile management
  - [x] 6.1 Create UmkmProfilePolicy for authorization
    - Implement view(), update(), delete(), publish() methods
    - Ensure UMKM owners can only access their own profile
    - Ensure admins have read-only access
    - Ensure super admins have full access
    - _Requirements: 14.2, 14.3, 14.4_
  
  - [ ]* 6.2 Write property tests for authorization
    - **Property 24: Role-Based Access Control**
    - **Property 25: UMKM Owner Data Isolation**
    - **Property 26: Admin Read-Only Access**
    - **Validates: Requirements 11.5, 14.1, 14.2, 14.3, 14.4**
  
  - [-] 6.3 Create UmkmProfileRequest for form validation
    - Define validation rules for all profile fields
    - Add custom validation for WhatsApp number format
    - Add file validation for logo and photos (type, size, count)
    - _Requirements: 7.1, 17.3, 19.1, 19.2, 19.3_
  
  - [ ]* 6.4 Write property tests for file validation
    - **Property 31: File Type Validation**
    - **Property 32: File Size Validation**
    - **Property 17: Photo Upload Limits**
    - **Validates: Requirements 7.3, 19.1, 19.2, 19.3**
  
  - [x] 6.5 Create UMKM dashboard controller and view
    - Implement DashboardController@index to show profile status
    - Display profile completion percentage
    - Show public profile preview
    - Add edit profile button and publish toggle
    - _Requirements: 6.1, 6.2, 6.3, 6.4_
  
  - [ ]* 6.6 Write property tests for dashboard features
    - **Property 13: Profile Completion Status**
    - **Property 14: Public Profile Preview Consistency**
    - **Validates: Requirements 6.1, 6.2**
  
  - [x] 6.7 Create profile form controller and view
    - Implement ProfileController@edit to show form
    - Implement ProfileController@update to save profile
    - Implement ProfileController@togglePublish for publication toggle
    - Implement file upload endpoints for logo and photos
    - Apply UmkmProfilePolicy authorization
    - _Requirements: 7.1, 7.2, 7.3, 6.5_
  
  - [ ]* 6.8 Write property tests for profile management
    - **Property 15: Publication Toggle Effect**
    - **Property 16: Profile Data Persistence**
    - **Property 20: Prohibited Data Collection**
    - **Validates: Requirements 6.5, 7.2, 7.5**
  
  - [ ] 6.9 Implement image upload and optimization
    - Handle file uploads with validation
    - Store files using Laravel Storage
    - Generate optimized versions (thumbnail, medium, large)
    - Update profile with file paths
    - _Requirements: 19.4, 19.5_
  
  - [ ]* 6.10 Write property test for image optimization
    - **Property 33: Image Optimization**
    - **Validates: Requirements 19.5**
  
  - [ ] 6.11 Implement activity logging for profile changes
    - Create observer or event listener for UmkmProfile model
    - Log all create, update, and publication status changes
    - Store user_id, action, changes, and timestamp
    - _Requirements: 15.1, 15.3_
  
  - [ ]* 6.12 Write property test for audit logging
    - **Property 30: Audit Logging Completeness**
    - **Validates: Requirements 13.4, 15.1, 15.2, 15.3**

- [ ] 7. Checkpoint - Ensure UMKM profile management works
  - Run all tests to verify profile creation, editing, and authorization
  - Manually test file uploads and image optimization
  - Verify audit logs are being created
  - Ask the user if questions arise

- [ ] 8. Implement public catalog and discovery features
  - [x] 8.1 Create HomeController and landing page view
    - Display hero section with headline and subheadline
    - Add CTA buttons for "Search UMKM" and "View Map"
    - Show featured categories section
    - Show newest MSMEs section (latest 6 published profiles)
    - Apply clean, modern design with Tailwind CSS
    - _Requirements: 1.1, 1.2, 1.3, 1.4_
  
  - [ ]* 8.2 Write unit tests for landing page content
    - Test that hero section contains required text
    - Test that CTA buttons are present
    - Test that featured sections display
    - _Requirements: 1.1, 1.2, 1.3, 1.4_
  
  - [x] 8.3 Create UmkmCatalogController and catalog view
    - Implement index() method with filtering and search
    - Display UMKM cards in grid layout
    - Add filter dropdowns for category and district
    - Add search input with debounced AJAX
    - Implement pagination
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5_
  
  - [ ]* 8.4 Write property tests for catalog filtering and search
    - **Property 1: Catalog Filtering Correctness**
    - **Property 2: Search Query Matching**
    - **Property 3: Publication Status Visibility**
    - **Property 4: UMKM Card Content Completeness**
    - **Validates: Requirements 2.2, 2.3, 2.4, 2.5, 2.6, 20.1, 20.5**
  
  - [x] 8.4 Create UmkmDetailController and detail page view
    - Implement show() method to load profile by slug
    - Display business name, category, district in header
    - Display description and photo gallery (max 3 photos)
    - Add WhatsApp CTA button with proper link
    - Ensure no sensitive data is displayed
    - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5_
  
  - [ ]* 8.5 Write property tests for detail page
    - **Property 5: Detail Page Routing**
    - **Property 6: Detail Page Content Completeness**
    - **Property 7: WhatsApp Link Generation**
    - **Property 8: Sensitive Data Exclusion**
    - **Validates: Requirements 3.1, 3.2, 3.3, 3.4, 3.5, 14.5, 17.1, 17.2**
  
  - [ ] 8.6 Implement search result highlighting
    - Add helper function to highlight matching text
    - Apply highlighting in catalog view
    - _Requirements: 20.3_
  
  - [ ]* 8.7 Write property test for search highlighting
    - **Property 34: Search Result Highlighting**
    - **Validates: Requirements 20.3**
  
  - [ ] 8.8 Create UmkmMapController and public map view
    - Implement index() method to provide map data
    - Integrate Leaflet.js and OpenStreetMap
    - Display district-level markers with UMKM counts
    - Implement marker click to show count popup
    - Ensure no precise coordinates are exposed
    - _Requirements: 4.1, 4.2, 4.3, 4.4_
  
  - [ ]* 8.9 Write property tests for map features
    - **Property 9: Map District Aggregation**
    - **Property 10: Geographic Privacy**
    - **Validates: Requirements 4.2, 4.3, 4.4**

- [ ] 9. Checkpoint - Ensure public features work correctly
  - Run all tests to verify catalog, search, filtering, and map
  - Manually test responsive design on mobile devices
  - Verify WhatsApp links work on mobile
  - Ask the user if questions arise

- [ ] 10. Implement admin dashboard and reporting
  - [ ] 10.1 Create Admin\DashboardController and view
    - Implement index() method using ReportService
    - Display total MSMEs count
    - Display MSMEs per district chart
    - Display MSMEs per category chart
    - Display digital readiness statistics
    - Apply role middleware (admin, super_admin)
    - _Requirements: 8.1, 8.2, 8.3, 8.4_
  
  - [ ]* 10.2 Write property tests for dashboard statistics
    - **Property 21: Dashboard Statistics Accuracy**
    - **Property 22: Statistics Data Freshness**
    - **Validates: Requirements 8.1, 8.2, 8.3, 8.5**
  
  - [ ] 10.3 Create Admin\MapController and internal map view
    - Implement index() method with filter support
    - Display interactive map with all UMKM locations
    - Add filter dropdowns for district and category
    - Display aggregate data for filtered results
    - Ensure read-only access (no edit buttons)
    - _Requirements: 9.1, 9.2, 9.3, 9.4, 9.5_
  
  - [ ]* 10.4 Write property tests for admin map filtering
    - Test filtering properties (already covered by Property 1)
    - **Property 26: Admin Read-Only Access**
    - **Validates: Requirements 9.2, 9.3, 9.5, 14.3**
  
  - [ ] 10.5 Create Admin\ReportController and reports view
    - Implement index() method to display reports interface
    - Implement exportPdf() method using Laravel PDF library
    - Implement exportExcel() method using Laravel Excel
    - Include district and category breakdowns in exports
    - Filter to only published UMKM data
    - _Requirements: 10.1, 10.2, 10.3, 10.4, 10.5_
  
  - [ ]* 10.6 Write property tests for report generation
    - **Property 23: Report Content Completeness**
    - **Validates: Requirements 10.4, 10.5**

- [ ] 11. Implement super admin functionality
  - [ ] 11.1 Create SuperAdmin\UserController and views
    - Implement index() to list all users
    - Implement create() and store() for user creation
    - Implement edit() and update() for user modification
    - Implement destroy() for user deletion
    - Add role selection dropdown
    - Apply role middleware (super_admin only)
    - _Requirements: 11.1, 11.2, 11.3, 11.4_
  
  - [ ]* 11.2 Write property tests for user management
    - **Property 27: Super Admin User Management**
    - **Validates: Requirements 11.2, 11.3, 11.4**
  
  - [ ] 11.3 Create SuperAdmin\CategoryController and views
    - Implement standard resource controller (index, create, store, edit, update, destroy)
    - Add validation to prevent deletion of categories with UMKMs
    - Apply role middleware (super_admin only)
    - _Requirements: 12.1, 12.2_
  
  - [ ] 11.4 Create SuperAdmin\DistrictController and views
    - Implement standard resource controller
    - Add validation to prevent deletion of districts with UMKMs
    - Include latitude/longitude fields in form
    - Apply role middleware (super_admin only)
    - _Requirements: 12.3, 12.4_
  
  - [ ]* 11.5 Write property tests for master data management
    - **Property 28: Master Data CRUD Operations**
    - **Validates: Requirements 12.2, 12.4, 12.5**
  
  - [ ] 11.6 Add publication control to super admin UMKM list
    - Create SuperAdmin\UmkmController@index to list all UMKMs
    - Display publication status for each UMKM
    - Add toggle buttons to publish/unpublish
    - Implement togglePublish() method
    - Log all publication status changes
    - _Requirements: 13.1, 13.2, 13.3, 13.4_
  
  - [ ]* 11.7 Write property tests for publication control
    - **Property 29: Super Admin Publication Control**
    - Test audit logging (already covered by Property 30)
    - **Validates: Requirements 13.2, 13.3**
  
  - [ ] 11.8 Create activity log viewer for super admin
    - Create SuperAdmin\ActivityLogController@index
    - Display paginated list of all activity logs
    - Add filters for user, action, model type, date range
    - Display changes in readable format
    - _Requirements: 15.5_

- [ ] 12. Checkpoint - Ensure admin features work correctly
  - Run all tests to verify admin dashboard, reports, and super admin functions
  - Manually test PDF and Excel exports
  - Verify role-based access control is working
  - Ask the user if questions arise

- [ ] 13. Implement routing and navigation
  - [ ] 13.1 Define all routes in routes/web.php
    - Public routes: /, /umkm, /umkm/{slug}, /peta-umkm
    - Auth routes: /dashboard, /profil-umkm/*
    - Admin routes: /admin/dashboard, /admin/peta, /admin/laporan
    - Super admin routes: /super-admin/users, /super-admin/categories, /super-admin/districts, /super-admin/umkm
    - Apply appropriate middleware to each route group
    - _Requirements: All routing requirements_
  
  - [ ] 13.2 Create navigation components
    - Create public navigation header (logo, links to catalog and map)
    - Create authenticated navigation (dashboard link, profile dropdown, logout)
    - Create admin navigation (dashboard, map, reports)
    - Create super admin navigation (users, categories, districts, UMKMs, logs)
    - Make navigation responsive for mobile
    - _Requirements: User experience across all roles_
  
  - [ ] 13.3 Create layout templates
    - Create public layout (public.blade.php)
    - Create authenticated layout (app.blade.php)
    - Create admin layout (admin.blade.php)
    - Include navigation, footer, and flash message display
    - _Requirements: Consistent UI across platform_

- [ ] 14. Implement error handling and validation
  - [ ] 14.1 Create custom error pages
    - Create 404 error page with helpful navigation
    - Create 403 error page with role-specific messaging
    - Create 500 error page with error reference ID
    - Style error pages consistently with ARSA branding
    - _Requirements: Error handling strategy_
  
  - [ ] 14.2 Implement global exception handling
    - Configure exception handler to log errors
    - Add user-friendly error messages in Indonesian
    - Implement error notification for critical errors
    - _Requirements: System error handling_
  
  - [ ] 14.3 Add client-side validation
    - Add Alpine.js validation for forms
    - Implement real-time validation feedback
    - Ensure server-side validation is still primary
    - _Requirements: Validation strategy_

- [ ] 15. Polish UI and implement responsive design
  - [ ] 15.1 Apply Tailwind CSS styling to all pages
    - Implement clean, modern design with white/neutral backgrounds
    - Use green/blue accent colors consistently
    - Apply Inter or Poppins font family
    - Ensure consistent spacing and typography
    - _Requirements: 1.5, UI/UX principles_
  
  - [ ] 15.2 Implement mobile-responsive layouts
    - Test all pages on mobile viewport (320px - 768px)
    - Ensure touch-friendly button sizes
    - Optimize images for mobile
    - Test navigation on mobile
    - _Requirements: 16.1, 16.2, 16.3, 16.5_
  
  - [ ] 15.3 Add loading states and transitions
    - Add loading spinners for AJAX requests
    - Add smooth transitions for filter changes
    - Add skeleton loaders for catalog cards
    - _Requirements: User experience_
  
  - [ ] 15.4 Implement toast notifications
    - Add toast component for success/error messages
    - Use Alpine.js for toast animations
    - Display toasts for form submissions, toggles, etc.
    - _Requirements: User feedback_

- [ ] 16. Final integration and testing
  - [ ] 16.1 Run full test suite
    - Execute all unit tests
    - Execute all property tests (minimum 100 iterations each)
    - Execute all feature tests
    - Verify 80%+ code coverage
    - _Requirements: Testing strategy_
  
  - [ ] 16.2 Perform end-to-end testing
    - Test complete user flows for each role
    - Test public catalog browsing and search
    - Test UMKM profile creation and management
    - Test admin dashboard and reports
    - Test super admin user and master data management
    - _Requirements: All requirements_
  
  - [ ] 16.3 Security audit
    - Verify role-based access control on all routes
    - Test for SQL injection vulnerabilities
    - Test for XSS vulnerabilities
    - Verify CSRF protection is enabled
    - Test file upload security
    - _Requirements: 14.1, 14.2, 14.3, 14.4, 14.5_
  
  - [ ] 16.4 Performance optimization
    - Add database indexes where needed
    - Implement eager loading for relationships
    - Optimize images and assets
    - Enable caching for static data (categories, districts)
    - Test page load times
    - _Requirements: Performance considerations_
  
  - [ ] 16.5 Create deployment documentation
    - Document environment variables
    - Document database setup and migrations
    - Document seeder usage
    - Document file storage configuration
    - Document backup procedures
    - _Requirements: Deployment readiness_

- [ ] 17. Final checkpoint - Production readiness
  - Ensure all tests pass
  - Verify all requirements are implemented
  - Confirm responsive design works on all devices
  - Validate security measures are in place
  - Ask the user if questions arise before deployment

## Notes

- Tasks marked with `*` are optional property-based tests that can be skipped for faster MVP delivery
- Each task references specific requirements for traceability
- Checkpoints ensure incremental validation at major milestones
- Property tests validate universal correctness properties with 100+ iterations
- Unit tests validate specific examples, edge cases, and integration points
- The implementation follows Laravel 11 conventions and best practices
- All code should be written in PHP 8.2+ with type hints
- All views should use Blade templates with Tailwind CSS
- All JavaScript should use Alpine.js for interactivity
