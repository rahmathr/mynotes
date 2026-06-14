@extends('layouts.app')
@section('title', 'Catatan Saya')

@section('content')

{{-- ── Header ──────────────────────────────────────────── --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">
            <i class="bi bi-journal-text text-primary"></i> Catatan Saya
        </h4>
        <p class="text-muted mb-0">
            Kelola semua catatan pentingmu
        </p>
    </div>
    <a href="{{ route('notes.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Buat Catatan
    </a>
</div>

{{-- ── Search Bar ───────────────────────────────────────── --}}
<div class="card p-3 mb-4">
    <form action="{{ route('notes.index') }}" method="GET">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text"
                   name="search"
                   class="form-control border-start-0 ps-0"
                   placeholder="Cari catatan berdasarkan judul atau isi..."
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary px-4">Cari</button>
            @if(request('search'))
                <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i> Reset
                </a>
            @endif
        </div>
    </form>

    @if(request('search'))
        <p class="text-muted small mb-0 mt-2">
            Hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
            — {{ $notes->total() }} catatan ditemukan
        </p>
    @endif
</div>

{{-- ── Daftar Catatan ─────────────────────────────────── --}}
@if($notes->count() > 0)

    <div class="row g-3">
        @foreach($notes as $note)
            <div class="col-md-4 col-sm-6">
                <div class="card h-100 p-3 position-relative">

                    {{-- Menu titik tiga ─────── --}}
                    <div class="dropdown position-absolute top-0 end-0 m-2">
                        <button class="btn btn-sm btn-light rounded-circle"
                                data-bs-toggle="dropdown"
                                style="width:32px; height:32px;">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li>
                                <a class="dropdown-item" href="{{ route('notes.show', $note) }}">
                                    <i class="bi bi-eye text-info"></i> Lihat Detail
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('notes.edit', $note) }}">
                                    <i class="bi bi-pencil text-warning"></i> Edit
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                {{-- Form Delete ─── --}}
                                <form action="{{ route('notes.destroy', $note) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus catatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    {{-- End Menu ─────────────── --}}

                    {{-- Judul catatan --}}
                    <h6 class="fw-bold pe-4 mb-2">{{ $note->title }}</h6>

                    {{-- Preview isi catatan (dibatasi 100 karakter) --}}
                    <p class="text-muted small mb-3" style="flex: 1;">
                        {{ Str::limit($note->content, 100) }}
                    </p>

                    {{-- Footer card --}}
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <small class="text-muted">
                            <i class="bi bi-clock"></i>
                            {{ $note->created_at->diffForHumans() }}
                        </small>
                        <a href="{{ route('notes.show', $note) }}"
                           class="btn btn-sm btn-outline-primary">
                            Baca →
                        </a>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $notes->withQueryString()->links() }}
    </div>

@else

    {{-- Empty State --}}
    <div class="text-center py-5">
        <i class="bi bi-journal-x text-muted" style="font-size: 4rem;"></i>
        <h5 class="mt-3 fw-bold text-muted">
            @if(request('search'))
                Catatan "<em>{{ request('search') }}</em>" tidak ditemukan
            @else
                Kamu belum punya catatan
            @endif
        </h5>
        <p class="text-muted mb-3">
            @if(request('search'))
                Coba kata kunci lain atau buat catatan baru
            @else
                Yuk, mulai tulis catatan pertamamu!
            @endif
        </p>
        <a href="{{ route('notes.create') }}" class="btn btn-primary px-4">
            <i class="bi bi-plus-circle"></i> Buat Catatan Baru
        </a>
    </div>

@endif

@endsection
