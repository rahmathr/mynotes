<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * INDEX - Tampilkan daftar semua tugas milik user yang login
     * Bisa difilter berdasarkan status
     * URL: GET /tasks  atau  GET /tasks?status=pending
     */
    public function index(Request $request)
    {
        $query = Task::where('user_id', Auth::id());

        // Filter berdasarkan status jika ada di URL
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Urutkan dari yang terbaru, 10 per halaman
        $tasks = $query->latest()->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * CREATE - Tampilkan form tambah tugas baru
     * URL: GET /tasks/create
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * STORE - Simpan tugas baru ke database
     * URL: POST /tasks
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',                         // boleh kosong
            'deadline'    => 'nullable|date',                           // boleh kosong, harus format tanggal
            'status'      => 'required|in:pending,in_progress,completed', // harus salah satu dari 3 nilai ini
        ]);

        Task::create([
            'user_id'     => Auth::id(),
            'title'       => $request->title,
            'description' => $request->description,
            'deadline'    => $request->deadline,
            'status'      => $request->status,
        ]);

        return redirect()->route('tasks.index')
                         ->with('Berhasil untuk di selesaikan');
    }

    /**
     * EDIT - Tampilkan form edit tugas
     * URL: GET /tasks/{id}/edit
     */
    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak punya akses ke tugas ini.');
        }

        return view('tasks.edit', compact('task'));
    }

    /**
     * UPDATE - Simpan perubahan tugas ke database
     * URL: PUT /tasks/{id}
     */
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak punya akses ke tugas ini.');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline'    => 'nullable|date',
            'status'      => 'required|in:pending,in_progress,completed',
        ]);

        $task->update([
            'title'       => $request->title,
            'description' => $request->description,
            'deadline'    => $request->deadline,
            'status'      => $request->status,
        ]);

        return redirect()->route('tasks.index')
                         ->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * DESTROY - Hapus tugas dari database
     * URL: DELETE /tasks/{id}
     */
    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak punya akses ke tugas ini.');
        }

        $task->delete();

        return redirect()->route('tasks.index')
                         ->with('success', 'Tugas berhasil dihapus!');
    }

    /**
     * COMPLETE - Tandai tugas sebagai selesai (tombol cepat)
     * URL: PATCH /tasks/{id}/complete
     */
    public function complete(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak punya akses ke tugas ini.');
        }

        // Ubah status menjadi 'completed'
        $task->update(['status' => 'completed']);

        return redirect()->route('tasks.index')
                         ->with('success', 'Tugas berhasil ditandai selesai! 🎉');
    }
}
