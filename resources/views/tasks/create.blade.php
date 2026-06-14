@extends('layouts.app')
@section('title', 'Tambah Tugas Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card p-4">

            {{-- ── Header ── --}}
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('tasks.index') }}"
                   class="btn btn-sm btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-plus-circle text-success"></i> Tambah Tugas Baru
                    </h5>
                    <small class="text-muted">Isi detail tugas yang ingin ditambahkan</small>
                </div>
            </div>

            {{-- ── Form ── --}}
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf

                {{-- Nama Tugas --}}
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">
                        Nama Tugas <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control form-control-lg @error('title') is-invalid @enderror"
                        placeholder="Contoh: Buat laporan mingguan, Belajar Laravel, dll..."
                        value="{{ old('title') }}"
                        autofocus
                        required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">
                        Deskripsi
                        <span class="text-muted fw-normal">(opsional)</span>
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        rows="4"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Tambahkan detail atau catatan untuk tugas ini...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deadline & Status (dalam 1 baris) --}}
                <div class="row mb-4">

                    {{-- Deadline --}}
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="deadline" class="form-label fw-semibold">
                            Deadline
                            <span class="text-muted fw-normal">(opsional)</span>
                        </label>
                        <input
                            type="date"
                            name="deadline"
                            id="deadline"
                            class="form-control @error('deadline') is-invalid @enderror"
                            value="{{ old('deadline') }}"
                            min="{{ date('Y-m-d') }}">
                        {{-- min="{{ date('Y-m-d') }}" agar tidak bisa pilih tanggal lampau --}}
                        @error('deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Kosongkan jika tidak ada deadline</div>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label for="status" class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select
                            name="status"
                            id="status"
                            class="form-select @error('status') is-invalid @enderror"
                            required>
                            <option value="" disabled selected>── Pilih Status ──</option>
                            <option value="pending"
                                {{ old('status') === 'pending' ? 'selected' : '' }}>
                                ⏳ Pending
                            </option>
                            <option value="in_progress"
                                {{ old('status') === 'in_progress' ? 'selected' : '' }}>
                                🔄 In Progress
                            </option>
                            <option value="completed"
                                {{ old('status') === 'completed' ? 'selected' : '' }}>
                                ✅ Selesai
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success px-5 fw-semibold">
                        <i class="bi bi-save"></i> Simpan Tugas
                    </button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
