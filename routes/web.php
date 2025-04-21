<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\HighlightController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NoHandphoneController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PremiumPackageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TemplateGalleryController;
use App\Http\Controllers\TemplateHighlightController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');

    return "Cache cleared successfully!";
});

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/bisnis', [PageController::class, 'product'])->name('allproduct');
Route::get('/bisnis/page/{page?}', [PageController::class, 'product'])->name('pageproduct');
Route::get('/bisnis/kategori/{category}', [PageController::class, 'categorybusiness'])->name('category.business');
Route::get('/bisnis/kategori/{category}/page/{page?}', [PageController::class, 'categorybusiness'])->name('category.business.page');

Route::get('/template', [PageController::class, 'template'])->name('alltemplate');

Route::get('/join', [PageController::class, 'join'])->name('join');
Route::post('/store-product', [PageController::class, 'storeproduct'])->name('store.product');

Route::post('/order/{no_tlp}', [PageController::class, 'order'])->name('order');

Route::get('/sitemap', [SitemapController::class, 'index']);

Route::get('/create-product', [PageController::class, 'createproduct'])->name('create.product');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::get('/rekap/{code}', [InvoiceController::class, 'invoice'])->name('invoice.show');

Route::get('/paket-premium', [PageController::class, 'premiumPackage'])->name('premium.package');

Route::get('/beli-paket/{id}', [PageController::class, 'buyPackage'])->name('buy.package');

Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard', [ProductController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::group(['middleware' => 'cekUser'], function () {
        Route::group(['middleware' => 'cekRole'], function () {
            Route::resource('/admin/user', UserController::class);
    
            Route::resource('/admin/template', TemplateController::class);
            Route::put('/template/editimage/{id}', [TemplateController::class, 'editimage'])->name('template.editimage');
        
            Route::resource('/admin/access', AccessController::class);

            Route::resource('/admin/package', PremiumPackageController::class);
        });
        Route::resource('/admin/rekap', InvoiceController::class);
    
        Route::get('/admin/premium', [AdminController::class, 'premium'])->name('premium.index');
    
        Route::resource('/admin/no-handphone', NoHandphoneController::class);
    
        Route::resource('/admin/product', ProductController::class);
        Route::put('/admin/product-order/{id}', [ProductController::class, 'productorder'])->name('product.order');
        Route::put('/admin/product-title/{id}', [ProductController::class, 'producttitle'])->name('product.title');
    
        Route::resource('/admin/product-gallery', ProductGalleryController::class);
    
        Route::resource('/admin/highlight', HighlightController::class);
        Route::post('/admin/highlight/multiple', [HighlightController::class, 'multiple'])->name('highlight.multiple');
        Route::put('/admin/highlight-available/{id}', [HighlightController::class, 'available'])->name('highlight.available');
    
        Route::resource('/admin/template-highlight', TemplateHighlightController::class);
    
        Route::resource('/admin/template-gallery', TemplateGalleryController::class);
    
        Route::get('/check-profile', [ProfileController::class, 'check']);
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';

Route::get('/embed/event', [PageController::class, 'test'])->name('test');
Route::get('/{slug}', [PageController::class, 'detail'])->name('detail');
Route::get('/template/{slug}', [PageController::class, 'templatedetail'])->name('template.detail');

