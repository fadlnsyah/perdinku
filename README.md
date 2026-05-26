# PerdinKu

PerdinKu adalah aplikasi web Laravel untuk pengelolaan perjalanan dinas pegawai perusahaan. Aplikasi ini mencakup pengajuan perjalanan dinas oleh pegawai, proses approve/reject oleh SDM, serta pengelolaan master kota dan user oleh admin.

## Tech Stack

- Laravel
- Blade
- Tailwind CSS
- Alpine.js
- Vite
- MySQL
- Laravel authentication
- Spatie Laravel Permission

## Fitur Utama

- Login berbasis `username` dan `password`
- Redirect dashboard sesuai role `ADMIN`, `PEGAWAI`, dan `SDM`
- CRUD master kota
- CRUD user dan pengaturan role
- Pengajuan perjalanan dinas oleh pegawai
- Estimasi durasi, jarak, klasifikasi, rate harian, dan total uang saku
- Approval dan reject pengajuan oleh SDM
- Validasi form dan authorization per role
- Seeder akun default, master kota, dan sample pengajuan

## Business Rule Uang Saku

- Durasi dihitung `inclusive day`
- Jarak dihitung menggunakan Haversine Formula dari latitude dan longitude kota
- `0 - 60 km`: `Rp 0`
- `> 60 km` dan satu provinsi: `Rp 200.000 / hari`
- `> 60 km`, luar provinsi, satu pulau: `Rp 250.000 / hari`
- `> 60 km`, luar provinsi, beda pulau: `Rp 300.000 / hari`
- Tujuan luar negeri: `USD 50 / hari`

Klasifikasi yang dipakai:

- Tidak Mendapat Uang Saku
- Dalam Provinsi
- Luar Provinsi - Satu Pulau
- Luar Provinsi - Beda Pulau
- Luar Negeri

## Role

- `ADMIN`
  Mengakses dashboard admin, master kota, dan manajemen user.
- `PEGAWAI`
  Membuat dan melihat pengajuan perjalanan dinas miliknya sendiri.
- `SDM`
  Melihat seluruh pengajuan, memproses approve/reject, dan melihat riwayat persetujuan.

## Akun Default

- Admin
  `username: admin`
  `password: password`
- Pegawai
  `username: pegawai`
  `password: password`
- SDM
  `username: sdm`
  `password: password`

## Instalasi

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

Setelah `cp .env.example .env`, sesuaikan konfigurasi database MySQL:

- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=perdinku`
- `DB_USERNAME=...`
- `DB_PASSWORD=...`

## Menjalankan Test

Gunakan database testing terpisah agar test tidak menyentuh database utama:

```bash
cp .env.testing.example .env.testing
```

Lalu buat database MySQL baru, misalnya `perdinku_test`, dan sesuaikan kredensial di `.env.testing` bila perlu. Setelah itu jalankan:

```bash
php artisan test
```

## Route Utama

- `GET /login`
- `GET /dashboard`
- `GET /pegawai/perdin`
- `GET /sdm/pengajuan`
- `GET /admin/dashboard`
- `GET /admin/cities`
- `GET /admin/users`

## Struktur Folder

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   ├── Auth/
│   │   ├── Employee/
│   │   ├── Sdm/
│   │   └── DashboardRedirectController.php
│   ├── Requests/
│   └── Middleware/
├── Models/
├── Services/

database/
├── migrations/
├── factories/
└── seeders/

resources/
├── css/
├── js/
└── views/
    ├── admin/
    ├── auth/
    ├── components/
    ├── employee/
    ├── layouts/
    └── sdm/
```

## Referensi Desain

Referensi UI utama berada di folder:

- `../screenshot-perdinku/login-perdinku.png`
- `../screenshot-perdinku/dashboard-pegawai-perdinku.png`
- `../screenshot-perdinku/tambah-perdin-perdinku.png`
- `../screenshot-perdinku/dashboard-sdm-perdinku.png`
- `../screenshot-perdinku/detail-approval-perdinku.png`
- `../screenshot-perdinku/master-kota-perdinku.png`
- `../screenshot-perdinku/tambah-kota-perdinku.png`
- `../screenshot-perdinku/manajemen-user-perdinku.png`

## Seeder Data

Seeder akan membuat:

- 3 role utama
- 3 akun default
- 7 kota master
- 3 sample business trip:
  - Bandung → Surabaya, `pending`
  - Jakarta → Denpasar, `approved`
  - Jakarta → Singapore, `rejected`

## Catatan

- Perhitungan nominal uang saku dilakukan melalui `AllowanceCalculatorService`
- Perhitungan jarak dilakukan melalui `DistanceCalculatorService`
- Nomor pengajuan dibuat otomatis melalui `TripNumberGeneratorService`
