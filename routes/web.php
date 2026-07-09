<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingsController;

// ── Public routes ─────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome', [
        'instagramUrl' => config('services.instagram.url'),
        'whatsappUrl'  => config('services.whatsapp.url'),
    ]);
});

Route::get('/catalogo', [ProductController::class, 'index'])->name('product.catalog');
Route::get('/produto/{slug?}', [ProductController::class, 'show'])->name('product.show');

// ── Admin Auth ────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ── Protected admin routes ────────────────────────────────────────────────
    Route::middleware('admin')->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Products
        Route::get('/produtos', [ProductAdminController::class, 'index'])->name('products.index');
        Route::get('/produtos/novo', [ProductAdminController::class, 'create'])->name('products.create');
        Route::post('/produtos', [ProductAdminController::class, 'store'])->name('products.store');
        Route::get('/produtos/{product}/editar', [ProductAdminController::class, 'edit'])->name('products.edit');
        Route::put('/produtos/{product}', [ProductAdminController::class, 'update'])->name('products.update');
        Route::delete('/produtos/{product}', [ProductAdminController::class, 'destroy'])->name('products.destroy');
        Route::patch('/produtos/{product}/toggle', [ProductAdminController::class, 'toggleStatus'])->name('products.toggle');

        // Orders
        Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/pedidos/novo', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/pedidos', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/pedidos/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/pedidos/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
        Route::delete('/pedidos/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

        // Settings
        Route::get('/configuracoes', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/configuracoes', [SettingsController::class, 'update'])->name('settings.update');
    });
});
