<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyNotes — @yield('title', 'Kelola Catatan & Tugas')</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ── Warna utama ── */
        :root {
            --primary: #6c63ff;
            --primary-dark: #5a52d5;
        }

        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
        }

        /* ── Navbar ── */
        .navbar-custom {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            box-shadow: 0 2px 10px rgba(108, 99, 255, 0.3);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: -0.5px;
        }

        .nav-link.active {
            background: rgba(255,255,255,0.15) !important;
            border-radius: 8px;
        }

        /* ── Cards ── */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        /* ── Buttons ── */
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* ── Alert animasi ── */
        .alert {
            border: none;
            border-radius: 10px;
        }

        /* ── Pagination Bootstrap 5 ── */
        .pagination .page-link {
            border-radius: 8px !important;
            margin: 0 2px;
        }

        /* ── Footer ── */
        footer {
            margin-top: 3rem;
            padding: 1rem 0;
            text-align: center;
            color: #aaa;
            font-size: 0.85rem;
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- ══════════════════════════════════════════ --}}
    {{-- NAVBAR                                     --}}
    {{-- ══════════════════════════════════════════ --}}
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container">

            {{-- Logo / Brand --}}
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-journal-richtext"></i> MyNotes
            </a>

            {{-- Tombol hamburger untuk mobile --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">

                {{-- Menu kiri --}}
                <ul class="navbar-nav me-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('notes.*') ? 'active' : '' }}"
                           href="{{ route('notes.index') }}">
                            <i class="bi bi-journal-text"></i> Catatan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 {{ request()->routeIs('tasks.*') ? 'active' : '' }}"
                           href="{{ route('tasks.index') }}">
                            <i class="bi bi-check2-square"></i> Tugas
                        </a>
                    </li>
                </ul>

                {{-- Menu kanan: nama user & logout --}}
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li class="dropdown-header text-muted">
                                {{ Auth::user()->email }}
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                {{-- Form logout (harus POST, bukan GET) --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    {{-- END NAVBAR --}}

    {{-- ══════════════════════════════════════════ --}}
    {{-- KONTEN UTAMA                               --}}
    {{-- ══════════════════════════════════════════ --}}
    <main class="container py-4">

        {{-- Flash Message: Pesan sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Flash Message: Pesan error --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-circle-fill fs-5"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Konten halaman (diisi oleh masing-masing view) --}}
        @yield('content')

    </main>
    {{-- END KONTEN --}}

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Slot untuk script tambahan dari masing-masing view --}}
    @stack('scripts')

</body>
</html>
