<?php

use App\Models\Category;
use App\Models\District;
use App\Models\UmkmProfile;
use App\Services\SeoService;

beforeEach(function () {
    $this->service = new SeoService();
});

test('generates metadata with title and description', function () {
    $category = new Category(['nama_kategori' => 'Kuliner']);
    $district = new District(['nama_kecamatan' => 'Sidorejo']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana',
        'deskripsi' => 'Warung makan dengan menu masakan rumahan yang lezat dan terjangkau. Kami menyediakan berbagai pilihan menu nasi, lauk pauk, dan minuman segar.',
        'slug' => 'warung-makan-sederhana',
    ]);
    $profile->setRelation('category', $category);
    $profile->setRelation('district', $district);
    
    $metadata = $this->service->generateMetadata($profile);
    
    expect($metadata)->toHaveKeys(['seo_title', 'seo_description']);
    expect($metadata['seo_title'])->toBeString();
    expect($metadata['seo_description'])->toBeString();
});

test('generates title with business name, category, and district', function () {
    $category = new Category(['nama_kategori' => 'Kuliner']);
    $district = new District(['nama_kecamatan' => 'Sidorejo']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana',
        'slug' => 'warung-makan-sederhana',
    ]);
    $profile->setRelation('category', $category);
    $profile->setRelation('district', $district);
    
    $title = $this->service->generateTitle($profile);
    
    expect($title)->toContain('Warung Makan Sederhana');
    expect($title)->toContain('Kuliner');
    expect($title)->toContain('Sidorejo');
    expect($title)->toContain('ARSA');
});

test('generates title with default location when district is null', function () {
    $category = new Category(['nama_kategori' => 'Kuliner']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana',
        'slug' => 'warung-makan-sederhana',
    ]);
    $profile->setRelation('category', $category);
    $profile->setRelation('district', null);
    
    $title = $this->service->generateTitle($profile);
    
    expect($title)->toContain('Salatiga');
});

test('limits title to 60 characters', function () {
    $category = new Category(['nama_kategori' => 'Kuliner dan Makanan Tradisional']);
    $district = new District(['nama_kecamatan' => 'Sidorejo Lor Kidul']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana Dengan Nama Yang Sangat Panjang Sekali',
        'slug' => 'warung-makan-sederhana',
    ]);
    $profile->setRelation('category', $category);
    $profile->setRelation('district', $district);
    
    $title = $this->service->generateTitle($profile);
    
    expect(strlen($title))->toBeLessThanOrEqual(60);
    expect($title)->toEndWith('...');
});

test('generates description from profile deskripsi', function () {
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana',
        'deskripsi' => 'Warung makan dengan menu masakan rumahan yang lezat dan terjangkau.',
        'slug' => 'warung-makan-sederhana',
    ]);
    
    $description = $this->service->generateDescription($profile);
    
    expect($description)->toBe('Warung makan dengan menu masakan rumahan yang lezat dan terjangkau.');
});

test('strips HTML tags from description', function () {
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana',
        'deskripsi' => '<p>Warung makan dengan <strong>menu masakan</strong> rumahan yang lezat.</p>',
        'slug' => 'warung-makan-sederhana',
    ]);
    
    $description = $this->service->generateDescription($profile);
    
    expect($description)->not->toContain('<p>');
    expect($description)->not->toContain('<strong>');
    expect($description)->toBe('Warung makan dengan menu masakan rumahan yang lezat.');
});

test('limits description to 155 characters', function () {
    $longDescription = 'Warung makan dengan menu masakan rumahan yang lezat dan terjangkau. Kami menyediakan berbagai pilihan menu nasi, lauk pauk, sayur mayur, dan minuman segar setiap hari dengan harga yang sangat terjangkau untuk semua kalangan.';
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana',
        'deskripsi' => $longDescription,
        'slug' => 'warung-makan-sederhana',
    ]);
    
    $description = $this->service->generateDescription($profile);
    
    expect(strlen($description))->toBeLessThanOrEqual(155);
    expect($description)->toEndWith('...');
});

