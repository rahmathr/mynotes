<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // tambah kolom color ke tabel notes yang sudah ada
    public function up(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            // kolom color untuk nyimpen warna background catatan
            // defaultnya putih, panjang max 7 karakter (#ffffff)
            $table->string('color', 7)->default('#ffffff')->after('content');
        });
    }

    // kalau di-rollback, hapus kolom color
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn('color');
        });
    }
};
