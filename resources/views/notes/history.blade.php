@extends('layouts.app')
@section('title', 'Riwayat Perubahan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('notes.show', $note) }}" class="btn btn-sm btn-outline-secondary me-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h5 class="fw-bold mb-0">Riwayat Perubahan</h5>
                <small class="text-muted">{{ $note->title }}</small>
            </div>
        </div>

        {{-- versi aktif sekarang --}}
        <div class="card mb-3 border-primary">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Versi Sekarang</span>
                <small>{{ $note->updated_at->format('d M Y, H:i') }}</small>
            </div>
            <div class="card-body">
                <h6 class="fw-bold">{{ $note->title }}</h6>
                <div class="note-content text-muted small">
                    {!! $note->content !!}
                </div>
                <div class="mt-2">
                    <a href="{{ route('notes.edit', $note) }}" class="btn btn-sm btn-primary">Edit</a>
                </div>
            </div>
        </div>

        {{-- daftar riwayat versi lama --}}
        @if($histories->count() > 0)
            <p class="text-muted small mb-3">
                {{ $histories->count() }} riwayat perubahan ditemukan
            </p>

            {{-- accordion Bootstrap untuk tampilkan tiap versi --}}
            <div class="accordion" id="accordionHistory">
                @foreach($histories as $i => $history)
                    <div class="accordion-item mb-2 border rounded">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $i }}">
                                <div class="d-flex justify-content-between w-100 me-3">
                                    <span>{{ $history->title }}</span>
                                    <small class="text-muted fw-normal">
                                        {{ $history->created_at->format('d M Y, H:i') }}
                                        ({{ $history->created_at->diffForHumans() }})
                                    </small>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse{{ $i }}"
                             class="accordion-collapse collapse"
                             data-bs-parent="#accordionHistory">
                            <div class="accordion-body">
                                {{-- tampilkan isi versi lama dengan render HTML --}}
                                <div class="note-content border-start border-3 border-secondary ps-3">
                                    {!! $history->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            {{-- kalau belum pernah diedit --}}
            <div class="text-center py-5">
                <i class="bi bi-clock-history text-muted" style="font-size: 3rem;"></i>
                <p class="mt-3 fw-semibold text-muted">Belum ada riwayat perubahan</p>
                <small class="text-muted">
                    Riwayat akan muncul setelah catatan pertama kali diedit
                </small>
            </div>
        @endif

    </div>
</div>

<style>
    .note-content p { margin-bottom: 0.4rem; }
    .note-content ul, .note-content ol { padding-left: 1.5rem; }
    .note-content a { color: #6c63ff; }
    .note-content s { color: #9ca3af; }
</style>
@endsection
