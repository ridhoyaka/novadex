# Search Engine Submission Guide

## Overview

This guide provides step-by-step instructions for submitting the ARSA platform sitemap to major search engines and monitoring indexing status. These steps are essential for ensuring that UMKM profiles are discoverable through search engines like Google and Bing.

**Prerequisites:**
- Sitemap is already generated and accessible at: `https://yourdomain.com/sitemap.xml`
- You have admin access to the website domain
- You can verify domain ownership

---

## Table of Contents

1. [Google Search Console Submission](#google-search-console-submission)
2. [Bing Webmaster Tools Submission](#bing-webmaster-tools-submission)
3. [Monitoring Indexing Status](#monitoring-indexing-status)
4. [Best Practices](#best-practices)
5. [Troubleshooting](#troubleshooting)

---

## Google Search Console Submission

### Step 1: Access Google Search Console

1. Go to [Google Search Console](https://search.google.com/search-console)
2. Sign in with your Google account (use the organization's Google account)
3. If this is your first time, you'll see a welcome screen

### Step 2: Add Your Property

**Option A: Domain Property (Recommended)**
1. Click "Add Property" in the top-left corner
2. Select "Domain" property type
3. Enter your domain: `yourdomain.com` (without https://)
4. Click "Continue"

**Option B: URL Prefix Property**
1. Click "Add Property"
2. Select "URL prefix" property type
3. Enter your full URL: `https://yourdomain.com`
4. Click "Continue"

### Step 3: Verify Domain Ownership

Google will provide several verification methods. Choose the one that works best for you:

**Method 1: DNS Verification (Recommended for Domain Property)**
1. Google will provide a TXT record
2. Log in to your domain registrar (e.g., Namecheap, GoDaddy)
3. Go to DNS settings
4. Add a new TXT record with the value provided by Google
5. Wait 5-10 minutes for DNS propagation
6. Return to Google Search Console and click "Verify"

**Method 2: HTML File Upload**
1. Download the HTML verification file provided by Google
2. Upload it to your website's root directory: `public/google[code].html`
3. Verify the file is accessible: `https://yourdomain.com/google[code].html`
4. Return to Google Search Console and click "Verify"

**Method 3: HTML Tag**
1. Copy the meta tag provided by Google
2. Add it to your website's `<head>` section in the main layout file
3. Deploy the changes
4. Return to Google Search Console and click "Verify"

**Method 4: Google Analytics**
1. If you already have Google Analytics installed with the same Google account
2. Select this option and click "Verify"

### Step 4: Submit Your Sitemap

Once your property is verified:

1. In the left sidebar, click on "Sitemaps"
2. In the "Add a new sitemap" field, enter: `sitemap.xml`
3. Click "Submit"
4. You should see a success message: "Sitemap submitted successfully"

### Step 5: Verify Sitemap Status

1. Wait 24-48 hours for Google to process your sitemap
2. Return to the "Sitemaps" section
3. Check the status column:
   - ✅ **Success**: Sitemap processed successfully
   - ⚠️ **Warning**: Some issues but sitemap is processed
   - ❌ **Error**: Sitemap has errors and needs fixing

4. Click on the sitemap to see details:
   - Discovered URLs
   - Indexed URLs
   - Any errors or warnings

---

## Bing Webmaster Tools Submission

### Step 1: Access Bing Webmaster Tools

1. Go to [Bing Webmaster Tools](https://www.bing.com/webmasters)
2. Sign in with your Microsoft account
3. If you don't have one, create a free Microsoft account

### Step 2: Add Your Site

**Option A: Import from Google Search Console (Easiest)**
1. Click "Import from Google Search Console"
2. Sign in to your Google account
3. Select the property you want to import
4. Click "Import"
5. Bing will automatically import your sitemap and settings

**Option B: Manual Addition**
1. Click "Add a site"
2. Enter your website URL: `https://yourdomain.com`
3. Click "Add"

### Step 3: Verify Site Ownership

If you didn't import from Google, you'll need to verify ownership:

**Method 1: XML File (Recommended)**
1. Download the BingSiteAuth.xml file
2. Upload it to your website's root directory: `public/BingSiteAuth.xml`
3. Verify it's accessible: `https://yourdomain.com/BingSiteAuth.xml`
4. Return to Bing Webmaster Tools and click "Verify"

**Method 2: Meta Tag**
1. Copy the meta tag provided by Bing
2. Add it to your website's `<head>` section
3. Deploy the changes
4. Return to Bing Webmaster Tools and click "Verify"

**Method 3: CNAME Record**
1. Bing will provide a CNAME record
2. Add it to your DNS settings
3. Wait for DNS propagation (5-10 minutes)
4. Return to Bing Webmaster Tools and click "Verify"

### Step 4: Submit Your Sitemap

Once verified:

1. In the left sidebar, click on "Sitemaps"
2. Click "Submit sitemap"
3. Enter your sitemap URL: `https://yourdomain.com/sitemap.xml`
4. Click "Submit"

### Step 5: Verify Sitemap Status

1. Wait 24-48 hours for Bing to process your sitemap
2. Return to the "Sitemaps" section
3. Check the status:
   - Number of URLs submitted
   - Number of URLs indexed
   - Any errors or warnings

---

## Monitoring Indexing Status

### Google Search Console Monitoring

#### 1. Coverage Report

1. Go to Google Search Console
2. Click "Coverage" in the left sidebar
3. Review the report:
   - **Valid**: Pages successfully indexed
   - **Valid with warnings**: Indexed but with issues
   - **Error**: Pages not indexed due to errors
   - **Excluded**: Pages intentionally not indexed

4. Click on each category to see specific URLs and issues

#### 2. URL Inspection Tool

To check a specific UMKM profile:

1. Click "URL Inspection" at the top
2. Enter the full URL: `https://yourdomain.com/umkm/nama-usaha`
3. Press Enter
4. Review the results:
   - **URL is on Google**: Successfully indexed
   - **URL is not on Google**: Not indexed yet
   - **Coverage**: Indexing status
   - **Last crawl**: When Google last visited

5. If not indexed, click "Request Indexing" to prioritize it

#### 3. Performance Report

1. Click "Performance" in the left sidebar
2. View metrics:
   - **Total clicks**: How many times users clicked your links
   - **Total impressions**: How many times your pages appeared in search
   - **Average CTR**: Click-through rate
   - **Average position**: Your average ranking position

3. Filter by:
   - Date range
   - Search query
   - Page URL
   - Country
   - Device (mobile/desktop)

#### 4. Enhancements Report

1. Click "Enhancements" in the left sidebar
2. Check for:
   - **Structured data**: Verify LocalBusiness schema is detected
   - **Mobile usability**: Ensure pages are mobile-friendly
   - **Core Web Vitals**: Check page performance metrics

### Bing Webmaster Tools Monitoring

#### 1. Site Explorer

1. Go to Bing Webmaster Tools
2. Click "Site Explorer" in the left sidebar
3. View:
   - Total pages indexed
   - Crawl errors
   - Blocked URLs

#### 2. URL Inspection

1. Click "URL Inspection" at the top
2. Enter a UMKM profile URL
3. Review indexing status
4. Request indexing if needed

#### 3. Search Performance

1. Click "Search Performance" in the left sidebar
2. View:
   - Impressions
   - Clicks
   - Average position
   - CTR

#### 4. SEO Reports

1. Click "SEO Reports" in the left sidebar
2. Review:
   - SEO issues
   - Recommendations
   - Warnings

---

## Best Practices

### 1. Regular Monitoring

- **Weekly**: Check indexing status and coverage reports
- **Monthly**: Review performance metrics and search queries
- **Quarterly**: Analyze trends and adjust SEO strategy

### 2. Sitemap Updates

The ARSA sitemap is automatically generated and cached. To ensure search engines get the latest version:

- **Automatic**: The sitemap updates daily with new/modified UMKM profiles
- **Manual**: If you need to force an update, clear the application cache:
  ```bash
  php artisan cache:clear
  ```

### 3. Request Indexing for New Profiles

When a new UMKM profile is published:

1. Copy the profile URL
2. Use Google's URL Inspection tool
3. Click "Request Indexing"
4. Repeat for Bing if needed

This helps new profiles appear in search results faster (usually within 24-48 hours instead of weeks).

### 4. Monitor for Errors

Common issues to watch for:

- **404 errors**: Broken links or deleted profiles
- **Server errors (5xx)**: Website downtime or server issues
- **Soft 404s**: Pages with little content
- **Duplicate content**: Multiple URLs for the same profile
- **Mobile usability issues**: Pages not mobile-friendly

### 5. Optimize for Search

- Ensure all UMKM profiles have:
  - Complete descriptions (minimum 50 characters)
  - At least one photo
  - Proper category and district selection
  - Location data (optional but recommended)

- Monitor which search queries bring users to your site
- Encourage UMKM owners to complete their profiles

### 6. Track Key Metrics

Set up a monitoring dashboard to track:

- **Total indexed pages**: Should match published UMKM count
- **Indexing rate**: Percentage of submitted URLs that are indexed
- **Average position**: Your ranking in search results
- **Click-through rate**: Percentage of impressions that result in clicks
- **Core Web Vitals**: Page speed and user experience metrics

---

## Troubleshooting

### Issue 1: Sitemap Not Found (404 Error)

**Symptoms:**
- Search console shows "Couldn't fetch" error
- Sitemap URL returns 404

**Solutions:**
1. Verify the sitemap route is registered in `routes/web.php`:
   ```php
   Route::get('/sitemap.xml', [SitemapController::class, 'index']);
   ```

2. Clear route cache:
   ```bash
   php artisan route:clear
   php artisan route:cache
   ```

3. Test the sitemap URL directly in your browser:
   ```
   https://yourdomain.com/sitemap.xml
   ```

4. Check server configuration (Apache/Nginx) for XML file handling

### Issue 2: Sitemap Has Errors

**Symptoms:**
- Search console shows "Sitemap has errors"
- Some URLs are not indexed

**Solutions:**
1. Validate your sitemap using [XML Sitemap Validator](https://www.xml-sitemaps.com/validate-xml-sitemap.html)

2. Common errors:
   - **Invalid XML**: Check for special characters in URLs
   - **Invalid date format**: Ensure dates are in ISO 8601 format
   - **Invalid priority**: Must be between 0.0 and 1.0
   - **Too many URLs**: Split into multiple sitemaps if > 50,000 URLs

3. Check the sitemap generation code in `SitemapController.php`

4. Verify all URLs in the sitemap are accessible (not 404)

### Issue 3: Pages Not Being Indexed

**Symptoms:**
- Sitemap submitted successfully
- But pages don't appear in search results

**Possible Causes & Solutions:**

**A. Robots.txt Blocking**
1. Check your `robots.txt` file:
   ```
   https://yourdomain.com/robots.txt
   ```
2. Ensure it's not blocking search engines:
   ```
   User-agent: *
   Allow: /
   Sitemap: https://yourdomain.com/sitemap.xml
   ```

**B. Noindex Meta Tag**
1. Check if pages have `<meta name="robots" content="noindex">`
2. Remove this tag from public UMKM profiles

**C. Low Quality Content**
1. Ensure UMKM profiles have substantial content
2. Minimum 50 characters in description
3. Unique content (not duplicated)

**D. New Website**
1. New websites take 2-4 weeks to start appearing in search
2. Be patient and continue monitoring

**E. Manual Action or Penalty**
1. Check Google Search Console for manual actions
2. Review and fix any policy violations

### Issue 4: Duplicate Content Issues

**Symptoms:**
- Search console shows duplicate title tags or descriptions
- Multiple URLs for the same content

**Solutions:**
1. Ensure each UMKM profile has a unique slug
2. Verify SEO titles and descriptions are unique
3. Check for URL parameters creating duplicates
4. Add canonical tags if needed:
   ```html
   <link rel="canonical" href="https://yourdomain.com/umkm/nama-usaha">
   ```

### Issue 5: Mobile Usability Issues

**Symptoms:**
- Search console reports mobile usability problems
- Pages not mobile-friendly

**Solutions:**
1. Test pages with [Google Mobile-Friendly Test](https://search.google.com/test/mobile-friendly)
2. Common issues:
   - Text too small to read
   - Clickable elements too close together
   - Content wider than screen
   - Viewport not set

3. Ensure responsive design is working correctly
4. Test on actual mobile devices

### Issue 6: Slow Indexing

**Symptoms:**
- Pages submitted weeks ago still not indexed
- Crawl rate is very low

**Solutions:**
1. Check crawl stats in Google Search Console
2. Improve page load speed (target < 2 seconds)
3. Fix any server errors (5xx)
4. Ensure website is always accessible
5. Build internal links between UMKM profiles
6. Request indexing for important pages manually
7. Consider submitting to Google News (if applicable)

### Issue 7: Structured Data Errors

**Symptoms:**
- Search console shows structured data errors
- Rich results not appearing

**Solutions:**
1. Test structured data with [Rich Results Test](https://search.google.com/test/rich-results)
2. Validate JSON-LD format
3. Ensure all required properties are present:
   - name
   - description
   - url
   - telephone (if available)
   - address (if available)

4. Check for syntax errors in JSON-LD
5. Verify schema.org types are correct (LocalBusiness)

---

## Additional Resources

### Official Documentation

- [Google Search Console Help](https://support.google.com/webmasters)
- [Bing Webmaster Guidelines](https://www.bing.com/webmasters/help/webmasters-guidelines-30fba23a)
- [Google SEO Starter Guide](https://developers.google.com/search/docs/beginner/seo-starter-guide)
- [Schema.org LocalBusiness](https://schema.org/LocalBusiness)

### Testing Tools

- [Google Rich Results Test](https://search.google.com/test/rich-results)
- [Google Mobile-Friendly Test](https://search.google.com/test/mobile-friendly)
- [Google PageSpeed Insights](https://pagespeed.web.dev/)
- [XML Sitemap Validator](https://www.xml-sitemaps.com/validate-xml-sitemap.html)
- [Bing URL Inspection](https://www.bing.com/webmasters/url-inspection)

### Learning Resources

- [Google Search Central Blog](https://developers.google.com/search/blog)
- [Bing Webmaster Blog](https://blogs.bing.com/webmaster/)
- [Moz Beginner's Guide to SEO](https://moz.com/beginners-guide-to-seo)

---

## Checklist

Use this checklist to ensure all steps are completed:

### Google Search Console
- [ ] Account created and signed in
- [ ] Property added (domain or URL prefix)
- [ ] Domain ownership verified
- [ ] Sitemap submitted (`sitemap.xml`)
- [ ] Sitemap status checked (after 24-48 hours)
- [ ] Coverage report reviewed
- [ ] Performance monitoring set up
- [ ] Weekly monitoring scheduled

### Bing Webmaster Tools
- [ ] Account created and signed in
- [ ] Site added (imported from Google or manual)
- [ ] Site ownership verified
- [ ] Sitemap submitted
- [ ] Sitemap status checked (after 24-48 hours)
- [ ] Search performance monitoring set up
- [ ] Weekly monitoring scheduled

### Ongoing Monitoring
- [ ] Weekly coverage report review
- [ ] Monthly performance analysis
- [ ] Quarterly SEO strategy review
- [ ] Error monitoring and resolution
- [ ] New profile indexing requests
- [ ] Structured data validation

---

## Support

If you encounter issues not covered in this guide:

1. **Check the official documentation** (links above)
2. **Search the help forums**:
   - [Google Search Central Community](https://support.google.com/webmasters/community)
   - [Bing Webmaster Community](https://www.bing.com/webmasters/community)
3. **Contact the development team** for technical issues
4. **Review the ARSA technical documentation** for system-specific questions

---

**Document Version:** 1.0  
**Last Updated:** 2026-02-07  
**Maintained By:** ARSA Development Team  
**Next Review:** 2026-05-07
