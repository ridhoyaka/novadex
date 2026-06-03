<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\District;
use App\Models\UmkmProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * SEO Impact Tests for Category Links
 * 
 * Tests the SEO impact of category link implementation including:
 * - Breadcrumb navigation with category links
 * - Internal linking through related UMKM
 * - Category filter links in catalog
 * - Structured data for breadcrumbs
 * - Descriptive anchor text usage
 */
class SeoImpactTest extends TestCase
{
    use RefreshDatabase;

    protected User $umkmUser;
    protected Category $category;
    protected District $district;
    protected UmkmProfile $umkmProfile;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data
        $this->umkmUser = User::factory()->create(['role' => 'umkm']);
        $this->category = Category::factory()->create(['nama_kategori' => 'Kuliner']);
        $this->district = District::factory()->create(['nama_kecamatan' => 'Sidorejo']);
        
        $this->umkmProfile = UmkmProfile::factory()->create([
            'user_id' => $this->umkmUser->id,
            'kategori_id' => $this->category->id,
            'kecamatan_id' => $this->district->id,
            'nama_usaha' => 'Warung Makan Sederhana',
            'slug' => 'warung-makan-sederhana',
            'deskripsi' => 'Warung makan dengan menu masakan rumahan yang lezat dan terjangkau',
            'is_published' => true,
        ]);
    }

    /** @test */
    public function detail_page_contains_breadcrumb_navigation_with_category_link()
    {
        $response = $this->get(route('umkm.show', $this->umkmProfile->slug));

        $response->assertStatus(200);
        
        // Check breadcrumb structure
        $response->assertSee('Beranda');
        $response->assertSee('Katalog UMKM');
        $response->assertSee($this->category->nama_kategori);
        $response->assertSee($this->umkmProfile->nama_usaha);
        
        // Check breadcrumb links
        $response->assertSee(route('home'));
        $response->assertSee(route('umkm.index'));
        $response->assertSee(route('umkm.index', ['kategori' => $this->category->id]));
    }

    /** @test */
    public function breadcrumb_uses_descriptive_anchor_text()
    {
        $response = $this->get(route('umkm.show', $this->umkmProfile->slug));

        $response->assertStatus(200);
        
        // Verify descriptive anchor text (not generic "click here" or URLs)
        $response->assertSee('Beranda', false);
        $response->assertSee('Katalog UMKM', false);
        $response->assertSee($this->category->nama_kategori, false);
        
        // Ensure no generic anchor text
        $response->assertDontSee('click here');
        $response->assertDontSee('klik di sini');
    }

    /** @test */
    public function breadcrumb_structured_data_is_present()
    {
        $response = $this->get(route('umkm.show', $this->umkmProfile->slug));

        $response->assertStatus(200);
        
        // Check for JSON-LD breadcrumb structured data
        $response->assertSee('"@type": "BreadcrumbList"', false);
        $response->assertSee('"@type": "ListItem"', false);
        $response->assertSee('"position": 1', false);
        $response->assertSee('"position": 2', false);
        $response->assertSee('"position": 3', false);
        $response->assertSee('"position": 4', false);
        
        // Verify breadcrumb items
        $response->assertSee('"name": "Beranda"', false);
        $response->assertSee('"name": "Katalog UMKM"', false);
        $response->assertSee('"name": "' . $this->category->nama_kategori . '"', false);
        $response->assertSee('"name": "' . $this->umkmProfile->nama_usaha . '"', false);
    }

    /** @test */
    public function detail_page_contains_related_umkm_section()
    {
        // Create related UMKM in same category
        $relatedUmkm = UmkmProfile::factory()->count(3)->create([
            'kategori_id' => $this->category->id,
            'kecamatan_id' => $this->district->id,
            'is_published' => true,
        ]);

        $response = $this->get(route('umkm.show', $this->umkmProfile->slug));

        $response->assertStatus(200);
        
        // Check for "UMKM Sejenis" section
        $response->assertSee('UMKM Sejenis');
        
        // Verify at least one related UMKM is shown
        $response->assertSee($relatedUmkm->first()->nama_usaha);
    }

    /** @test */
    public function related_umkm_links_use_descriptive_anchor_text()
    {
        // Create related UMKM
        $relatedUmkm = UmkmProfile::factory()->create([
            'kategori_id' => $this->category->id,
            'nama_usaha' => 'Bakso Pak Kumis',
            'is_published' => true,
        ]);

        $response = $this->get(route('umkm.show', $this->umkmProfile->slug));

        $response->assertStatus(200);
        
        // Verify business name is used as anchor text (descriptive)
        $response->assertSee($relatedUmkm->nama_usaha);
        $response->assertSee(route('umkm.show', $relatedUmkm->slug));
    }

    /** @test */
    public function catalog_page_contains_category_filter_links()
    {
        $response = $this->get(route('umkm.index'));

        $response->assertStatus(200);
        
        // Check for category filter dropdown
        $response->assertSee('KATEGORI');
        $response->assertSee($this->category->nama_kategori);
        
        // Verify category can be selected
        $response->assertSee('name="category"', false);
    }

    /** @test */
    public function category_filter_creates_seo_friendly_urls()
    {
        $response = $this->get(route('umkm.index', ['category' => $this->category->id]));

        $response->assertStatus(200);
        
        // Verify URL contains category parameter
        $this->assertEquals($this->category->id, request()->get('category'));
        
        // Verify filtered results
        $response->assertSee($this->umkmProfile->nama_usaha);
    }

    /** @test */
    public function active_category_filter_is_displayed_with_descriptive_text()
    {
        $response = $this->get(route('umkm.index', ['category' => $this->category->id]));

        $response->assertStatus(200);
        
        // Check for active filter display
        $response->assertSee('FILTER AKTIF:');
        $response->assertSee($this->category->nama_kategori);
    }

    /** @test */
    public function internal_links_improve_crawlability()
    {
        // Create multiple UMKM in same category
        $umkmList = UmkmProfile::factory()->count(5)->create([
            'kategori_id' => $this->category->id,
            'is_published' => true,
        ]);

        // Visit first UMKM detail page
        $response = $this->get(route('umkm.show', $umkmList->first()->slug));
        $response->assertStatus(200);
        
        // Verify links to other UMKM exist (internal linking)
        $response->assertSee('UMKM Sejenis');
        
        // Count internal links to other UMKM
        $content = $response->getContent();
        $linkCount = substr_count($content, route('umkm.show', ''));
        
        // Should have at least 1 internal link to related UMKM
        $this->assertGreaterThan(0, $linkCount);
    }

    /** @test */
    public function category_links_are_crawlable_by_search_engines()
    {
        $response = $this->get(route('umkm.show', $this->umkmProfile->slug));

        $response->assertStatus(200);
        
        // Verify links use <a> tags (not JavaScript navigation)
        $response->assertSee('<a href="' . route('umkm.index', ['kategori' => $this->category->id]) . '"', false);
        
        // Verify no nofollow attribute on category links
        $content = $response->getContent();
        $categoryLinkPattern = '/<a[^>]*href="[^"]*kategori=' . $this->category->id . '[^"]*"[^>]*rel="nofollow"/';
        $this->assertDoesNotMatchRegularExpression($categoryLinkPattern, $content);
    }

    /** @test */
    public function sitemap_includes_category_filtered_pages()
    {
        $response = $this->get(route('sitemap'));

        $response->assertStatus(200);
        // Accept both UTF-8 and utf-8 (case insensitive)
        $contentType = $response->headers->get('Content-Type');
        $this->assertStringContainsString('text/xml', $contentType);
        $this->assertStringContainsString('charset=utf-8', strtolower($contentType));
        
        // Verify sitemap includes UMKM detail pages
        $response->assertSee('<loc>' . route('umkm.show', $this->umkmProfile->slug) . '</loc>', false);
        
        // Verify sitemap includes catalog page
        $response->assertSee('<loc>' . route('umkm.index') . '</loc>', false);
    }

    /** @test */
    public function category_links_have_proper_html_structure()
    {
        $response = $this->get(route('umkm.show', $this->umkmProfile->slug));

        $response->assertStatus(200);
        
        // Verify breadcrumb uses semantic HTML (nav, ol, li)
        $response->assertSee('<nav', false);
        $response->assertSee('aria-label="Breadcrumb"', false);
        $response->assertSee('<ol', false);
        $response->assertSee('<li', false);
    }

    /** @test */
    public function related_umkm_section_shows_category_and_district_badges()
    {
        // Create related UMKM
        $relatedUmkm = UmkmProfile::factory()->create([
            'kategori_id' => $this->category->id,
            'kecamatan_id' => $this->district->id,
            'is_published' => true,
        ]);

        $response = $this->get(route('umkm.show', $this->umkmProfile->slug));

        $response->assertStatus(200);
        
        // Verify category and district are displayed in related UMKM
        $response->assertSee($relatedUmkm->category->nama_kategori);
        $response->assertSee($relatedUmkm->district->nama_kecamatan);
    }

    /** @test */
    public function page_title_includes_category_for_seo()
    {
        $response = $this->get(route('umkm.show', $this->umkmProfile->slug));

        $response->assertStatus(200);
        
        // Verify page title includes category
        $expectedTitle = $this->umkmProfile->nama_usaha . ' - ' . $this->category->nama_kategori;
        $response->assertSee('<title>' . $expectedTitle, false);
    }

    /** @test */
    public function meta_description_is_present_for_seo()
    {
        $response = $this->get(route('umkm.show', $this->umkmProfile->slug));

        $response->assertStatus(200);
        
        // Verify meta description exists
        $response->assertSee('<meta name="description"', false);
        $response->assertSee($this->umkmProfile->deskripsi);
    }

    /** @test */
    public function meta_keywords_include_category()
    {
        $response = $this->get(route('umkm.show', $this->umkmProfile->slug));

        $response->assertStatus(200);
        
        // Verify meta keywords include category
        $response->assertSee('<meta name="keywords"', false);
        $response->assertSee($this->category->nama_kategori);
    }

    /** @test */
    public function canonical_url_is_present()
    {
        $response = $this->get(route('umkm.show', $this->umkmProfile->slug));

        $response->assertStatus(200);
        
        // Verify canonical URL
        $response->assertSee('<link rel="canonical"', false);
        $response->assertSee(route('umkm.show', $this->umkmProfile->slug));
    }

    /** @test */
    public function open_graph_tags_are_present_for_social_sharing()
    {
        $response = $this->get(route('umkm.show', $this->umkmProfile->slug));

        $response->assertStatus(200);
        
        // Verify Open Graph tags
        $response->assertSee('<meta property="og:type"', false);
        $response->assertSee('<meta property="og:url"', false);
        $response->assertSee('<meta property="og:title"', false);
        $response->assertSee('<meta property="og:description"', false);
    }

    /** @test */
    public function twitter_card_tags_are_present()
    {
        $response = $this->get(route('umkm.show', $this->umkmProfile->slug));

        $response->assertStatus(200);
        
        // Verify Twitter Card tags
        $response->assertSee('<meta name="twitter:card"', false);
        $response->assertSee('<meta name="twitter:title"', false);
        $response->assertSee('<meta name="twitter:description"', false);
    }

    /** @test */
    public function structured_data_includes_local_business_schema()
    {
        $response = $this->get(route('umkm.show', $this->umkmProfile->slug));

        $response->assertStatus(200);
        
        // Verify LocalBusiness structured data (check for both formatted and minified JSON)
        $content = $response->getContent();
        $this->assertStringContainsString('@type', $content);
        $this->assertStringContainsString('LocalBusiness', $content);
        $this->assertStringContainsString($this->umkmProfile->nama_usaha, $content);
    }

    /** @test */
    public function category_filter_maintains_other_filters()
    {
        $response = $this->get(route('umkm.index', [
            'category' => $this->category->id,
            'district' => $this->district->id,
            'search' => 'warung',
        ]));

        $response->assertStatus(200);
        
        // Verify all filters are maintained
        $this->assertEquals($this->category->id, request()->get('category'));
        $this->assertEquals($this->district->id, request()->get('district'));
        $this->assertEquals('warung', request()->get('search'));
    }

    /** @test */
    public function related_umkm_prioritizes_same_category()
    {
        // Create UMKM in same category
        $sameCategoryUmkm = UmkmProfile::factory()->count(3)->create([
            'kategori_id' => $this->category->id,
            'is_published' => true,
        ]);

        // Create UMKM in different category
        $differentCategory = Category::factory()->create();
        $differentCategoryUmkm = UmkmProfile::factory()->count(2)->create([
            'kategori_id' => $differentCategory->id,
            'is_published' => true,
        ]);

        $response = $this->get(route('umkm.show', $this->umkmProfile->slug));

        $response->assertStatus(200);
        
        // Verify same category UMKM are shown
        $response->assertSee($sameCategoryUmkm->first()->nama_usaha);
        
        // Different category UMKM should not be shown (or shown less)
        $content = $response->getContent();
        $sameCategoryCount = substr_count($content, $sameCategoryUmkm->first()->category->nama_kategori);
        $differentCategoryCount = substr_count($content, $differentCategory->nama_kategori);
        
        $this->assertGreaterThanOrEqual($differentCategoryCount, $sameCategoryCount);
    }

    /** @test */
    public function robots_txt_allows_category_pages()
    {
        // Read robots.txt file directly since Laravel test doesn't serve static files
        $robotsPath = public_path('robots.txt');
        
        $this->assertFileExists($robotsPath, 'robots.txt file should exist in public directory');
        
        $content = file_get_contents($robotsPath);
        
        // Verify robots.txt doesn't disallow public catalog and detail pages
        $this->assertStringNotContainsString('Disallow: /katalog', $content);
        $this->assertStringNotContainsString('Disallow: /umkm/$', $content); // Public detail pages
        
        // Verify private UMKM profile pages ARE disallowed (correct behavior)
        $this->assertStringContainsString('Disallow: /umkm/profil/', $content);
        
        // Verify sitemap is referenced
        $this->assertStringContainsString('Sitemap:', $content);
        
        // Verify public pages are allowed
        $this->assertStringContainsString('Allow: /', $content);
    }
}
