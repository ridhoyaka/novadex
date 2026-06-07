# Quick Reference: Search Engine Submission

## Quick Links

### Google Search Console
- **URL**: https://search.google.com/search-console
- **Sitemap URL**: `https://yourdomain.com/sitemap.xml`
- **Verification Methods**: DNS, HTML file, Meta tag, Google Analytics

### Bing Webmaster Tools
- **URL**: https://www.bing.com/webmasters
- **Sitemap URL**: `https://yourdomain.com/sitemap.xml`
- **Verification Methods**: XML file, Meta tag, CNAME record, Import from Google

---

## 5-Minute Setup (Google)

1. Go to [Google Search Console](https://search.google.com/search-console)
2. Click "Add Property" → Enter your domain
3. Verify ownership (choose easiest method for you)
4. Go to "Sitemaps" → Enter `sitemap.xml` → Submit
5. Done! Check back in 24-48 hours

---

## 5-Minute Setup (Bing)

1. Go to [Bing Webmaster Tools](https://www.bing.com/webmasters)
2. Click "Import from Google Search Console" (easiest!)
3. Sign in to Google and authorize
4. Select your property → Import
5. Done! Sitemap is automatically imported

---

## Weekly Monitoring Checklist

### Google Search Console (5 minutes)
- [ ] Check "Coverage" report for errors
- [ ] Review "Performance" for traffic trends
- [ ] Check for new "Enhancements" issues
- [ ] Request indexing for new UMKM profiles

### Bing Webmaster Tools (3 minutes)
- [ ] Check "Site Explorer" for indexing status
- [ ] Review "Search Performance" metrics
- [ ] Check "SEO Reports" for issues

---

## Common Issues & Quick Fixes

### Sitemap Not Found (404)
```bash
# Clear route cache
php artisan route:clear
php artisan route:cache

# Test sitemap
curl https://yourdomain.com/sitemap.xml
```

### Pages Not Indexing
1. Check robots.txt: `https://yourdomain.com/robots.txt`
2. Verify no `noindex` meta tags on pages
3. Request indexing manually via URL Inspection tool
4. Wait 2-4 weeks for new sites

### Slow Indexing
1. Improve page speed (target < 2 seconds)
2. Fix server errors
3. Build internal links
4. Request indexing for important pages

---

## Key Metrics to Track

| Metric | Target | Where to Find |
|--------|--------|---------------|
| Indexed Pages | = Published UMKM count | Coverage Report |
| Average Position | < 20 (first 2 pages) | Performance Report |
| Click-Through Rate | > 2% | Performance Report |
| Mobile Usability | 0 errors | Enhancements Report |
| Page Speed | > 80 score | PageSpeed Insights |
| Structured Data | 0 errors | Rich Results Test |

---

## Testing Tools (Bookmarks)

- **Rich Results**: https://search.google.com/test/rich-results
- **Mobile-Friendly**: https://search.google.com/test/mobile-friendly
- **PageSpeed**: https://pagespeed.web.dev/
- **Sitemap Validator**: https://www.xml-sitemaps.com/validate-xml-sitemap.html

---

## Request Indexing for New Profile

### Google
1. Copy UMKM profile URL
2. Go to Search Console → URL Inspection (top bar)
3. Paste URL → Press Enter
4. Click "Request Indexing"
5. Wait 24-48 hours

### Bing
1. Copy UMKM profile URL
2. Go to Webmaster Tools → URL Inspection
3. Paste URL → Submit
4. Click "Submit URL"
5. Wait 24-48 hours

---

## Monthly Report Template

```
NovaDex SEO Monthly Report - [Month Year]

Google Search Console:
- Total Indexed Pages: [X] / [Y published]
- Total Clicks: [X] (change: +/- X%)
- Total Impressions: [X] (change: +/- X%)
- Average Position: [X] (change: +/- X)
- Average CTR: [X]% (change: +/- X%)

Bing Webmaster Tools:
- Total Indexed Pages: [X] / [Y published]
- Total Clicks: [X]
- Total Impressions: [X]
- Average Position: [X]

Issues Found:
- [List any errors or warnings]

Actions Taken:
- [List fixes or improvements]

Next Month Goals:
- [List objectives]
```

---

## Emergency Contacts

- **Technical Issues**: Contact NovaDex Development Team
- **Google Support**: https://support.google.com/webmasters/community
- **Bing Support**: https://www.bing.com/webmasters/community

---

## Verification Files Location

If using file verification method:

- **Google**: Upload to `public/google[code].html`
- **Bing**: Upload to `public/BingSiteAuth.xml`

Make sure files are accessible:
- `https://yourdomain.com/google[code].html`
- `https://yourdomain.com/BingSiteAuth.xml`

---

## robots.txt Template

Your `public/robots.txt` should look like this:

```
User-agent: *
Allow: /

# Sitemap
Sitemap: https://yourdomain.com/sitemap.xml

# Disallow admin areas
Disallow: /admin/
Disallow: /umkm/dashboard/
Disallow: /superadmin/
```

---

**For detailed instructions, see**: `docs/seo/search-engine-submission-guide.md`
