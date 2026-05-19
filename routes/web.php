<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//fotos
Route::get('/photos', [PhotoController::class, 'index'])->name('photos.index');
Route::get('/photos/{photo}', [PhotoController::class, 'show'])->name('photos.show');

//pedidos
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');

//usuarios
Route::middleware(['auth'])->group(function () {

    //  usuarios 
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');

    Route::get('/users/create', [UserController::class, 'create'])
        ->name('users.create');

    Route::post('/users', [UserController::class, 'store'])
        ->name('users.store');

    Route::get('/users/{user}', [UserController::class, 'show'])
        ->name('users.show');

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->name('users.edit');

    Route::put('/users/{user}', [UserController::class, 'update'])
        ->name('users.update');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->name('users.destroy');
});

//albumes
Route::get('/albums', [AlbumController::class, 'index'])
    ->name('albums.index');

Route::get('/albums/{album:url}', [AlbumController::class, 'show'])
    ->name('albums.show');

Route::post('/albums/{album:url}/access', [AlbumController::class, 'access'])
    ->name('albums.access');
    
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/albums/create', [AlbumController::class, 'create'])
        ->name('albums.create');


    Route::post('/dashboard/albums', [AlbumController::class, 'store'])
        ->name('albums.store');

    Route::get('/dashboard/albums/{album:url}/edit', [AlbumController::class, 'edit'])
        ->name('albums.edit');


    Route::put('/dashboard/albums/{album:url}', [AlbumController::class, 'update'])
        ->name('albums.update');

   
    Route::delete('/dashboard/albums/{album:url}', [AlbumController::class, 'destroy'])
        ->name('albums.destroy');

});

require __DIR__.'/auth.php';
