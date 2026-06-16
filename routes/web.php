<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\DashboardController;
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

Route::get('/photos', [PhotoController::class, 'index'])
    ->name('photos.index');

Route::middleware('auth')->group(function () {

    Route::get('/photos/create', [PhotoController::class, 'create'])
        ->name('photos.create');

    Route::get('/photos/bulk-create', [PhotoController::class, 'bulkCreate'])
        ->name('photos.bulk-create');

    Route::post('/photos', [PhotoController::class, 'store'])
        ->name('photos.store');

    Route::post('/photos/bulk-store', [PhotoController::class, 'bulkStore'])
        ->name('photos.bulk-store');
    Route::delete('/photos/bulk-delete',[PhotoController::class, 'bulkDelete'])
        ->name('photos.bulk-delete');
    Route::post('/photos/bulk-move',[PhotoController::class, 'bulkMove'] )
        ->name('photos.bulk-move');

    Route::get('/photos/{photo}/edit', [PhotoController::class, 'edit'])
        ->name('photos.edit');

    Route::put('/photos/{photo}', [PhotoController::class, 'update'])
        ->name('photos.update');

    Route::delete('/photos/{photo}', [PhotoController::class, 'destroy'])
        ->name('photos.destroy');
    Route::delete('/photos/{photo}/force', [PhotoController::class, 'forceDestroy'])
        ->name('photos.forceDestroy');

});

Route::get('/photos/{photo}', [PhotoController::class, 'show'])
    ->name('photos.show');
//pedidos
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');

//usuarios
Route::middleware(['auth'])->group(function () {
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

Route::middleware('auth')->group(function () {
    Route::get('/albums/create', [AlbumController::class, 'create'])
    ->name('albums.create');
    
    
    Route::post('/albums', [AlbumController::class, 'store'])
    ->name('albums.store');
    
    Route::get('/albums/{album:url}/edit', [AlbumController::class, 'edit'])
    ->name('albums.edit');
    
    
    Route::put('/albums/{album:url}', [AlbumController::class, 'update'])
    ->name('albums.update');
    
    
    Route::delete('/albums/{album:url}', [AlbumController::class, 'destroy'])
    ->name('albums.destroy');
    Route::post('/albums/ajax', [AlbumController::class, 'ajaxStore'])
    ->middleware('auth')
    ->name('albums.ajax.store');
    
    });
    
    Route::get('/albums', [AlbumController::class, 'index'])
        ->name('albums.index');
    
    Route::get('/albums/{album}', [AlbumController::class, 'show'])
        ->name('albums.show');
    
    Route::post('/albums/{album:url}/access', [AlbumController::class, 'access'])
        ->name('albums.access');

Route::post('/albums/{album}/access', [AlbumController::class, 'access'])->name('albums.access');

//dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/dashboard/photos', [DashboardController::class, 'photos'])
        ->name('dashboard.photos');
    Route::get('/dashboard/albums', [DashboardController::class, 'albums'])
        ->name('dashboard.albums');
    Route::get('/dashboard/orders', [DashboardController::class, 'orders'])
        ->name('dashboard.orders');
    
});

Route::get('/phpinfo', function () {
    phpinfo();
});
require __DIR__.'/auth.php';
