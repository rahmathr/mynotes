<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    /**
     * Kolom-kolom yang boleh diisi secara massal (mass assignment)
     * Wajib diisi agar tidak kena MassAssignmentException
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    /**
     * Relasi: Satu catatan dimiliki oleh satu user
     * Digunakan untuk: $note->user (mengambil data user pemilik catatan)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}