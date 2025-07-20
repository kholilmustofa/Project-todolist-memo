# Memo - Web To-Do List

Ini adalah aplikasi web sederhana untuk mengelola daftar tugas (to-do list), dengan nama "memo". Aplikasi ini dibangun menggunakan Laravel sebagai backend dan di-styling dengan Tailwind CSS & DaisyUI. 

---

## 🛠️ Fitur Utama:

* Manajemen tugas (CRUD: Buat, Tandai Selesai, Hapus).
* Kategorisasi tugas berdasarkan tanggal (Hari Ini, Besok, Mendatang).
* "My Lists" kustom untuk organisasi tugas yang lebih baik.
* Pengingat tugas dengan tanggal dan waktu spesifik.
* Pengalaman pengguna yang mulus tanpa refresh halaman berkat AJAX.

## 🚀 Teknologi yang Digunakan

* **Backend**: Laravel 12
* **Frontend**: Tailwind CSS, DaisyUI, Alpine.js
* **Database**: SQLite, TablePlus

---

## ⚙️ Instalasi & Konfigurasi Lokal

Berikut adalah langkah-langkah untuk menjalankan proyek ini di komputer Kamu:

1.  **Clone Repositori**
    Buka terminal atau Git Bash dan jalankan perintah berikut:
    ```bash
    git clone [https://github.com/kholilmustofa/Project-todolist-memo.git](https://github.com/kholilmustofa/Project-todolist-memo.git)
    ```

2.  **Masuk ke Direktori Proyek**
    ```bash
    cd Project-todolist-memo
    ```

3.  **Install Dependensi PHP**
    Jalankan Composer untuk mengunduh semua paket yang dibutuhkan oleh Laravel.
    ```bash
    composer install
    ```

4.  **Buat File Environment**
    Salin file `.env.example` menjadi `.env`. File ini berisi semua konfigurasi untuk lingkungan lokal Kamu.
    ```bash
    cp .env.example .env
    ```

5.  **Generate Kunci Aplikasi**
    Setiap aplikasi Laravel membutuhkan kunci enkripsi yang unik.
    ```bash
    php artisan key:generate
    ```

6.  **Siapkan Database**
    Proyek ini menggunakan SQLite. Buat file database kosong di dalam direktori `database/`.
    ```bash
    touch database/database.sqlite
    ```

7.  **Jalankan Migrasi Database**
    Perintah ini akan membuat semua tabel yang dibutuhkan oleh aplikasi di dalam file `database.sqlite`.
    ```bash
    php artisan migrate
    ```

8.  **Install Dependensi JavaScript/CSS**
    ```bash
    npm install
    ```

9.  **Compile Aset Frontend**
    ```bash
    npm run build
    ```

---

## ▶️ Menjalankan Aplikasi

1.  **Jalankan Server Lokal**
    Gunakan perintah `serve` dari Artisan untuk menjalankan server pengembangan PHP.
    ```bash
    php artisan serve
    ```

2.  **Buka di Browser**
    Buka browser Kamu dan kunjungi alamat: **http://127.0.0.1:8000**

Selamat! Sekarang aplikasi To-Do List sudah berjalan di komputer lokal Kamu.