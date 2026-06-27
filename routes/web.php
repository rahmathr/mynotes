<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// halaman utama
Route::get('/', function () {
    return view('welcome');
})->name('home');

// semua route di bawah ini hanya bisa diakses kalau sudah login
Route::middleware(['auth'])->group(function () {

    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // route resource notes (7 route sekaligus: index, create, store, show, edit, update, destroy)
    Route::resource('notes', NoteController::class);

    // route tambahan untuk riwayat perubahan catatan
    // harus ditulis sebelum Route::resource kalau mau aman, tapi di sini tidak masalah
    Route::get('notes/{note}/history', [NoteController::class, 'history'])->name('notes.history');

    // route resource tasks
    Route::resource('tasks', TaskController::class)->except(['show']);

    // route untuk tandai tugas selesai
    Route::patch('tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');

});

require __DIR__ . '/auth.php';
