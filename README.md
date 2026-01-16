# Kampung Tematik

Aplikasi **Kampung Tematik  ** adalah sistem berbasis web yang dibangun menggunakan **Laravel** untuk mendukung pengelolaan pembelajaran, konten, dan informasi Kampung Tematik secara digital dan terstruktur.

Project ini dikembangkan sebagai bagian dari tugas/implementasi pembelajaran berbasis teknologi web.

---

## 🚀 Fitur Utama
- Manajemen data Kampung Tematik
- Pengelolaan konten pembelajaran
- Sistem CRUD (Create, Read, Update, Delete)
- Tampilan responsif
- Integrasi video berbasis URL (bukan file lokal)

---

## 🛠️ Teknologi yang Digunakan
- Laravel
- PHP
- MySQL
- Blade Template
- Bootstrap / CSS
- Laragon (untuk development lokal)

---

## 📂 Struktur Folder Penting
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
artisan
composer.json
composer.lock

Folder `vendor`, `node_modules`, dan file `.env` tidak disertakan di repository sesuai best practice Laravel.

---

## ⚙️ Instalasi & Menjalankan Project

### 1. Clone Repository
git clone https://github.com/rioichitv/kampung-tematik- .git
cd kampung-tematik- 

### 2. Install Dependency
composer install

### 3. Konfigurasi Environment
cp .env.example .env
php artisan key:generate

Atur konfigurasi database di file `.env`:
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=

### 4. Migrasi Database
php artisan migrate

### 5. Jalankan Server
php artisan serve

Akses aplikasi di:
http://127.0.0.1:8000

---

## 🎥 Catatan Media / Video
File video tidak disimpan langsung di repository GitHub karena batasan ukuran file.  
Video disimpan menggunakan URL eksternal (Google Drive / YouTube / Cloud Storage).

---

## 📌 Catatan Penting
- Pastikan Composer sudah ter-install
- Gunakan Laragon / XAMPP untuk environment lokal
- Project ini menggunakan standar struktur Laravel

---

## 👨‍💻 Developer
Rio Pratama Putra

---

## 📄 Lisensi
Project ini dibuat untuk keperluan pembelajaran dan pengembangan.  
Bebas digunakan dan dikembangkan kembali sesuai kebutuhan.