test('generates structured data with basic information', function () {
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana',
        'deskripsi' => 'Warung makan dengan menu masakan rumahan yang lezat.',
        'whatsapp' => '081234567890',
        'slug' => 'warung-makan-sederhana',
    ]);
    
    $structuredData = $this->service->generateStructuredData($profile);
    
    expect($structuredData)->toHaveKey('@context', 'https://schema.org');
    expect($structuredData)->toHaveKey('@type', 'LocalBusiness');
    expect($structuredData)->toHaveKey('name', 'Warung Makan Sederhana');
    expect($structuredData)->toHaveKey('description');
    expect($structuredData)->toHaveKey('telephone', '081234567890');
});

test('includes address in structured data when location is available', function () {
    $district = new District(['nama_kecamatan' => 'Sidorejo']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana',
        'deskripsi' => 'Warung makan dengan menu masakan rumahan yang lezat.',
        'whatsapp' => '081234567890',
        'slug' => 'warung-makan-sederhana',
        'latitude' => -7.123456,
        'longitude' => 110.654321,
    ]);
    $profile->setRelation('district', $district);
    
    $structuredData = $this->service->generateStructuredData($profile);
    
    expect($structuredData)->toHaveKey('address');
    expect($structuredData['address'])->toHaveKey('@type', 'PostalAddress');
    expect($structuredData['address'])->toHaveKey('addressLocality', 'Sidorejo');
    expect($structuredData['address'])->toHaveKey('addressRegion', 'Jawa Tengah');
    expect($structuredData['address'])->toHaveKey('addressCountry', 'ID');
});

test('includes geo coordinates in structured data when location is available', function () {
    $district = new District(['nama_kecamatan' => 'Sidorejo']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana',
        'deskripsi' => 'Warung makan dengan menu masakan rumahan yang lezat.',
        'whatsapp' => '081234567890',
        'slug' => 'warung-makan-sederhana',
        'latitude' => -7.123456,
        'longitude' => 110.654321,
    ]);
    $profile->setRelation('district', $district);
    
    $structuredData = $this->service->generateStructuredData($profile);
    
    expect($structuredData)->toHaveKey('geo');
    expect($structuredData['geo'])->toHaveKey('@type', 'GeoCoordinates');
    expect($structuredData['geo'])->toHaveKey('latitude', -7.123456);
    expect($structuredData['geo'])->toHaveKey('longitude', 110.654321);
});

test('includes image in structured data when logo is available', function () {
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana',
        'deskripsi' => 'Warung makan dengan menu masakan rumahan yang lezat.',
        'whatsapp' => '081234567890',
        'slug' => 'warung-makan-sederhana',
        'logo_path' => 'logos/warung-logo.jpg',
    ]);
    
    $structuredData = $this->service->generateStructuredData($profile);
    
    expect($structuredData)->toHaveKey('image');
    expect($structuredData['image'])->toContain('logos/warung-logo.jpg');
});

test('does not include address when location is not available', function () {
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana',
        'deskripsi' => 'Warung makan dengan menu masakan rumahan yang lezat.',
        'whatsapp' => '081234567890',
        'slug' => 'warung-makan-sederhana',
        'latitude' => null,
        'longitude' => null,
    ]);
    
    $structuredData = $this->service->generateStructuredData($profile);
    
    expect($structuredData)->not->toHaveKey('address');
    expect($structuredData)->not->toHaveKey('geo');
});

test('generates alt text for logo', function () {
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana',
    ]);
    
    $altText = $this->service->generateAltText($profile, 'logo');
    
    expect($altText)->toBe('Warung Makan Sederhana - Logo');
});

test('generates alt text for photo with index', function () {
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana',
    ]);
    
    $altText = $this->service->generateAltText($profile, 'photo', 0);
    
    expect($altText)->toBe('Warung Makan Sederhana - Foto 1');
});

test('generates alt text for photo with different index', function () {
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana',
    ]);
    
    $altText = $this->service->generateAltText($profile, 'photo', 2);
    
    expect($altText)->toBe('Warung Makan Sederhana - Foto 3');
});

test('generates default alt text for unknown type', function () {
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana',
    ]);
    
    $altText = $this->service->generateAltText($profile, 'unknown');
    
    expect($altText)->toBe('Warung Makan Sederhana');
});

