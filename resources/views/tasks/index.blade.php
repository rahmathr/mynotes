@extends('layouts.app')
@section('title', 'Tugas Saya')

@section('content')

{{-- ── Header ──────────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="bi bi-check2-square text-success"></i> Tugas Saya
        </h4>
        <p class="text-muted mb-0">Kelola dan pantau semua tugasmu</p>
    </div>
    <a href="{{ route('tasks.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Tambah Tugas
    </a>
</div>

{{-- ── Filter Status ────────────────────────────────────── --}}
<div class="card p-3 mb-4">
    <div class="d-flex gap-2 flex-wrap align-items-center">
        <span class="text-muted small me-1">Filter:</span>

        <a href="{{ route('tasks.index') }}"
           class="btn btn-sm {{ !request('status') ? 'btn-dark' : 'btn-outline-dark' }}">
            <i class="bi bi-grid-3x3-gap"></i> Semua
        </a>

        <a href="{{ route('tasks.index', ['status' => 'pending']) }}"
           class="btn btn-sm {{ request('status') === 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
            <i class="bi bi-hourglass-split"></i> Pending
        </a>

        <a href="{{ route('tasks.index', ['status' => 'in_progress']) }}"
           class="btn btn-sm {{ request('status') === 'in_progress' ? 'btn-info text-white' : 'btn-outline-info' }}">
            <i class="bi bi-arrow-clockwise"></i> In Progress
        </a>

        <a href="{{ route('tasks.index', ['status' => 'completed']) }}"
           class="btn btn-sm {{ request('status') === 'completed' ? 'btn-success' : 'btn-outline-success' }}">
            <i class="bi bi-check-circle"></i> Selesai
        </a>

        {{-- Info jumlah hasil filter --}}
        <span class="ms-auto text-muted small">
            {{ $tasks->total() }} tugas ditemukan
        </span>
    </div>
</div>

{{-- ── Daftar Tugas ─────────────────────────────────────── --}}
@if($tasks->count() > 0)

    <div class="d-flex flex-column gap-2 mb-4">
        @foreach($tasks as $task)
            <div class="card p-3
                {{ $task->status === 'completed' ? 'border-success border-opacity-25 bg-success bg-opacity-10' : '' }}">

                <div class="row align-items-center g-2">

                    {{-- Kolom kiri: ikon status + nama tugas --}}
                    <div class="col-md-5">
                        <div class="d-flex align-items-center gap-3">

                            {{-- Ikon berdasarkan status --}}
                            @if($task->status === 'completed')
                                <i class="bi bi-check-circle-fill text-success fs-4"></i>
                            @elseif($task->status === 'in_progress')
                                <i class="bi bi-arrow-clockwise text-info fs-4"></i>
                            @else
                                <i class="bi bi-circle text-warning fs-4"></i>
                            @endif

                            <div>
                                {{-- Judul tugas (coretan jika selesai) --}}
                                <p class="fw-semibold mb-0 {{ $task->status === 'completed' ? 'text-decoration-line-through text-success' : '' }}">
                                    {{ $task->title }}
                                </p>
                                {{-- Deskripsi singkat --}}
                                @if($task->description)
                                    <small class="text-muted">
                                        {{ Str::limit($task->description, 60) }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Kolom tengah: badge status + deadline --}}
                    <div class="col-md-4">
                        <div class="d-flex flex-column gap-1">

                            {{-- Badge status berwarna --}}
                            <span class="badge bg-{{ $task->status_badge }} px-3 py-1 w-auto d-inline-block"
                                  style="width: fit-content;">
                                {{ $task->status_label }}
                            </span>

                            {{-- Deadline dengan peringatan jika terlambat --}}
                            @if($task->deadline)
                                <small class="{{ $task->deadline->isPast() && $task->status !== 'completed' ? 'text-danger fw-semibold' : 'text-muted' }}">
                                    <i class="bi bi-calendar-event"></i>
                                    Deadline: {{ $task->deadline->format('d M Y') }}
                                    @if($task->deadline->isPast() && $task->status !== 'completed')
                                        <span class="badge bg-danger ms-1">Terlambat!</span>
                                    @elseif($task->deadline->isToday() && $task->status !== 'completed')
                                        <span class="badge bg-warning text-dark ms-1">Hari ini!</span>
                                    @endif
                                </small>
                            @endif

                        </div>
                    </div>

                    {{-- Kolom kanan: tombol aksi --}}
                    <div class="col-md-3">
                        <div class="d-flex gap-1 justify-content-md-end flex-wrap">

                            {{-- Tombol Tandai Selesai (hanya tampil jika belum selesai) --}}
                            @if($task->status !== 'completed')
                                <form action="{{ route('tasks.complete', $task) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="btn btn-success btn-sm"
                                            title="Tandai sebagai selesai"
                                            onclick="return confirm('Tandai tugas ini sebagai selesai?')">
                                        <i class="bi bi-check-lg"></i> Selesai
                                    </button>
                                </form>
                            @endif

                            {{-- Tombol Edit --}}
                            <a href="{{ route('tasks.edit', $task) }}"
                               class="btn btn-warning btn-sm text-white"
                               title="Edit tugas">
                                <i class="bi bi-pencil"></i>
                            </a>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus tugas">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination (withQueryString() agar filter status tetap ada di halaman berikutnya) --}}
    {{ $tasks->withQueryString()->links() }}

@else

    {{-- Empty State --}}
    <div class="text-center py-5">
        <i class="bi bi-clipboard-x text-muted" style="font-size: 4rem;"></i>
        <h5 class="mt-3 fw-bold text-muted">
            @if(request('status'))
                Tidak ada tugas dengan status
                <span class="text-capitalize">{{ str_replace('_', ' ', request('status')) }}</span>
            @else
                Kamu belum punya tugas
            @endif
        </h5>
        <p class="text-muted mb-3">
            @if(request('status'))
                Coba filter lain atau tambah tugas baru
            @else
                Mulai tambahkan tugasmu sekarang!
            @endif
        </p>
        <a href="{{ route('tasks.create') }}" class="btn btn-success px-4">
            <i class="bi bi-plus-circle"></i> Tambah Tugas Baru
        </a>
    </div>

@endif

@endsection
