<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| MYNOTES — Web Routes
|--------------------------------------------------------------------------
|
| Semua URL aplikasi didaftarkan di sini.
| Urutan penting: route tanpa auth dulu, baru route dengan auth.
|
*/

// ═══════════════════════════════════════════════════
//  PUBLIC ROUTES (bisa diakses tanpa login)
// ═══════════════════════════════════════════════════

// Halaman utama / Landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');


// ═══════════════════════════════════════════════════
//  PROTECTED ROUTES (harus login dulu)
//  middleware 'auth' = otomatis redirect ke /login
//  jika user belum login
// ═══════════════════════════════════════════════════

Route::middleware(['auth'])->group(function () {

    // ── Dashboard ──────────────────────────────────
    // URL: GET /dashboard → DashboardController@index
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');


    // ── Notes (Catatan) ────────────────────────────
    // Route::resource membuat 7 route sekaligus:
    //   GET    /notes              → index   (daftar catatan)
    //   GET    /notes/create       → create  (form buat baru)
    //   POST   /notes              → store   (simpan catatan baru)
    //   GET    /notes/{note}       → show    (detail catatan)
    //   GET    /notes/{note}/edit  → edit    (form edit)
    //   PUT    /notes/{note}       → update  (simpan perubahan)
    //   DELETE /notes/{note}       → destroy (hapus catatan)
    Route::resource('notes', NoteController::class);


    // ── Tasks (Tugas) ──────────────────────────────
    // except(['show']) = kita tidak membuat halaman detail tugas
    //   GET    /tasks              → index   (daftar tugas)
    //   GET    /tasks/create       → create  (form tambah tugas)
    //   POST   /tasks              → store   (simpan tugas baru)
    //   GET    /tasks/{task}/edit  → edit    (form edit tugas)
    //   PUT    /tasks/{task}       → update  (simpan perubahan)
    //   DELETE /tasks/{task}       → destroy (hapus tugas)
    Route::resource('tasks', TaskController::class)->except(['show']);

    // Route tambahan: tandai tugas sebagai selesai
    // URL: PATCH /tasks/{task}/complete → TaskController@complete
    Route::patch('tasks/{task}/complete', [TaskController::class, 'complete'])
         ->name('tasks.complete');

});


// ═══════════════════════════════════════════════════
//  AUTH ROUTES (Login, Register, Logout)
//  Di-generate otomatis oleh Laravel Breeze
//  Jangan hapus baris ini!
// ═══════════════════════════════════════════════════
require __DIR__ . '/auth.php';
