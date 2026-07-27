<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public / Frontend Routes
Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('generate-pdf', [FrontendController::class, 'exportPdf'])->name('frontend.frontendpdf');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Authenticated Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

// Admin Protected Routes
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Resources
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    // Categories
    Route::controller(CategoryController::class)->group(function () {
        Route::get('category', 'index')->name('admin.categories.index');
        Route::get('category/create', 'create')->name('admin.categories.create');
        Route::post('category', 'store')->name('admin.categories.store');
        Route::get('category/{id}/edit', 'edit')->name('admin.categories.edit');
        Route::put('category/{id}', 'update')->name('admin.categories.update');
        Route::delete('category/{id}', 'destroy')->name('admin.categories.destroy');
    });

    // Brands
    Route::controller(BrandController::class)->group(function () {
        Route::get('brand', 'index')->name('admin.brands.index');
        Route::get('brand/create', 'create')->name('admin.brands.create');
        Route::post('brand', 'store')->name('admin.brands.store');
        Route::get('brand/{id}/edit', 'edit')->name('admin.brands.edit');
        Route::put('brand/{id}', 'update')->name('admin.brands.update');
        Route::delete('brand/{id}', 'destroy')->name('admin.brands.destroy');
    });

    // Products (Static routes declared BEFORE dynamic {id} routes)
    Route::controller(ProductController::class)->group(function () {
        Route::get('product', 'index')->name('admin.products.index');
        Route::get('product/create', 'create')->name('admin.products.create');
        Route::post('product', 'store')->name('admin.products.store');
        Route::delete('product/bulk-delete', 'productBulkDelete')->name('admin.products.productBulkDelete');
        Route::get('product/generate-pdf', 'generatePdf')->name('admin.products.generatePdf');
        
        // Parameterized routes at the end
        Route::get('product/{id}/edit', 'edit')->name('admin.products.edit');
        Route::put('product/{id}', 'update')->name('admin.products.update');
        Route::delete('product/{id}', 'destroy')->name('admin.products.destroy');
    });

});

require __DIR__.'/settings.php';
require __DIR__.'/admin.php';