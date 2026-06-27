@extends('layouts.app')
@section('title', 'Catatan Saya')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Catatan Saya</h4>
        <p class="text-muted mb-0">Kelola semua catatan pentingmu</p>
    </div>
    <a href="{{ route('notes.create') }}" class="btn btn-primary">
        Buat Catatan
    </a>
</div>

{{-- search bar --}}
<div class="card p-3 mb-4">
    <form action="{{ route('notes.index') }}" method="GET">
        <div class="input-group">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Cari catatan..."
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary px-4">Cari</button>
            @if(request('search'))
                <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </div>
    </form>
    @if(request('search'))
        <p class="text-muted small mb-0 mt-2">
            Hasil untuk: <strong>"{{ request('search') }}"</strong> - {{ $notes->total() }} ditemukan
        </p>
    @endif
</div>

{{-- daftar catatan --}}
@if($notes->count() > 0)
    <div class="row g-3">
        @foreach($notes as $note)
            <div class="col-md-4 col-sm-6">
                {{-- pakai warna background dari database --}}
                <div class="card h-100 p-3 position-relative"
                     style="background-color: {{ $note->color ?? '#ffffff' }};">

                    {{-- menu titik tiga --}}
                    <div class="dropdown position-absolute top-0 end-0 m-2">
                        <button class="btn btn-sm btn-light rounded-circle"
                                data-bs-toggle="dropdown"
                                style="width:32px; height:32px; opacity: 0.8;">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li>
                                <a class="dropdown-item" href="{{ route('notes.show', $note) }}">
                                    Lihat Detail
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('notes.edit', $note) }}">
                                    Edit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('notes.history', $note) }}">
                                    Riwayat Perubahan
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('notes.destroy', $note) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus catatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        Hapus
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <h6 class="fw-bold pe-4 mb-2">{{ $note->title }}</h6>

                    {{-- strip_tags() buat hapus HTML dari Quill supaya preview text bersih --}}
                    <p class="text-muted small mb-3">
                        {{ Str::limit(strip_tags($note->content), 100) }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <small class="text-muted">
                            {{ $note->created_at->diffForHumans() }}
                        </small>
                        <a href="{{ route('notes.show', $note) }}" class="btn btn-sm btn-outline-secondary">
                            Baca
                        </a>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $notes->withQueryString()->links() }}
    </div>

@else
    <div class="text-center py-5">
        <i class="bi bi-journal-x text-muted" style="font-size: 4rem;"></i>
        <h5 class="mt-3 text-muted">
            @if(request('search'))
                Tidak ditemukan catatan untuk "{{ request('search') }}"
            @else
                Belum ada catatan
            @endif
        </h5>
        <a href="{{ route('notes.create') }}" class="btn btn-primary mt-2">
            Buat Catatan Baru
        </a>
    </div>
@endif

@endsection
