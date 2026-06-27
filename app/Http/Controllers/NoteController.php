<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\NoteHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    // tampilkan daftar catatan + fitur search
    public function index(Request $request)
    {
        $query = Note::where('user_id', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        $notes = $query->latest()->paginate(9);

        return view('notes.index', compact('notes'));
    }

    // tampilkan form buat catatan baru
    public function create()
    {
        return view('notes.create');
    }

    // simpan catatan baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        // cek konten tidak kosong setelah strip HTML dari Quill editor
        $isiCatatan = strip_tags($request->input('content', ''));
        if (empty(trim($isiCatatan))) {
            return back()->withErrors(['content' => 'Isi catatan tidak boleh kosong'])->withInput();
        }

        Note::create([
            'user_id' => Auth::id(),
            'title'   => $request->title,
            'content' => $request->input('content'),
            'color'   => $request->input('color', '#ffffff'),
        ]);

        return redirect()->route('notes.index')
                         ->with('success', 'Catatan berhasil dibuat!');
    }

    // tampilkan detail catatan
    public function show(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        return view('notes.show', compact('note'));
    }

    // tampilkan form edit catatan
    public function edit(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        return view('notes.edit', compact('note'));
    }

    // simpan perubahan catatan + otomatis simpan versi lama ke history
    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        // cek konten tidak kosong
        $isiCatatan = strip_tags($request->input('content', ''));
        if (empty(trim($isiCatatan))) {
            return back()->withErrors(['content' => 'Isi catatan tidak boleh kosong'])->withInput();
        }

        // simpan versi lama ke tabel note_histories dulu
        // supaya bisa dilihat lagi nanti kalau mau
        NoteHistory::create([
            'note_id' => $note->id,
            'user_id' => Auth::id(),
            'title'   => $note->title,
            'content' => $note->content,
        ]);

        // baru update ke versi baru
        $note->update([
            'title'   => $request->title,
            'content' => $request->input('content'),
            'color'   => $request->input('color', $note->color),
        ]);

        return redirect()->route('notes.index')
                         ->with('success', 'Catatan berhasil diperbarui!');
    }

    // hapus catatan
    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $note->delete();

        return redirect()->route('notes.index')
                         ->with('success', 'Catatan berhasil dihapus!');
    }

    // tampilkan riwayat perubahan catatan
    public function history(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        // ambil semua riwayat, paling baru ditampilkan duluan
        $histories = $note->histories()->latest()->get();

        return view('notes.history', compact('note', 'histories'));
    }
}
