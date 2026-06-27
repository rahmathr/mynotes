@extends('layouts.app')
@section('title', 'Edit Catatan')

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    #quill-editor {
        height: 300px;
        background: white;
        border-radius: 0 0 6px 6px;
    }

    .ql-toolbar {
        border-radius: 6px 6px 0 0;
        border-color: #dee2e6 !important;
    }

    .ql-container {
        border-color: #dee2e6 !important;
        font-size: 1rem;
    }

    .pilih-warna {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid #dee2e6;
        display: inline-block;
        transition: transform 0.2s;
    }

    .pilih-warna:hover {
        transform: scale(1.15);
    }

    .pilih-warna.aktif {
        border: 3px solid #6c63ff;
        transform: scale(1.15);
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card p-4">

            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('notes.show', $note) }}" class="btn btn-sm btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h5 class="fw-bold mb-0">Edit Catatan</h5>
                    <small class="text-muted">
                        Dibuat {{ $note->created_at->format('d M Y, H:i') }}
                    </small>
                </div>
            </div>

            <form action="{{ route('notes.update', $note) }}" method="POST" id="formEdit">
                @csrf
                @method('PUT')

                {{-- judul catatan --}}
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">
                        Judul <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           id="title"
                           class="form-control form-control-lg @error('title') is-invalid @enderror"
                           value="{{ old('title', $note->title) }}"
                           required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- pilih warna - yang dipilih sesuai warna catatan saat ini --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Warna Catatan</label>
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        <div class="pilih-warna" data-color="#ffffff" style="background:#ffffff;" title="Putih"></div>
                        <div class="pilih-warna" data-color="#fef9c3" style="background:#fef9c3;" title="Kuning"></div>
                        <div class="pilih-warna" data-color="#dcfce7" style="background:#dcfce7;" title="Hijau"></div>
                        <div class="pilih-warna" data-color="#dbeafe" style="background:#dbeafe;" title="Biru"></div>
                        <div class="pilih-warna" data-color="#fce7f3" style="background:#fce7f3;" title="Pink"></div>
                        <div class="pilih-warna" data-color="#ede9fe" style="background:#ede9fe;" title="Ungu"></div>
                        <div class="pilih-warna" data-color="#ffedd5" style="background:#ffedd5;" title="Orange"></div>
                        <div class="pilih-warna" data-color="#f3f4f6" style="background:#f3f4f6;" title="Abu-abu"></div>
                    </div>
                    <input type="hidden" name="color" id="colorInput" value="{{ old('color', $note->color) }}">
                    <div class="form-text">Warna sekarang ditandai dengan lingkaran ungu</div>
                </div>

                {{-- editor Quill --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Isi Catatan <span class="text-danger">*</span>
                    </label>

                    <div id="quill-editor"></div>
                    <input type="hidden" name="content" id="contentInput">

                    @error('content')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                @if($note->updated_at->isAfter($note->created_at))
                    <div class="alert alert-light border py-2 mb-3">
                        <small class="text-muted">
                            Terakhir diperbarui: {{ $note->updated_at->diffForHumans() }}
                        </small>
                    </div>
                @endif

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning px-5 text-white fw-semibold">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('notes.show', $note) }}" class="btn btn-outline-secondary">Batal</a>
                    <a href="{{ route('notes.history', $note) }}" class="btn btn-outline-secondary ms-auto">
                        <i class="bi bi-clock-history"></i> Riwayat
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['link'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['clean']
            ]
        }
    });

    // simpan nilai dari PHP ke variabel JS dulu
    // supaya tidak ada masalah parsing Blade
    var isiCatatan = {!! json_encode($note->content ?? '') !!};
    var warnaAktif = {!! json_encode($note->color ?? '#ffffff') !!};

    // load konten lama ke Quill
    quill.clipboard.dangerouslyPasteHTML(0, isiCatatan);

    // copy konten Quill ke hidden input sebelum submit
    document.getElementById('formEdit').addEventListener('submit', function () {
        document.getElementById('contentInput').value = quill.root.innerHTML;
    });

    // tandai warna yang sedang aktif
    document.querySelectorAll('.pilih-warna').forEach(function (el) {
        if (el.dataset.color === warnaAktif) {
            el.classList.add('aktif');
        }

        el.addEventListener('click', function () {
            document.querySelectorAll('.pilih-warna').forEach(function (c) {
                c.classList.remove('aktif');
            });
            this.classList.add('aktif');
            document.getElementById('colorInput').value = this.dataset.color;
        });
    });
</script>
@endpush
