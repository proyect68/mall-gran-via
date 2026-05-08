<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SuperOfertasController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\NotificationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('landing');

Route::get('/home', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('client.home');

Route::get('/error', function (Request $request) {
    return view('error', ['message' => $request->query('message')]);
})->name('error');

Route::get('/dashboard', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/superofertas', [SuperOfertasController::class, 'index'])->middleware(['auth', 'verified'])->name('superofertas.index');

Route::get('/stores', [StoresController::class, 'index'])->middleware(['auth', 'verified'])->name('stores.index');

Route::get('/stores/{store}', [StoresController::class, 'show'])->middleware(['auth', 'verified'])->name('stores.show');

Route::get('/wishlist', [WishlistController::class, 'index'])->middleware(['auth', 'verified'])->name('wishlist.index');

Route::get('/history', [HistoryController::class, 'index'])->middleware(['auth', 'verified'])->name('history.index');

Route::get('/notifications', [NotificationsController::class, 'index'])->middleware(['auth', 'verified'])->name('notifications.index');

Route::get('/categories', [CategoriesController::class, 'index'])->middleware(['auth', 'verified'])->name('categories.index');

Route::get('/categories/{id}/subcategorias', [CategoriesController::class, 'showSubcategorias'])->middleware(['auth', 'verified'])->name('categories.subcategorias');

// Development assignment route
Route::get('/dev/assign-products', [\App\Http\Controllers\AssignmentController::class, 'assignProducts'])->name('dev.assign-products');

Route::get('/subcategorias/{subcategoriaId}', [CategoriesController::class, 'showSubcategoria'])->middleware(['auth', 'verified'])->name('subcategorias.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/product/{id}', [ProductController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('products.show');

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Users
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Products
    Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
    Route::patch('/products/{product}/toggle-status', [\App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::delete('/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');

    // Stores
    Route::get('/stores', [\App\Http\Controllers\Admin\StoreController::class, 'index'])->name('stores.index');
    Route::get('/stores/{store}/edit', [\App\Http\Controllers\Admin\StoreController::class, 'edit'])->name('stores.edit');
    Route::put('/stores/{store}', [\App\Http\Controllers\Admin\StoreController::class, 'update'])->name('stores.update');
    Route::patch('/stores/{store}/toggle-status', [\App\Http\Controllers\Admin\StoreController::class, 'toggleStatus'])->name('stores.toggle-status');
    Route::delete('/stores/{store}', [\App\Http\Controllers\Admin\StoreController::class, 'destroy'])->name('stores.destroy');
});

require __DIR__.'/auth.php';
