# Requirements Document: NovaDex UMKM Catalog Platform

## Introduction

NovaDex (Arsitektur Salatiga) is a digital catalog platform designed to serve as the digital foundation for Micro, Small, and Medium Enterprises (MSMEs/UMKM) in Salatiga City. The platform functions as a public directory and discovery tool, NOT as a marketplace, financial application, or subsidy system. It enables public discovery of local businesses, provides MSMEs with simple digital identities, and helps government administrators map and understand the local business ecosystem through aggregate data visualization.

The platform serves four distinct user roles: public guests (no authentication required), UMKM owners (authenticated business owners), Government Program Admins (authenticated government officials), and Super Admins (authenticated system administrators). The core philosophy emphasizes gradual digital transformation, elegant simplicity, and catalog-focused functionality rather than transactional or bureaucratic complexity.

## Glossary

- **NovaDex**: The NovaDex Platform - the complete web application system
- **UMKM**: Micro, Small, and Medium Enterprise (Indonesian: Usaha Mikro, Kecil, dan Menengah)
- **Public_User**: An unauthenticated visitor browsing the public catalog
- **UMKM_Owner**: An authenticated user who owns and manages a UMKM business profile
- **Admin**: A Government Program Administrator with access to aggregate data and reports
- **Super_Admin**: A system administrator with full platform access
- **Business_Profile**: The complete set of information about a UMKM business
- **Catalog**: The public-facing directory of UMKM businesses
- **District**: A geographic subdivision of Salatiga City (Indonesian: Kecamatan)
- **Category**: A business classification type (e.g., Food & Beverage, Fashion, Services)
- **Publication_Status**: Whether a Business_Profile is visible to Public_Users (published/unpublished)

## Requirements

### Requirement 1: Public Landing Page

**User Story:** As a Public_User, I want to view an informative landing page, so that I can understand NovaDex's purpose and navigate to key features.

#### Acceptance Criteria

1. WHEN a Public_User visits the root URL, THE NovaDex SHALL display a hero section with the headline "NovaDex – Fondasi Digital UMKM Salatiga"
2. THE NovaDex SHALL display a subheadline explaining Salatiga's digital ambition for MSMEs
3. THE NovaDex SHALL provide call-to-action buttons for "Search UMKM" and "View Map"
4. THE NovaDex SHALL display sections showing featured business categories, newest MSMEs, and information about NovaDex
5. THE NovaDex SHALL render the landing page with a clean design using white/neutral backgrounds, green/blue accents, and modern typography

### Requirement 2: Public UMKM Catalog Browsing

**User Story:** As a Public_User, I want to browse and search UMKM businesses, so that I can discover local businesses in Salatiga.

#### Acceptance Criteria

1. WHEN a Public_User accesses the catalog page, THE NovaDex SHALL display UMKM businesses in a grid layout with cards
2. THE NovaDex SHALL display on each card the business logo/photo, business name, category, and district
3. WHEN a Public_User applies a category filter, THE NovaDex SHALL display only businesses matching that category
4. WHEN a Public_User applies a district filter, THE NovaDex SHALL display only businesses in that district
5. WHEN a Public_User enters a search term, THE NovaDex SHALL display businesses whose names contain that search term
6. THE NovaDex SHALL display only businesses with Publication_Status set to published

### Requirement 3: Public UMKM Detail Page

**User Story:** As a Public_User, I want to view detailed information about a specific UMKM, so that I can learn about the business and contact them.

#### Acceptance Criteria

1. WHEN a Public_User clicks on a UMKM card, THE NovaDex SHALL navigate to that business's detail page using its slug
2. THE NovaDex SHALL display the business name, category, and district in the page header
3. THE NovaDex SHALL display the business description and photo gallery with a maximum of 3 photos
4. THE NovaDex SHALL provide a primary call-to-action button to "Chat via WhatsApp" that opens WhatsApp with the business's number
5. THE NovaDex SHALL NOT display email addresses, internal data, or sensitive business information on the detail page

### Requirement 4: Public UMKM Map Visualization

**User Story:** As a Public_User, I want to view UMKM locations on a map, so that I can understand the geographic distribution of businesses in Salatiga.

#### Acceptance Criteria

1. WHEN a Public_User accesses the map page, THE NovaDex SHALL display an interactive map using Leaflet.js and OpenStreetMap
2. THE NovaDex SHALL display markers representing UMKM concentrations per district
3. WHEN a Public_User clicks on a district marker, THE NovaDex SHALL display the count of businesses in that district
4. THE NovaDex SHALL NOT display detailed business addresses or precise location coordinates on the public map

### Requirement 5: UMKM Owner Authentication

**User Story:** As a UMKM_Owner, I want to register and authenticate, so that I can manage my business profile.

#### Acceptance Criteria

