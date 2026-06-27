<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // buat tabel note_histories untuk nyimpen riwayat perubahan catatan
    public function up(): void
    {
        Schema::create('note_histories', function (Blueprint $table) {
            $table->id();

            // relasi ke tabel notes - kalau note dihapus, history ikut terhapus
            $table->foreignId('note_id')->constrained()->onDelete('cascade');

            // relasi ke tabel users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // simpan judul dan isi catatan versi lama
            $table->string('title');
            $table->text('content');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('note_histories');
    }
};
