# Submission Checklist

## Instalasi

1. Jalankan `composer install`
2. Jalankan `npm.cmd install`
3. Copy `.env.example` menjadi `.env`
4. Atur koneksi MySQL di `.env`
5. Jalankan `php artisan key:generate`
6. Jalankan `php artisan migrate --seed`
7. Jalankan `npm.cmd run dev`
8. Jalankan `php artisan serve`

## Akun Default

- Admin: `admin / password`
- Pegawai: `pegawai / password`
- SDM: `sdm / password`

## Uji Manual Pegawai

1. Login sebagai `pegawai`
2. Pastikan diarahkan ke `/pegawai/perdin`
3. Buka form tambah pengajuan
4. Pilih kota asal dan tujuan berbeda
5. Isi tanggal berangkat dan pulang
6. Isi tujuan perdin minimal 10 karakter
7. Pastikan ringkasan estimasi muncul
8. Submit pengajuan
9. Pastikan data baru muncul di daftar pengajuan pegawai
10. Buka detail pengajuan dan cek durasi, jarak, klasifikasi, rate, dan total

## Uji Manual SDM

1. Login sebagai `sdm`
2. Pastikan diarahkan ke `/sdm/pengajuan`
3. Buka pengajuan `pending`
4. Klik detail
5. Pastikan total hari, jarak, klasifikasi, dan total uang tampil
6. Lakukan `approve` pada satu pengajuan
7. Lakukan `reject` pada satu pengajuan lain dengan alasan
8. Pastikan status berubah dan alasan reject tersimpan

## Uji Manual Admin

1. Login sebagai `admin`
2. Pastikan diarahkan ke `/admin/dashboard`
3. Buka halaman `Master Kota`
4. Tambah kota baru dan cek validasi
5. Edit kota yang ada
6. Buka `Manajemen User`
7. Tambah user baru
8. Ubah role dan status user
9. Hapus atau nonaktifkan user

## Rule Perhitungan yang Harus Dicek

1. Jarak `<= 60 km` menghasilkan `Tidak Mendapat Uang Saku`
2. Jarak `> 60 km` dalam provinsi yang sama menghasilkan `Rp 200.000 / hari`
3. Jarak `> 60 km` beda provinsi satu pulau menghasilkan `Rp 250.000 / hari`
4. Jarak `> 60 km` beda provinsi beda pulau menghasilkan `Rp 300.000 / hari`
5. Tujuan luar negeri menghasilkan `USD 50 / hari`

## Verifikasi Otomatis

1. Copy `.env.testing.example` menjadi `.env.testing`
2. Buat database MySQL `perdinku_test`
3. Sesuaikan kredensial database di `.env.testing` bila perlu
4. Jalankan:

```bash
php artisan test
```
