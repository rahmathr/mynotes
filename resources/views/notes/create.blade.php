@extends('layouts.app')
@section('title', 'Buat Catatan Baru')

{{-- load CSS Quill editor dari CDN --}}
@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    /* tinggi editor Quill */
    #quill-editor {
        height: 300px;
        background: white;
        border-radius: 0 0 6px 6px;
    }

    /* border editor biar konsisten sama Bootstrap */
    .ql-toolbar {
        border-radius: 6px 6px 0 0;
        border-color: #dee2e6 !important;
    }

    .ql-container {
        border-color: #dee2e6 !important;
        font-size: 1rem;
    }

    /* style untuk pilihan warna catatan */
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
                <a href="{{ route('notes.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h5 class="fw-bold mb-0">Buat Catatan Baru</h5>
                    <small class="text-muted">Tulis apapun yang ingin kamu catat</small>
                </div>
            </div>

            <form action="{{ route('notes.store') }}" method="POST" id="formCatatan">
                @csrf

                {{-- judul catatan --}}
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">
                        Judul <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           id="title"
                           class="form-control form-control-lg @error('title') is-invalid @enderror"
                           placeholder="Judul catatan..."
                           value="{{ old('title') }}"
                           autofocus
                           required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- pilih warna background catatan --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Warna Catatan</label>
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        {{-- daftar warna yang bisa dipilih --}}
                        <div class="pilih-warna aktif" data-color="#ffffff" style="background:#ffffff;" title="Putih"></div>
                        <div class="pilih-warna" data-color="#fef9c3" style="background:#fef9c3;" title="Kuning"></div>
                        <div class="pilih-warna" data-color="#dcfce7" style="background:#dcfce7;" title="Hijau"></div>
                        <div class="pilih-warna" data-color="#dbeafe" style="background:#dbeafe;" title="Biru"></div>
                        <div class="pilih-warna" data-color="#fce7f3" style="background:#fce7f3;" title="Pink"></div>
                        <div class="pilih-warna" data-color="#ede9fe" style="background:#ede9fe;" title="Ungu"></div>
                        <div class="pilih-warna" data-color="#ffedd5" style="background:#ffedd5;" title="Orange"></div>
                        <div class="pilih-warna" data-color="#f3f4f6" style="background:#f3f4f6;" title="Abu-abu"></div>
                    </div>
                    {{-- hidden input untuk nyimpen nilai warna yang dipilih --}}
                    <input type="hidden" name="color" id="colorInput" value="{{ old('color', '#ffffff') }}">
                    <div class="form-text">Klik untuk pilih warna latar belakang catatan</div>
                </div>

                {{-- isi catatan pakai Quill editor --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Isi Catatan <span class="text-danger">*</span>
                    </label>

                    {{-- div ini yang akan jadi editor Quill --}}
                    <div id="quill-editor"></div>

                    {{-- hidden input untuk nyimpen HTML dari Quill sebelum submit --}}
                    <input type="hidden" name="content" id="contentInput">

                    @error('content')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                    <div class="form-text mt-2">
                        Toolbar di atas mendukung: tebal, miring, garis bawah, coret, link, dan daftar
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-5">
                        Simpan Catatan
                    </button>
                    <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

{{-- load script Quill dan logika color picker --}}
@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    // inisialisasi Quill editor
    // 'snow' adalah tema yang punya toolbar di atas
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Tulis isi catatanmu di sini...',
        modules: {
            toolbar: [
                // bold, italic, underline, strike (coret)
                ['bold', 'italic', 'underline', 'strike'],

                // link - bisa tambahkan URL yang bisa diklik
                ['link'],

                // list berurutan dan tidak berurutan
                [{ list: 'ordered' }, { list: 'bullet' }],

                // hapus semua formatting
                ['clean']
            ]
        }
    });

    // kalau sebelumnya ada error validasi, load ulang konten yang sudah diketik
    @if(old('content'))
        quill.clipboard.dangerouslyPasteHTML(0, @json(old('content')));
    @endif

    // sebelum form dikirim, copy HTML dari Quill ke hidden input
    // karena Quill tidak pakai textarea biasa, kita harus lakukan ini manual
    document.getElementById('formCatatan').addEventListener('submit', function () {
        document.getElementById('contentInput').value = quill.root.innerHTML;
    });

    // logika pilih warna catatan
    document.querySelectorAll('.pilih-warna').forEach(function (el) {
        el.addEventListener('click', function () {
            // hapus class aktif dari semua warna
            document.querySelectorAll('.pilih-warna').forEach(function (c) {
                c.classList.remove('aktif');
            });

            // kasih class aktif ke warna yang dipilih
            this.classList.add('aktif');

            // simpan nilai warna ke hidden input
            document.getElementById('colorInput').value = this.dataset.color;
        });
    });
</script>
@endpush
