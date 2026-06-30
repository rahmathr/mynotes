<x-guest-layout>
    <div class="auth-card card p-4">

        {{-- logo dan judul --}}
        <div class="text-center mb-4">
            <div class="brand-name mb-1">
                <i class="bi bi-journal-richtext"></i> MyNotes
            </div>
            <p class="text-muted small mb-0">Buat akun baru</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- nama lengkap --}}
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">
                    Nama Lengkap
                </label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    placeholder="Nama kamu"
                    required
                    autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- email --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    placeholder="contoh@email.com"
                    required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- password --}}
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Minimal 8 karakter"
                    required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- konfirmasi password --}}
            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold">
                    Konfirmasi Password
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    placeholder="Ulangi password"
                    required>
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- tombol daftar --}}
            <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
                Daftar
            </button>

            {{-- link ke login --}}
            <div class="text-center mt-3">
                <small class="text-muted">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="link-ungu">
                        Masuk di sini
                    </a>
                </small>
            </div>

        </form>
    </div>
</x-guest-layout>
