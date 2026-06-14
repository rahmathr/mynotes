<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: membuat tabel notes di database
     */
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();                                                          // id bigint auto_increment (primary key)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');     // relasi ke tabel users (foreign key)
            $table->string('title');                                               // judul catatan (varchar 255)
            $table->text('content');                                               // isi catatan (text, bisa panjang)
            $table->timestamps();                                                  // created_at & updated_at (otomatis diisi Laravel)
        });
    }

    /**
     * Batalkan migration: hapus tabel notes dari database
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};