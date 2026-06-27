@extends('layouts.app')
@section('title', $note->title)

@push('styles')
<style>
    /* styling untuk konten HTML dari Quill supaya tampil rapi */
    .note-content p { margin-bottom: 0.5rem; }
    .note-content ul, .note-content ol { padding-left: 1.5rem; }
    .note-content a { color: #6c63ff; }
    .note-content a:hover { text-decoration: underline; }
    .note-content s { color: #9ca3af; }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- kartu detail catatan dengan warna background dari database --}}
        <div class="card p-4" style="background-color: {{ $note->color ?? '#ffffff' }};">

            <div class="d-flex justify-content-between align-items-start mb-3">

                <div class="d-flex align-items-start">
                    <a href="{{ route('notes.index') }}" class="btn btn-sm btn-outline-secondary me-3 mt-1">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h4 class="fw-bold mb-1">{{ $note->title }}</h4>
                        <div class="d-flex gap-3 text-muted small flex-wrap">
                            <span>
                                Dibuat {{ $note->created_at->format('d M Y, H:i') }}
                            </span>
                            @if($note->updated_at->isAfter($note->created_at))
                                <span>
                                    Diedit {{ $note->updated_at->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 ms-2">
                    <a href="{{ route('notes.edit', $note) }}" class="btn btn-warning btn-sm text-white">
                        Edit
                    </a>
                    <a href="{{ route('notes.history', $note) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-clock-history"></i>
                    </a>
                    <form action="{{ route('notes.destroy', $note) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus catatan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </div>

            </div>

            <hr class="my-3">

            {{--
                PENTING: pakai {!! !!} bukan {{ }} untuk tampilkan HTML dari Quill
                {{ }} akan escape HTML jadi tampil sebagai teks biasa
                {!! !!} render HTML sebenarnya supaya formatting, link, dll tampil dengan benar
                Ini aman karena konten diisi oleh user sendiri (bukan dari luar)
            --}}
            <div class="note-content" style="line-height: 1.9; font-size: 1rem;">
                {!! $note->content !!}
            </div>

        </div>

        <div class="d-flex justify-content-between mt-3">
            <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary btn-sm">
                Kembali ke Daftar
            </a>
            <a href="{{ route('notes.create') }}" class="btn btn-primary btn-sm">
                Buat Catatan Baru
            </a>
        </div>

    </div>
</div>
@endsection
