# 🧋 WarkopNet – Forum Diskusi

WarkopNet adalah aplikasi forum diskusi sederhana yang dibangun menggunakan **Laravel**, **Livewire**, **Filament**, dan **Tailwind CSS CDN**. Proyek ini dibuat sebagai media diskusi ringan dan cepat untuk pengguna, sekaligus sebagai pengembangan kemampuan pribadi dalam membangun aplikasi web modern.

---

## 🚀 Teknologi yang Digunakan
- **Laravel** – Framework backend utama
- **Livewire** – Komponen interaktif tanpa JavaScript khusus
- **Filament** – Admin panel modern
- **Tailwind CSS (CDN)** – Styling cepat tanpa proses build
- **MySQL** – Database utama

---

## ⚙️ Cara Instalasi & Menjalankan Proyek

### 1️⃣ Clone Repository
```bash
git clone https://github.com/sausan07/Projek-WarkopNet-ForumDiskusi-SausanAqillah-250458302058.git

2️⃣ Masuk ke Folder Project
cd Projek-WarkopNet-ForumDiskusi-SausanAqillah-250458302058

3️⃣ Install Dependency Laravel
composer install

4️⃣ Duplikasi File .env dan Generate Key
cp .env.example .env
php artisan key:generate

5️⃣ Atur Database di File .env
DB_DATABASE=warkopnet
DB_USERNAME=root
DB_PASSWORD=

6️⃣ Migrasi Database
php artisan migrate

7️⃣ Jalankan Server Laravel
php artisan serve


