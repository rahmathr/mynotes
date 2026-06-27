<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteHistory extends Model
{
    // kolom yang boleh diisi
    protected $fillable = [
        'note_id',
        'user_id',
        'title',
        'content',
    ];

    // relasi ke note
    public function note()
    {
        return $this->belongsTo(Note::class);
    }

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
