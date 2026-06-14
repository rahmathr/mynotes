@extends('layouts.app')
@section('title', $note->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- ── Card Detail Catatan ── --}}
        <div class="card p-4">

            {{-- ── Header: Tombol navigasi + judul --}}
            <div class="d-flex justify-content-between align-items-start mb-3">

                {{-- Kiri: Tombol back + judul --}}
                <div class="d-flex align-items-start">
                    <a href="{{ route('notes.index') }}"
                       class="btn btn-sm btn-outline-secondary me-3 mt-1">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h4 class="fw-bold mb-1">{{ $note->title }}</h4>
                        <div class="d-flex gap-3 text-muted small">
                            <span>
                                <i class="bi bi-calendar-plus"></i>
                                Dibuat {{ $note->created_at->format('d M Y, H:i') }}
                            </span>
                            @if($note->updated_at->isAfter($note->created_at))
                                <span>
                                    <i class="bi bi-pencil"></i>
                                    Diperbarui {{ $note->updated_at->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Kanan: Tombol Edit & Hapus --}}
                <div class="d-flex gap-2 ms-3">
                    <a href="{{ route('notes.edit', $note) }}"
                       class="btn btn-warning btn-sm text-white">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    {{-- Form delete (harus pakai @method DELETE) --}}
                    <form action="{{ route('notes.destroy', $note) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus catatan ini? Tindakan ini tidak bisa dibatalkan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </div>

            </div>

            <hr class="my-3">

            {{-- ── Isi Catatan ── --}}
            {{-- white-space: pre-wrap = mempertahankan enter/spasi dari textarea --}}
            <div class="note-body" style="line-height: 1.9; white-space: pre-wrap; font-size: 1rem;">
                {{ $note->content }}
            </div>

        </div>

        {{-- ── Navigasi bawah ── --}}
        <div class="d-flex justify-content-between mt-3">
            <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
            </a>
            <a href="{{ route('notes.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Buat Catatan Baru
            </a>
        </div>

    </div>
</div>
@endsection
