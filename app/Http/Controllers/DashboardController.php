<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * INDEX - Tampilkan halaman dashboard dengan statistik
     * URL: GET /dashboard
     */
    public function index()
    {
        $userId = Auth::id(); // ID user yang sedang login

        // ─── Hitung Statistik Notes ───────────────────────────────────
        $totalNotes = Note::where('user_id', $userId)->count();

        // ─── Hitung Statistik Tasks ───────────────────────────────────
        $totalTasks      = Task::where('user_id', $userId)->count();
        $completedTasks  = Task::where('user_id', $userId)->where('status', 'completed')->count();
        $pendingTasks    = Task::where('user_id', $userId)->where('status', 'pending')->count();
        $inProgressTasks = Task::where('user_id', $userId)->where('status', 'in_progress')->count();

        // ─── Hitung Persentase Progress ───────────────────────────────
        // Jika belum ada tugas, progress 0% (hindari pembagian dengan 0)
        $progressPercent = $totalTasks > 0
            ? round(($completedTasks / $totalTasks) * 100)
            : 0;

        // ─── Data Terbaru untuk Preview ───────────────────────────────
        $recentNotes = Note::where('user_id', $userId)->latest()->take(3)->get();
        $recentTasks = Task::where('user_id', $userId)->latest()->take(3)->get();

        // Kirim semua data ke view dashboard
        return view('dashboard', compact(
            'totalNotes',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'inProgressTasks',
            'progressPercent',
            'recentNotes',
            'recentTasks'
        ));
    }
}