1. WHEN a new user completes the registration form with valid credentials, THE NovaDex SHALL create a new UMKM_Owner account
2. WHEN a UMKM_Owner provides valid login credentials, THE NovaDex SHALL authenticate the user and grant access to the dashboard
3. WHEN a UMKM_Owner requests a password reset with a valid email, THE NovaDex SHALL send a password reset link
4. THE NovaDex SHALL enforce password security requirements during registration and password reset

### Requirement 6: UMKM Owner Dashboard

**User Story:** As a UMKM_Owner, I want to view my dashboard, so that I can see my profile status and access management features.

#### Acceptance Criteria

1. WHEN an authenticated UMKM_Owner accesses the dashboard, THE NovaDex SHALL display the profile completion status as Complete or Incomplete
2. THE NovaDex SHALL provide a preview of how the public profile appears to Public_Users
3. THE NovaDex SHALL provide a button to edit the business profile
4. THE NovaDex SHALL provide a toggle control to publish or unpublish the business profile
5. WHEN a UMKM_Owner toggles the publication status, THE NovaDex SHALL update the Publication_Status immediately

### Requirement 7: UMKM Business Profile Management

**User Story:** As a UMKM_Owner, I want to create and edit my business profile, so that I can present my business to the public.

#### Acceptance Criteria

1. WHEN a UMKM_Owner accesses the profile form, THE NovaDex SHALL display fields for business name, category, district, short description, WhatsApp number, and photo uploads
2. WHEN a UMKM_Owner submits a valid profile form, THE NovaDex SHALL save the Business_Profile data
3. THE NovaDex SHALL allow uploading a business logo and up to 3 additional photos
4. THE NovaDex SHALL generate a unique slug from the business name for URL routing
5. THE NovaDex SHALL NOT collect or display financial data, transaction records, or legal documents in the profile form

### Requirement 8: Admin City Dashboard

**User Story:** As an Admin, I want to view aggregate UMKM statistics, so that I can understand the business landscape in Salatiga.

#### Acceptance Criteria

1. WHEN an authenticated Admin accesses the city dashboard, THE NovaDex SHALL display the total count of registered MSMEs
2. THE NovaDex SHALL display a breakdown of MSMEs per district
3. THE NovaDex SHALL display a breakdown of MSMEs per category
4. THE NovaDex SHALL display statistics on the digital readiness status of MSMEs
5. THE NovaDex SHALL update dashboard statistics to reflect current data

### Requirement 9: Admin Internal UMKM Map

**User Story:** As an Admin, I want to view UMKM locations with filtering capabilities, so that I can analyze geographic distribution patterns.

#### Acceptance Criteria

1. WHEN an authenticated Admin accesses the internal map, THE NovaDex SHALL display an interactive map with UMKM locations
2. WHEN an Admin applies a district filter, THE NovaDex SHALL display only businesses in the selected district
3. WHEN an Admin applies a category filter, THE NovaDex SHALL display only businesses in the selected category
4. THE NovaDex SHALL display aggregate data for filtered results
5. THE NovaDex SHALL NOT allow Admins to edit UMKM_Owner data through the map interface

### Requirement 10: Admin Aggregate Reports

**User Story:** As an Admin, I want to generate and export reports, so that I can analyze UMKM data and share insights with stakeholders.

#### Acceptance Criteria

1. WHEN an authenticated Admin accesses the reports section, THE NovaDex SHALL display charts and statistics about UMKM distribution
2. THE NovaDex SHALL provide an option to export reports in PDF format
3. THE NovaDex SHALL provide an option to export reports in Excel format
4. THE NovaDex SHALL include district-based and category-based breakdowns in exported reports
5. THE NovaDex SHALL generate reports based on current published UMKM data

### Requirement 11: Super Admin User Management

**User Story:** As a Super_Admin, I want to manage users and roles, so that I can control platform access and permissions.

#### Acceptance Criteria

1. WHEN a Super_Admin accesses the user management interface, THE NovaDex SHALL display a list of all registered users
2. THE NovaDex SHALL allow Super_Admin to create new user accounts with assigned roles
3. THE NovaDex SHALL allow Super_Admin to modify user roles
4. THE NovaDex SHALL allow Super_Admin to deactivate or delete user accounts
5. THE NovaDex SHALL enforce role-based access control based on assigned user roles

### Requirement 12: Super Admin Master Data Management

**User Story:** As a Super_Admin, I want to manage business categories and districts, so that I can maintain accurate reference data.

#### Acceptance Criteria

1. WHEN a Super_Admin accesses the category management interface, THE NovaDex SHALL display all business categories
2. THE NovaDex SHALL allow Super_Admin to create, update, and delete business categories
3. WHEN a Super_Admin accesses the district management interface, THE NovaDex SHALL display all districts with coordinates
4. THE NovaDex SHALL allow Super_Admin to create, update, and delete district records
5. THE NovaDex SHALL prevent deletion of categories or districts that are referenced by existing Business_Profiles

### Requirement 13: Super Admin Publication Control

**User Story:** As a Super_Admin, I want to control UMKM publication status, so that I can moderate content quality.

