<div align="center">

<img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
<img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
<img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
<img src="https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">

# 📝 MyNotes

**Aplikasi web sederhana berbasis Laravel untuk mengelola catatan dan tugas harian.**  
Modern · Responsif · Personal

</div>

---

## ✨ Fitur Utama

| Modul | Fitur |
|-------|-------|
| 📒 **Catatan** | Tambah, edit, hapus catatan · Pencarian berdasarkan judul/isi · Daftar catatan terbaru |
| ✅ **Tugas** | Tambah, edit, hapus tugas · Status: Pending / In Progress / Selesai · Filter status · Deadline opsional |
| 📊 **Dashboard** | Statistik total catatan & tugas · Progress penyelesaian · Ringkasan terbaru |
| 👤 **Autentikasi** | Registrasi & login · Logout · Data terpisah per pengguna |

---

## 🖼️ Tampilan Aplikasi

| Dashboard | Catatan | Tugas |
|-----------|---------|-------|
| ![Dashboard](screenshots/dashboard.png) | ![Catatan](screenshots/catatan.png) | ![Tugas](screenshots/tugas.png) |

> Lihat juga: [Form Tambah Catatan](screenshots/tambah-catatan.png) · [Form Tambah Tugas](screenshots/tambah-tugas.png)

---

## 🛠️ Teknologi

- **Framework** — Laravel (PHP)
- **Database** — MySQL
- **Frontend** — Bootstrap 5 · Blade Template Engine · Font Awesome

---

## 📦 Instalasi

### Prasyarat
Pastikan sudah terinstall: `PHP >= 8.x`, `Composer`, `MySQL`

### Langkah-langkah

**1. Clone repository**
```bash
git clone https://github.com/username/mynotes.git
cd mynotes
```

**2. Install dependency**
```bash
composer install
```

**3. Salin file environment**
```bash
cp .env.example .env
```

**4. Generate application key**
```bash
php artisan key:generate
```

**5. Konfigurasi database**

Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mynotes
DB_USERNAME=root
DB_PASSWORD=
```

**6. Jalankan migrasi**
```bash
php artisan migrate
```

**7. Jalankan server**
```bash
php artisan serve
```

Akses aplikasi di: **http://127.0.0.1:8000**

---

## 🚀 Penggunaan

<details>
<summary><strong>📒 Membuat Catatan</strong></summary>

1. Login ke aplikasi
2. Klik menu **Catatan**
3. Klik **Buat Catatan**
4. Isi judul dan isi catatan
5. Klik **Simpan Catatan**

</details>

<details>
<summary><strong>✅ Membuat Tugas</strong></summary>

1. Klik menu **Tugas**
2. Klik **Tambah Tugas**
3. Isi nama tugas
4. Pilih status tugas
5. Tentukan deadline *(opsional)*
6. Klik **Simpan Tugas**

</details>

---

## 📂 Struktur Proyek

```
app/
├── Models/
│   ├── Note.php
│   ├── Task.php
│   └── User.php
│
└── Http/Controllers/
    ├── DashboardController.php
    ├── NoteController.php
    └── TaskController.php

resources/views/
├── dashboard/
├── notes/
├── tasks/
└── layouts/
```

---

## 🎯 Tujuan Pembelajaran

Project ini dibuat sebagai implementasi nyata dari:

- ✅ Laravel MVC Architecture
- ✅ Authentication (Login, Register, Logout)
- ✅ CRUD — Create, Read, Update, Delete
- ✅ Relasi Database (One-to-Many)
- ✅ Query Builder & Eloquent ORM
- ✅ Dashboard Statistik
- ✅ UI Responsif dengan Bootstrap 5

---

## 👨‍💻 Developer

**Izza Adian Ahmad**  
Mahasiswa Teknologi Informasi yang sedang belajar pengembangan aplikasi web menggunakan Laravel.

---

## 📄 Lisensi

Project ini dibuat untuk kebutuhan pembelajaran dan pengembangan pribadi.