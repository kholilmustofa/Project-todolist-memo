<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MylistController; // Pastikan ini ada

Route::get('/', function () {
    return view('memo');
});

// Pindahkan rute /myday dan /allmytasks ke dalam grup middleware 'auth' dan 'verified'
Route::middleware(['auth', 'verified'])->group(function () {
    // Rute untuk halaman myday
    Route::get('/myday', [PageController::class, 'myday'])->name('myday');
    // Rute untuk halaman allmytasks
    Route::get('/allmytasks', [PageController::class, 'allmytasks'])->name('allmytasks');

    // Rute untuk mengelola profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk Task Anda
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::patch('/tasks/{task}', [TaskController::class, 'update']); // Rute PATCH untuk update status
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']); // Rute DELETE untuk menghapus task

    // Rute untuk My Lists
    Route::get('/mylists', [MylistController::class, 'index'])->name('mylists.index');
    Route::post('/mylists', [MylistController::class, 'store'])->name('mylists.store');
});

require __DIR__.'/auth.php';