test('generates placeholder emoji for Kuliner category', function () {
    $category = new Category(['nama_kategori' => 'Kuliner']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan Sederhana',
    ]);
    $profile->setRelation('category', $category);
    
    $placeholder = $this->service->generatePlaceholder($profile);
    
    expect($placeholder)->toBe('🍽️');
});

test('generates placeholder emoji for Fashion category', function () {
    $category = new Category(['nama_kategori' => 'Fashion']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Toko Baju Modern',
    ]);
    $profile->setRelation('category', $category);
    
    $placeholder = $this->service->generatePlaceholder($profile);
    
    expect($placeholder)->toBe('👕');
});

test('generates placeholder emoji for Kerajinan category', function () {
    $category = new Category(['nama_kategori' => 'Kerajinan Tangan']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Kerajinan Bambu',
    ]);
    $profile->setRelation('category', $category);
    
    $placeholder = $this->service->generatePlaceholder($profile);
    
    expect($placeholder)->toBe('🎨');
});

test('generates placeholder emoji for Jasa category', function () {
    $category = new Category(['nama_kategori' => 'Jasa Perbaikan']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Bengkel Motor',
    ]);
    $profile->setRelation('category', $category);
    
    $placeholder = $this->service->generatePlaceholder($profile);
    
    expect($placeholder)->toBe('🔧');
});

test('generates placeholder emoji for Teknologi category', function () {
    $category = new Category(['nama_kategori' => 'Teknologi Informasi']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Software House',
    ]);
    $profile->setRelation('category', $category);
    
    $placeholder = $this->service->generatePlaceholder($profile);
    
    expect($placeholder)->toBe('💻');
});

test('generates placeholder emoji for Pendidikan category', function () {
    $category = new Category(['nama_kategori' => 'Pendidikan dan Kursus']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Bimbel Cerdas',
    ]);
    $profile->setRelation('category', $category);
    
    $placeholder = $this->service->generatePlaceholder($profile);
    
    expect($placeholder)->toBe('📚');
});

test('generates placeholder emoji for Kesehatan category', function () {
    $category = new Category(['nama_kategori' => 'Kesehatan']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Klinik Sehat',
    ]);
    $profile->setRelation('category', $category);
    
    $placeholder = $this->service->generatePlaceholder($profile);
    
    expect($placeholder)->toBe('🏥');
});

test('generates placeholder emoji for Pertanian category', function () {
    $category = new Category(['nama_kategori' => 'Pertanian Organik']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Tani Makmur',
    ]);
    $profile->setRelation('category', $category);
    
    $placeholder = $this->service->generatePlaceholder($profile);
    
    expect($placeholder)->toBe('🌾');
});

test('generates placeholder emoji for Otomotif category', function () {
    $category = new Category(['nama_kategori' => 'Otomotif']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Bengkel Mobil',
    ]);
    $profile->setRelation('category', $category);
    
    $placeholder = $this->service->generatePlaceholder($profile);
    
    expect($placeholder)->toBe('🚗');
});

test('generates placeholder emoji for Properti category', function () {
    $category = new Category(['nama_kategori' => 'Properti dan Real Estate']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Rumah Idaman',
    ]);
    $profile->setRelation('category', $category);
    
    $placeholder = $this->service->generatePlaceholder($profile);
    
    expect($placeholder)->toBe('🏠');
});

test('generates initial-based placeholder when category does not match', function () {
    $category = new Category(['nama_kategori' => 'Lainnya']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Toko ABC',
    ]);
    $profile->setRelation('category', $category);
    
    $placeholder = $this->service->generatePlaceholder($profile);
    
    expect($placeholder)->toBe('T');
});

test('generates initial-based placeholder for different starting letter', function () {
    $category = new Category(['nama_kategori' => 'Lainnya']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Sederhana',
    ]);
    $profile->setRelation('category', $category);
    
    $placeholder = $this->service->generatePlaceholder($profile);
    
    expect($placeholder)->toBe('W');
});

test('generates default placeholder when no category and non-alphabetic initial', function () {
    $profile = new UmkmProfile([
        'nama_usaha' => '123 Toko',
    ]);
    $profile->setRelation('category', null);
    
    $placeholder = $this->service->generatePlaceholder($profile);
    
    expect($placeholder)->toBe('🏪');
});

