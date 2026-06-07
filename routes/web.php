<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\MapController;
use App\Http\Controllers\Public\UmkmCatalogController;
use App\Http\Controllers\Public\UmkmDetailController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [UmkmCatalogController::class, 'index'])->name('umkm.index');
Route::get('/katalog/kategori', [UmkmCatalogController::class, 'categories'])->name('umkm.categories');
Route::get('/peta-umkm', [MapController::class, 'index'])->name('umkm.map');

// Sitemap
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// UMKM Dashboard Routes (must be before public detail route)
Route::middleware(['auth', 'role:umkm'])->prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Umkm\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil/edit', [\App\Http\Controllers\Umkm\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [\App\Http\Controllers\Umkm\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profil/toggle-publish', [\App\Http\Controllers\Umkm\ProfileController::class, 'togglePublish'])->name('profile.toggle-publish');
    Route::post('/profil/upload-logo', [\App\Http\Controllers\Umkm\ProfileController::class, 'uploadLogo'])->name('profile.upload-logo');
    Route::post('/profil/upload-photo', [\App\Http\Controllers\Umkm\ProfileController::class, 'uploadPhoto'])->name('profile.upload-photo');
    Route::delete('/profil/delete-photo', [\App\Http\Controllers\Umkm\ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');

    // Location management
    Route::post('/profil/location', [\App\Http\Controllers\Umkm\ProfileController::class, 'updateLocation'])->name('profile.location.update');
    Route::delete('/profil/location', [\App\Http\Controllers\Umkm\ProfileController::class, 'removeLocation'])->name('profile.location.remove');
    Route::post('/profil/geocode', [\App\Http\Controllers\Umkm\ProfileController::class, 'geocode'])->name('profile.geocode');

    // Photo reordering
    Route::post('/profil/reorder-photos', [\App\Http\Controllers\Umkm\ProfileController::class, 'reorderPhotos'])->name('profile.reorder-photos');
});

// Public UMKM Detail Route (must be after UMKM dashboard routes)
Route::get('/umkm/{slug}', [UmkmDetailController::class, 'show'])->name('umkm.show');

// Admin Dashboard Routes (accessible by admin and super_admin)
Route::middleware(['auth', 'role.any:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // UMKM Management (Read-Only + Offline Registration)
    Route::get('/umkm', [\App\Http\Controllers\Admin\UmkmController::class, 'index'])->name('umkm.index');
    Route::get('/umkm/create', [\App\Http\Controllers\Admin\UmkmController::class, 'create'])->name('umkm.create');
    Route::post('/umkm', [\App\Http\Controllers\Admin\UmkmController::class, 'store'])->name('umkm.store');
    Route::get('/umkm/export', [\App\Http\Controllers\Admin\UmkmController::class, 'export'])->name('umkm.export');
    Route::get('/umkm/{umkm}', [\App\Http\Controllers\Admin\UmkmController::class, 'show'])->name('umkm.show');
    Route::post('/umkm/{umkm}/moderate-publish', [\App\Http\Controllers\Admin\UmkmController::class, 'moderatePublish'])->name('umkm.moderate-publish');
    // Note: Admin CANNOT edit or delete UMKM profiles - only UMKM owners can do that

    // Content Monitoring
    Route::get('/content', [\App\Http\Controllers\Admin\ContentController::class, 'index'])->name('content.index');
    Route::get('/content/{profile}', [\App\Http\Controllers\Admin\ContentController::class, 'show'])->name('content.show');
    Route::get('/content-map', [\App\Http\Controllers\Admin\ContentController::class, 'map'])->name('content.map');

    // Profile Flagging
    Route::post('/flags/{profile}', [\App\Http\Controllers\Admin\FlagController::class, 'store'])->name('flags.store');
    Route::patch('/flags/{flag}/resolve', [\App\Http\Controllers\Admin\FlagController::class, 'resolve'])->name('flags.resolve');
    Route::patch('/flags/{flag}/dismiss', [\App\Http\Controllers\Admin\FlagController::class, 'dismiss'])->name('flags.dismiss');

    // Category Management
    Route::get('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
});

// Super Admin Dashboard Routes (Full Access)
Route::middleware(['auth', 'role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');

    // UMKM Management (Full CRUD)
    Route::get('/umkm', [\App\Http\Controllers\SuperAdmin\UmkmController::class, 'index'])->name('umkm.index');
    Route::get('/umkm/export', [\App\Http\Controllers\SuperAdmin\UmkmController::class, 'export'])->name('umkm.export');
    Route::get('/umkm/{umkm}', [\App\Http\Controllers\SuperAdmin\UmkmController::class, 'show'])->name('umkm.show');
    Route::get('/umkm/{umkm}/edit', [\App\Http\Controllers\SuperAdmin\UmkmController::class, 'edit'])->name('umkm.edit');
    Route::put('/umkm/{umkm}', [\App\Http\Controllers\SuperAdmin\UmkmController::class, 'update'])->name('umkm.update');
    Route::delete('/umkm/{umkm}', [\App\Http\Controllers\SuperAdmin\UmkmController::class, 'destroy'])->name('umkm.destroy');
    Route::post('/umkm/{umkm}/toggle-publish', [\App\Http\Controllers\SuperAdmin\UmkmController::class, 'togglePublish'])->name('umkm.toggle-publish');

    // User Management
    Route::get('/users', [\App\Http\Controllers\SuperAdmin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [\App\Http\Controllers\SuperAdmin\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\SuperAdmin\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\SuperAdmin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\SuperAdmin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\SuperAdmin\UserController::class, 'destroy'])->name('users.destroy');

    // District Management (Full CRUD)
    Route::get('/districts', [\App\Http\Controllers\SuperAdmin\DistrictController::class, 'index'])->name('districts.index');
    Route::post('/districts', [\App\Http\Controllers\SuperAdmin\DistrictController::class, 'store'])->name('districts.store');
    Route::put('/districts/{district}', [\App\Http\Controllers\SuperAdmin\DistrictController::class, 'update'])->name('districts.update');
    Route::delete('/districts/{district}', [\App\Http\Controllers\SuperAdmin\DistrictController::class, 'destroy'])->name('districts.destroy');

    // Category Management (Full CRUD)
    Route::get('/categories', [\App\Http\Controllers\SuperAdmin\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [\App\Http\Controllers\SuperAdmin\CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [\App\Http\Controllers\SuperAdmin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [\App\Http\Controllers\SuperAdmin\CategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isSuperAdmin()) {
        return redirect()->route('superadmin.dashboard');
    }
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    if ($user->isUmkm()) {
        return redirect()->route('umkm.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
