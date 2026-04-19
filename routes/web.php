<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SuperOfertasController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\NotificationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('landing');

Route::get('/home', function () {
    return view('client');
})->middleware(['auth', 'verified'])->name('client.home');

Route::get('/error', function (Request $request) {
    return view('error', ['message' => $request->query('message')]);
})->name('error');

Route::get('/dashboard', function () {
    return view('client');
})->middleware(['auth', 'verified'])->name('dashboard');

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

require __DIR__.'/auth.php';