test('generates default placeholder when category is null', function () {
    $profile = new UmkmProfile([
        'nama_usaha' => '999 Store',
    ]);
    $profile->setRelation('category', null);
    
    $placeholder = $this->service->generatePlaceholder($profile);
    
    expect($placeholder)->toBe('🏪');
});

test('category matching is case insensitive', function () {
    $category = new Category(['nama_kategori' => 'KULINER']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan',
    ]);
    $profile->setRelation('category', $category);
    
    $placeholder = $this->service->generatePlaceholder($profile);
    
    expect($placeholder)->toBe('🍽️');
});

test('category matching works with partial match', function () {
    $category = new Category(['nama_kategori' => 'Kuliner dan Makanan']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan',
    ]);
    $profile->setRelation('category', $category);
    
    $placeholder = $this->service->generatePlaceholder($profile);
    
    expect($placeholder)->toBe('🍽️');
});

test('generates metadata handles empty description gracefully', function () {
    $category = new Category(['nama_kategori' => 'Kuliner']);
    $district = new District(['nama_kecamatan' => 'Sidorejo']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan',
        'deskripsi' => '',
        'slug' => 'warung-makan',
    ]);
    $profile->setRelation('category', $category);
    $profile->setRelation('district', $district);
    
    $metadata = $this->service->generateMetadata($profile);
    
    expect($metadata)->toHaveKeys(['seo_title', 'seo_description']);
    expect($metadata['seo_description'])->toBe('');
});

test('generates title handles missing category gracefully', function () {
    $district = new District(['nama_kecamatan' => 'Sidorejo']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan',
        'slug' => 'warung-makan',
    ]);
    $profile->setRelation('category', null);
    $profile->setRelation('district', $district);
    
    $title = $this->service->generateTitle($profile);
    
    expect($title)->toContain('Warung Makan');
    expect($title)->toContain('Sidorejo');
    expect($title)->toContain('ARSA');
});

test('structured data handles missing district gracefully', function () {
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan',
        'deskripsi' => 'Warung makan enak',
        'whatsapp' => '081234567890',
        'slug' => 'warung-makan',
        'latitude' => -7.123456,
        'longitude' => 110.654321,
    ]);
    $profile->setRelation('district', null);
    
    $structuredData = $this->service->generateStructuredData($profile);
    
    expect($structuredData)->toHaveKey('address');
    expect($structuredData['address'])->toHaveKey('addressLocality', 'Salatiga');
});

test('generates alt text with zero index', function () {
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan',
    ]);
    
    $altText = $this->service->generateAltText($profile, 'photo', 0);
    
    expect($altText)->toBe('Warung Makan - Foto 1');
});

test('description preserves content when under 155 characters', function () {
    $shortDescription = 'Warung makan dengan menu lezat.';
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan',
        'deskripsi' => $shortDescription,
        'slug' => 'warung-makan',
    ]);
    
    $description = $this->service->generateDescription($profile);
    
    expect($description)->toBe($shortDescription);
    expect($description)->not->toEndWith('...');
});

test('title preserves content when under 60 characters', function () {
    $category = new Category(['nama_kategori' => 'Kuliner']);
    $district = new District(['nama_kecamatan' => 'Sidorejo']);
    
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung',
        'slug' => 'warung',
    ]);
    $profile->setRelation('category', $category);
    $profile->setRelation('district', $district);
    
    $title = $this->service->generateTitle($profile);
    
    expect(strlen($title))->toBeLessThan(60);
    expect($title)->not->toEndWith('...');
});

test('structured data includes all required LocalBusiness fields', function () {
    $profile = new UmkmProfile([
        'nama_usaha' => 'Warung Makan',
        'deskripsi' => 'Warung makan enak',
        'whatsapp' => '081234567890',
        'slug' => 'warung-makan',
    ]);
    
    $structuredData = $this->service->generateStructuredData($profile);
    
    expect($structuredData)->toHaveKey('@context');
    expect($structuredData)->toHaveKey('@type');
    expect($structuredData)->toHaveKey('name');
    expect($structuredData)->toHaveKey('description');
    expect($structuredData)->toHaveKey('telephone');
});
