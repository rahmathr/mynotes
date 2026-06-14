<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyNotes — Kelola Catatan & Tugasmu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary: #6c63ff; --primary-dark: #5a52d5; }

        /* Navbar */
        .navbar-landing {
            background: rgba(108, 99, 255, 0.97);
            backdrop-filter: blur(10px);
        }

        /* Banner / Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        /* Lingkaran dekoratif di hero */
        .hero::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -200px;
            right: -200px;
        }
        .hero::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
        }

        /* Feature Cards */
        .feature-card {
            border: none;
            border-radius: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(108, 99, 255, 0.15);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        /* Comparison table */
        .comparison-table th { background: var(--primary); color: white; }
    </style>
</head>
<body>

    {{-- ══ NAVBAR ══════════════════════════════════════ --}}
    <nav class="navbar navbar-expand-lg navbar-dark navbar-landing fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="#">
                <i class="bi bi-journal-richtext"></i> MyNotes
            </a>
            <div class="ms-auto d-flex gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm fw-semibold">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-light btn-sm fw-semibold">
                        <i class="bi bi-person-plus"></i> Daftar Gratis
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ══ HERO / BANNER ════════════════════════════════ --}}
    <section class="hero text-white text-center pt-5">
        <div class="container position-relative" style="z-index: 1;">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="mb-4" style="font-size: 5rem; opacity: 0.9;">
                        <i class="bi bi-journal-richtext"></i>
                    </div>
                    <h1 class="display-3 fw-bold mb-3">
                        Satu Aplikasi<br>Untuk Semua Kebutuhanmu
                    </h1>
                    <p class="lead mb-5" style="opacity: 0.85;">
                        Catat ide, kelola tugas, pantau progress — semua dalam satu tempat.
                        Lebih produktif mulai hari ini.
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-5 fw-bold shadow">
                                <i class="bi bi-rocket-takeoff"></i> Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 fw-bold shadow">
                                <i class="bi bi-rocket-takeoff"></i> Mulai Gratis
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5">
                                <i class="bi bi-box-arrow-in-right"></i> Masuk
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        {{-- Wave bawah --}}
        <div style="position: absolute; bottom: 0; left: 0; width: 100%; overflow: hidden; line-height: 0;">
            <svg viewBox="0 0 1200 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
                 style="width:100%; height:60px;">
                <path d="M0,30 C300,60 900,0 1200,30 L1200,60 L0,60 Z" fill="#f0f2f5"/>
            </svg>
        </div>
    </section>

    {{-- ══ FITUR UNGGULAN ══════════════════════════════ --}}
    <section class="py-5" style="background: #f0f2f5;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Fitur Unggulan</h2>
                <p class="text-muted">Semua yang kamu butuhkan untuk produktivitas harian</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card p-4 h-100">
                        <div class="feature-icon bg-primary bg-opacity-10 text-primary mb-3">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <h5 class="fw-bold">📝 Manajemen Catatan</h5>
                        <p class="text-muted">Buat dan kelola catatan pentingmu dengan mudah. Dilengkapi fitur pencarian cepat untuk menemukan catatan kapan saja.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 h-100">
                        <div class="feature-icon bg-success bg-opacity-10 text-success mb-3">
                            <i class="bi bi-check2-square"></i>
                        </div>
                        <h5 class="fw-bold">✅ Task Management</h5>
                        <p class="text-muted">Kelola tugas dengan status Pending, In Progress, dan Selesai. Lengkap dengan deadline agar tidak ada yang terlewat.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 h-100">
                        <div class="feature-icon bg-warning bg-opacity-10 text-warning mb-3">
                            <i class="bi bi-bar-chart-line"></i>
                        </div>
                        <h5 class="fw-bold">📊 Progress Dashboard</h5>
                        <p class="text-muted">Pantau progress tugasmu dengan dashboard visual yang informatif. Lihat berapa persen pekerjaanmu sudah selesai.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- ══ CTA (Call to Action) ════════════════════════ --}}
    <section class="py-5 text-center" style="background: linear-gradient(135deg, #6c63ff, #5a52d5);">
        <div class="container text-white">
            <h2 class="fw-bold mb-3">Siap Jadi Lebih Produktif?</h2>
            <p class="lead mb-4" style="opacity: 0.85;">Daftar sekarang gratis dan mulai kelola hidupmu dengan lebih terorganisir</p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 fw-bold">
                    <i class="bi bi-rocket-takeoff"></i> Daftar Sekarang — Gratis!
                </a>
            @endguest
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
