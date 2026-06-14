<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * INDEX - Tampilkan daftar semua catatan milik user yang sedang login
     * URL: GET /notes
     */
    public function index(Request $request)
    {
        // Ambil catatan milik user yang login saja
        $query = Note::where('user_id', Auth::id());

        // Fitur Search: jika ada parameter 'search' di URL
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')   // cari di judul
                  ->orWhere('content', 'like', '%' . $search . '%'); // atau di isi
            });
        }

        // Ambil data terbaru dulu, tampilkan 9 per halaman
        $notes = $query->latest()->paginate(9);

        return view('notes.index', compact('notes'));
    }

    /**
     * CREATE - Tampilkan form buat catatan baru
     * URL: GET /notes/create
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * STORE - Simpan catatan baru ke database
     * URL: POST /notes
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'title'   => 'required|string|max:255',  // wajib, teks, maks 255 karakter
            'content' => 'required|string',           // wajib, teks
        ]);

        // Simpan catatan baru
        Note::create([
            'user_id' => Auth::id(),      // ID user yang sedang login
            'title'   => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        // Redirect ke halaman daftar catatan dengan pesan sukses
        return redirect()->route('notes.index')
                         ->with('success', 'Catatan berhasil dibuat!');
    }

    /**
     * SHOW - Tampilkan detail satu catatan
     * URL: GET /notes/{id}
     */
    public function show(Note $note)
    {
        // Cek apakah catatan ini milik user yang login
        // Jika bukan miliknya, tolak akses (403 Forbidden)
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak punya akses ke catatan ini.');
        }

        return view('notes.show', compact('note'));
    }

    /**
     * EDIT - Tampilkan form edit catatan
     * URL: GET /notes/{id}/edit
     */
    public function edit(Note $note)
    {
        // Pastikan catatan milik user yang login
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak punya akses ke catatan ini.');
        }

        return view('notes.edit', compact('note'));
    }

    /**
     * UPDATE - Simpan perubahan catatan ke database
     * URL: PUT /notes/{id}
     */
    public function update(Request $request, Note $note)
    {
        // Pastikan catatan milik user yang login
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak punya akses ke catatan ini.');
        }

        // Validasi input
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Update data catatan
        $note->update([
            'title'   => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        return redirect()->route('notes.index')
                         ->with('success', 'Catatan berhasil diperbarui!');
    }

    /**
     * DESTROY - Hapus catatan dari database
     * URL: DELETE /notes/{id}
     */
    public function destroy(Note $note)
    {
        // Pastikan catatan milik user yang login
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak punya akses ke catatan ini.');
        }

        $note->delete();

        return redirect()->route('notes.index')
                         ->with('success', 'Catatan berhasil dihapus!');
    }
}
