@extends('layouts.app')
@section('title', 'Edit Catatan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card p-4">

            {{-- ── Header ── --}}
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('notes.show', $note) }}"
                   class="btn btn-sm btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-pencil-square text-warning"></i> Edit Catatan
                    </h5>
                    <small class="text-muted">
                        Dibuat {{ $note->created_at->format('d M Y, H:i') }}
                    </small>
                </div>
            </div>

            {{-- ── Form Edit ── --}}
            {{-- action = route notes.update dengan ID catatan --}}
            {{-- method = POST, tapi kita pakai @method('PUT') agar Laravel tahu ini UPDATE --}}
            <form action="{{ route('notes.update', $note) }}" method="POST">
                @csrf
                @method('PUT') {{-- Wajib! Memberitahu Laravel bahwa ini request PUT (update) --}}

                {{-- Input Judul --}}
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">
                        Judul Catatan <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control form-control-lg @error('title') is-invalid @enderror"
                        value="{{ old('title', $note->title) }}"
                        required>
                    {{-- old('title', $note->title) = pakai nilai lama jika validasi gagal,
                         atau pakai nilai dari database jika pertama kali buka form --}}
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input Isi Catatan --}}
                <div class="mb-4">
                    <label for="content" class="form-label fw-semibold">
                        Isi Catatan <span class="text-danger">*</span>
                    </label>
                    <textarea
                        name="content"
                        id="content"
                        rows="12"
                        class="form-control @error('content') is-invalid @enderror"
                        required>{{ old('content', $note->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Info terakhir diperbarui --}}
                @if($note->updated_at->isAfter($note->created_at))
                    <div class="alert alert-light border py-2 mb-3">
                        <i class="bi bi-clock-history text-muted"></i>
                        <small class="text-muted">
                            Terakhir diperbarui: {{ $note->updated_at->diffForHumans() }}
                        </small>
                    </div>
                @endif

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning px-5 text-white fw-semibold">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('notes.show', $note) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
