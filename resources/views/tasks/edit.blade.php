@extends('layouts.app')
@section('title', 'Edit Tugas')

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
                        <i class="bi bi-pencil-square text-warning"></i> Edit Tugas
                    </h5>
                    <small class="text-muted">
                        Dibuat {{ $task->created_at->format('d M Y') }}
                    </small>
                </div>
            </div>

            {{-- ── Form Edit ── --}}
            {{-- Gunakan @method('PUT') karena ini adalah update, bukan create --}}
            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT') {{-- Wajib! Memberitahu Laravel ini request UPDATE --}}

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
                        value="{{ old('title', $task->title) }}"
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
                        class="form-control @error('description') is-invalid @enderror">{{ old('description', $task->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deadline & Status --}}
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
                            value="{{ old('deadline', $task->deadline ? $task->deadline->format('Y-m-d') : '') }}">
                        {{-- $task->deadline->format('Y-m-d') = format yang diperlukan oleh input type="date" --}}
                        @error('deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Kosongkan untuk hapus deadline</div>
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
                            <option value="pending"
                                {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>
                                Tertunda
                            </option>
                            <option value="in_progress"
                                {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>
                                Sedang berjalan
                            </option>
                            <option value="completed"
                                {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- Info terakhir diperbarui --}}
                @if($task->updated_at->isAfter($task->created_at))
                    <div class="alert alert-light border py-2 mb-3">
                        <i class="bi bi-clock-history text-muted"></i>
                        <small class="text-muted">
                            Terakhir diperbarui: {{ $task->updated_at->diffForHumans() }}
                        </small>
                    </div>
                @endif

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning px-5 text-white fw-semibold">
                        <i class="bi bi-save"></i> Simpan Perubahan
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