#### Acceptance Criteria

1. WHEN a Super_Admin views the UMKM list, THE NovaDex SHALL display the Publication_Status for each business
2. THE NovaDex SHALL allow Super_Admin to publish or unpublish any Business_Profile
3. WHEN a Super_Admin changes a Publication_Status, THE NovaDex SHALL immediately update the public catalog visibility
4. THE NovaDex SHALL log all publication status changes with timestamp and admin identifier

### Requirement 14: Data Security and Access Control

**User Story:** As a system architect, I want role-based access control and data protection, so that sensitive information remains secure.

#### Acceptance Criteria

1. THE NovaDex SHALL enforce authentication for all dashboard and administrative routes
2. THE NovaDex SHALL restrict UMKM_Owners to viewing and editing only their own Business_Profile
3. THE NovaDex SHALL restrict Admins to read-only access of UMKM data
4. THE NovaDex SHALL restrict Super_Admin functions to users with the Super_Admin role
5. THE NovaDex SHALL NOT expose sensitive business data through public APIs or pages

### Requirement 15: Change Logging and Audit Trail

**User Story:** As a Super_Admin, I want to track changes to critical data, so that I can maintain accountability and troubleshoot issues.

#### Acceptance Criteria

1. WHEN a UMKM_Owner modifies their Business_Profile, THE NovaDex SHALL log the change with timestamp and user identifier
2. WHEN a Super_Admin modifies master data, THE NovaDex SHALL log the change with timestamp and admin identifier
3. WHEN a publication status changes, THE NovaDex SHALL log the change with timestamp and modifier identifier
4. THE NovaDex SHALL store audit logs in a secure, append-only format
5. THE NovaDex SHALL provide Super_Admin access to view audit logs

### Requirement 16: Mobile-First Responsive Design

**User Story:** As a Public_User accessing NovaDex on a mobile device, I want a responsive interface, so that I can browse comfortably on any screen size.

#### Acceptance Criteria

1. WHEN a user accesses NovaDex on a mobile device, THE NovaDex SHALL display a mobile-optimized layout
2. THE NovaDex SHALL ensure all interactive elements are touch-friendly with appropriate sizing
3. THE NovaDex SHALL maintain readability and usability across screen sizes from 320px to 1920px width
4. THE NovaDex SHALL load and render pages efficiently on mobile network connections
5. THE NovaDex SHALL use responsive images that adapt to device capabilities

### Requirement 17: WhatsApp Integration

**User Story:** As a Public_User, I want to contact a UMKM via WhatsApp, so that I can communicate with businesses easily.

#### Acceptance Criteria

1. WHEN a Public_User clicks the WhatsApp call-to-action on a UMKM detail page, THE NovaDex SHALL open WhatsApp with the business's phone number pre-filled
2. THE NovaDex SHALL format the WhatsApp URL correctly for both web and mobile platforms
3. THE NovaDex SHALL validate WhatsApp numbers during Business_Profile creation to ensure proper formatting
4. THE NovaDex SHALL include a default message template when opening WhatsApp (optional)

### Requirement 18: Business Profile Slug Generation

**User Story:** As a developer, I want automatic slug generation from business names, so that UMKM detail pages have clean, SEO-friendly URLs.

#### Acceptance Criteria

1. WHEN a UMKM_Owner creates a Business_Profile, THE NovaDex SHALL generate a URL slug from the business name
2. THE NovaDex SHALL ensure generated slugs contain only lowercase letters, numbers, and hyphens
3. WHEN a slug collision occurs, THE NovaDex SHALL append a numeric suffix to ensure uniqueness
4. THE NovaDex SHALL preserve existing slugs when business names are updated
5. THE NovaDex SHALL allow Super_Admin to manually override slugs if necessary

### Requirement 19: Image Upload and Storage

**User Story:** As a UMKM_Owner, I want to upload business photos, so that I can visually represent my business to potential customers.

#### Acceptance Criteria

1. WHEN a UMKM_Owner uploads a logo image, THE NovaDex SHALL validate the file type as an accepted image format
2. THE NovaDex SHALL limit logo file size to a maximum of 2MB
3. THE NovaDex SHALL allow uploading up to 3 additional gallery photos with a maximum of 2MB each
4. THE NovaDex SHALL store uploaded images securely and serve them efficiently
5. THE NovaDex SHALL generate optimized versions of uploaded images for different display contexts

### Requirement 20: Search Functionality

**User Story:** As a Public_User, I want to search for businesses by name, so that I can quickly find specific UMKMs.

#### Acceptance Criteria

1. WHEN a Public_User enters a search query, THE NovaDex SHALL perform a case-insensitive search on business names
2. THE NovaDex SHALL display search results in real-time as the user types (debounced)
3. THE NovaDex SHALL highlight matching text in search results
4. WHEN no results match the search query, THE NovaDex SHALL display a helpful message suggesting alternative actions
5. THE NovaDex SHALL combine search with active filters to refine results
