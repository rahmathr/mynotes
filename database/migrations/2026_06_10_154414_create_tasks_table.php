<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: membuat tabel tasks di database
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();                                                          // id bigint auto_increment (primary key)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');     // relasi ke tabel users (foreign key)
            $table->string('title');                                               // nama tugas (varchar 255)
            $table->text('description')->nullable();                               // deskripsi tugas (boleh kosong / null)
            $table->date('deadline')->nullable();                                  // tanggal deadline (boleh kosong / null)
            $table->enum('status', ['pending', 'in_progress', 'completed'])       // status tugas (hanya 3 nilai ini yang boleh)
                  ->default('pending');                                            // nilai default jika tidak diisi: pending
            $table->timestamps();                                                  // created_at & updated_at (otomatis)
        });
    }

    /**
     * Batalkan migration: hapus tabel tasks dari database
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};