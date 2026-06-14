<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Kolom-kolom yang boleh diisi secara massal
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'deadline',
        'status',
    ];

    /**
     * Cast kolom deadline menjadi objek Carbon (date)
     * Sehingga bisa pakai: $task->deadline->format('d M Y')
     */
    protected $casts = [
        'deadline' => 'date',
    ];

    /**
     * Relasi: Satu tugas dimiliki oleh satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor: Mengembalikan warna badge Bootstrap sesuai status
     * Dipanggil di view sebagai: $task->status_badge
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'     => 'warning',
            'in_progress' => 'info',
            'completed'   => 'success',
            default       => 'secondary',
        };
    }

    /**
     * Accessor: Mengembalikan label Indonesia sesuai status
     * Dipanggil di view sebagai: $task->status_label
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'     => 'Pending',
            'in_progress' => 'In Progress',
            'completed'   => 'Selesai',
            default       => 'Unknown',
        };
    }
}
