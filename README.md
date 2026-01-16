# Kampung Tematik Malang

Aplikasi web berbasis **Laravel** yang dibuat untuk mendukung pengelolaan dan informasi **Kampung Tematik**.
Project ini dikembangkan dan dijalankan menggunakan **Laragon** sebagai web server lokal.

---

## 🛠️ Teknologi yang Digunakan

* **Laravel** (Framework PHP)
* **PHP 8+**
* **MySQL**
* **Laragon**
* **Blade Template Engine**
* **Vite**
* **Bootstrap / CSS**

---

## 📁 Struktur Project

```
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
tests/
vendor/
.env
artisan
composer.json
web_laravel (1).sql
```

---

## ⚙️ Instalasi & Menjalankan Project

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer lokal.

### 1️⃣ Clone Repository

```bash
git clone https://github.com/username/kampung-tematik-Malang.git
```

### 2️⃣ Masuk ke Folder Project

```bash
cd kampung-tematik
```

### 3️⃣ Install Dependency PHP

```bash
composer install
```

### 4️⃣ Copy File Environment

```bash
cp .env.example .env
```

### 5️⃣ Generate App Key

```bash
php artisan key:generate
```

---

## 🗄️ Konfigurasi Database

1. Jalankan **Laragon**
2. Buat database baru, contoh:

   ```
   kampung_tematik
   ```
3. Import file database:

   ```
   web_laravel (1).sql
   ```
4. Sesuaikan konfigurasi database di file `.env`

```env
DB_DATABASE=kampung_tematik
DB_USERNAME=root
DB_PASSWORD=
```

---

## ▶️ Menjalankan Aplikasi

```bash
php artisan serve
```

Atau langsung akses melalui Laragon:

```
http://kampung-tematik.test
```

---

## 📌 Fitur Aplikasi

* Manajemen data Kampung Tematik
* Tampilan halaman berbasis Blade
* CRUD data
* Integrasi database MySQL
* Sistem routing Laravel

---

## 📄 Lisensi

Project ini dibuat untuk **pembelajaran dan pengembangan**.
Bebas digunakan dan dimodifikasi sesuai kebutuhan.

---

## 👤 Author

**Rio Pratama Putra**
Mahasiswa / Developer Pemula
Project Laravel – Kampung Tematik Malang

---

## ⭐ Catatan

Jika project ini membantu, jangan lupa beri ⭐ di repository GitHub 😊
