@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- ── Sapaan ──────────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Halo, {{ Auth::user()->name }}!</h4>
        <p class="text-muted mb-0">Selamat datang kembali di MyNotes</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('notes.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus"></i> Catatan Baru
        </a>
        <a href="{{ route('tasks.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus"></i> Tugas Baru
        </a>
    </div>
</div>

{{-- ── 4 Stats Cards ────────────────────────────────────── --}}
<div class="row g-3 mb-4">

    {{-- Total Catatan --}}
    <div class="col-md-3 col-6">
        <div class="card p-3 text-white h-100"
             style="background: linear-gradient(135deg, #6c63ff, #5a52d5);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="small mb-1 opacity-75">Total Catatan</p>
                    <h2 class="fw-bold mb-0">{{ $totalNotes }}</h2>
                </div>
                <i class="bi bi-journal-text opacity-50" style="font-size: 2.2rem;"></i>
            </div>
            <a href="{{ route('notes.index') }}" class="text-white-50 small mt-2 text-decoration-none">
                Lihat semua →
            </a>
        </div>
    </div>

    {{-- Total Tugas --}}
    <div class="col-md-3 col-6">
        <div class="card p-3 text-white h-100"
             style="background: linear-gradient(135deg, #17a2b8, #117a8b);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="small mb-1 opacity-75">Total Tugas</p>
                    <h2 class="fw-bold mb-0">{{ $totalTasks }}</h2>
                </div>
                <i class="bi bi-list-task opacity-50" style="font-size: 2.2rem;"></i>
            </div>
            <a href="{{ route('tasks.index') }}" class="text-white-50 small mt-2 text-decoration-none">
                Lihat semua →
            </a>
        </div>
    </div>

    {{-- Tugas Selesai --}}
    <div class="col-md-3 col-6">
        <div class="card p-3 text-white h-100"
             style="background: linear-gradient(135deg, #28a745, #1e7e34);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="small mb-1 opacity-75">Tugas Selesai</p>
                    <h2 class="fw-bold mb-0">{{ $completedTasks }}</h2>
                </div>
                <i class="bi bi-check-circle opacity-50" style="font-size: 2.2rem;"></i>
            </div>
            <a href="{{ route('tasks.index', ['status' => 'completed']) }}"
               class="text-white-50 small mt-2 text-decoration-none">
                Lihat →
            </a>
        </div>
    </div>

    {{-- Belum Selesai --}}
    <div class="col-md-3 col-6">
        <div class="card p-3 text-white h-100"
             style="background: linear-gradient(135deg, #fd7e14, #e66000);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="small mb-1 opacity-75">Belum Selesai</p>
                    <h2 class="fw-bold mb-0">{{ $pendingTasks + $inProgressTasks }}</h2>
                </div>
                <i class="bi bi-clock-history opacity-50" style="font-size: 2.2rem;"></i>
            </div>
            <a href="{{ route('tasks.index', ['status' => 'pending']) }}"
               class="text-white-50 small mt-2 text-decoration-none">
                Lihat →
            </a>
        </div>
    </div>

</div>

{{-- ── Progress Bar ────────────────────────────────────── --}}
<div class="card p-4 mb-4">
    <h5 class="fw-bold mb-3">
        <i class="bi bi-bar-chart-line text-primary"></i> Progress Penyelesaian Tugas
    </h5>

    <div class="d-flex justify-content-between mb-2">
        <span class="text-muted">{{ $completedTasks }} dari {{ $totalTasks }} tugas selesai</span>
        <span class="fw-bold text-primary fs-5">{{ $progressPercent }}%</span>
    </div>

    <div class="progress mb-3" style="height: 22px; border-radius: 11px;">
        <div class="progress-bar bg-success fw-semibold"
             role="progressbar"
             style="width: {{ $progressPercent }}%; border-radius: 11px; transition: width 1s ease;"
             aria-valuenow="{{ $progressPercent }}"
             aria-valuemin="0"
             aria-valuemax="100">
            @if($progressPercent > 10){{ $progressPercent }}%@endif
        </div>
    </div>

    {{-- Badge status breakdown --}}
    <div class="d-flex gap-2 flex-wrap">
        <span class="badge bg-warning text-dark px-3 py-2">
            <i class="bi bi-hourglass-split"></i> Tertunda: {{ $pendingTasks }}
        </span>
        <span class="badge bg-info px-3 py-2">
            <i class="bi bi-arrow-clockwise"></i> Sedang berjalan: {{ $inProgressTasks }}
        </span>
        <span class="badge bg-success px-3 py-2">
            <i class="bi bi-check-circle"></i> Selesai: {{ $completedTasks }}
        </span>
    </div>
</div>

{{-- ── Catatan Terbaru & Tugas Terbaru ────────────────── --}}
<div class="row g-4">

    {{-- Catatan Terbaru --}}
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-journal-text text-primary"></i> Catatan Terbaru
                </h5>
                <a href="{{ route('notes.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>

            @forelse($recentNotes as $note)
                <a href="{{ route('notes.show', $note) }}" class="text-decoration-none text-dark">
                    <div class="border rounded-3 p-3 mb-2 hover-highlight">
                        <div class="d-flex justify-content-between align-items-start">
                            <span class="fw-semibold">{{ $note->title }}</span>
                            <small class="text-muted ms-2 text-nowrap">
                                {{ $note->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <p class="text-muted small mb-0 mt-1">
                            {{ Str::limit(strip_tags($note->content), 70) }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-journal-x" style="font-size: 2.5rem;"></i>
                    <p class="mt-2 mb-2">Belum ada catatan</p>
                    <a href="{{ route('notes.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus"></i> Buat Catatan
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Tugas Terbaru --}}
    <div class="col-md-6">
        <div class="card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-check2-square text-success"></i> Tugas Terbaru
                </h5>
                <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-success">Lihat Semua</a>
            </div>

            @forelse($recentTasks as $task)
                <div class="border rounded-3 p-3 mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold {{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                            {{ $task->title }}
                        </span>
                        <span class="badge bg-{{ $task->status_badge }}">{{ $task->status_label }}</span>
                    </div>
                    @if($task->deadline)
                        <small class="text-muted">
                            <i class="bi bi-calendar-event"></i>
                            {{ $task->deadline->format('d M Y') }}
                        </small>
                    @endif
                </div>
            @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-clipboard-x" style="font-size: 2.5rem;"></i>
                    <p class="mt-2 mb-2">Belum ada tugas</p>
                    <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-success">
                        <i class="bi bi-plus"></i> Tambah Tugas
                    </a>
                </div>
            @endforelse
        </div>
    </div>

</div>

@endsection
