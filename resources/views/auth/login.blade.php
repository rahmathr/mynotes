<x-guest-layout>
    <div class="auth-card card p-4">

        {{-- logo dan judul --}}
        <div class="text-center mb-4">
            <div class="brand-name mb-1">
                <i class="bi bi-journal-richtext"></i> MyNotes
            </div>
            <p class="text-muted small mb-0">Masuk ke akunmu</p>
        </div>

        {{-- pesan status (misal setelah reset password) --}}
        @if (session('status'))
            <div class="alert alert-success py-2 small">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

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
                    required
                    autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- password --}}
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="password" class="form-label fw-semibold mb-0">
                        Password
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link-ungu small">
                            Lupa password?
                        </a>
                    @endif
                </div>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control mt-1 @error('password') is-invalid @enderror"
                    placeholder="Masukkan password"
                    required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- ingat saya --}}
            <div class="mb-4 form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label text-muted small">
                    Ingat saya
                </label>
            </div>

            {{-- tombol login --}}
            <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
                Masuk
            </button>

            {{-- link ke register --}}
            <div class="text-center mt-3">
                <small class="text-muted">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="link-ungu">
                        Daftar sekarang
                    </a>
                </small>
            </div>

        </form>
    </div>
</x-guest-layout>
