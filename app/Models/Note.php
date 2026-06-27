<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    // tambah 'color' ke fillable karena ada fitur tema warna baru
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'color',
    ];

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke riwayat perubahan
    // satu catatan bisa punya banyak riwayat
    public function histories()
    {
        return $this->hasMany(NoteHistory::class);
    }
}
