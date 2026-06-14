@extends('layouts.app')
@section('title', 'Buat Catatan Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card p-4">

            {{-- ── Header ── --}}
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('notes.index') }}"
                   class="btn btn-sm btn-outline-secondary me-3"
                   title="Kembali">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-journal-plus text-primary"></i> Buat Catatan Baru
                    </h5>
                    <small class="text-muted">Tulis apapun yang ingin kamu catat</small>
                </div>
            </div>

            {{-- ── Form ── --}}
            {{-- action = URL tujuan saat form dikirim (route notes.store) --}}
            {{-- method = POST karena kita menyimpan data baru --}}
            <form action="{{ route('notes.store') }}" method="POST">
                {{-- @csrf wajib ada di setiap form POST agar Laravel tidak menolak request --}}
                @csrf

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
                        placeholder="Contoh: Meeting Notes, Ide Bisnis, dll..."
                        value="{{ old('title') }}"
                        autofocus
                        required>
                    {{-- Tampilkan pesan error validasi jika judul tidak valid --}}
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
                        placeholder="Tulis isi catatanmu di sini..."
                        required>{{ old('content') }}</textarea>
                    {{-- old('content') = isi ulang otomatis jika validasi gagal --}}
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        <i class="bi bi-info-circle"></i>
                        Gunakan Enter untuk pindah baris. Catatan tersimpan otomatis saat klik Simpan.
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="bi bi-save"></i> Simpan Catatan
                    </button>
                    <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
