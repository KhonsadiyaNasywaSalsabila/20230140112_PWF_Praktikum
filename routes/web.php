<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Product
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    
    // Gunakan middleware 'can:manage-product' agar lebih rapi & aman
    Route::get('/product/create', [ProductController::class, 'create'])
        ->middleware('can:manage-product')
        ->name('product.create');
        
    Route::post('/product', [ProductController::class, 'store'])
        ->middleware('can:manage-product')
        ->name('product.store');
        
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
    
    Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
});

Route::get('/about', [AboutController::class, 'index'])->middleware('auth');

require __DIR__.'/auth.php';