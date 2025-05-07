# 📦 Vendor Selection API

Sistem ini dirancang untuk membantu perusahaan dalam proses seleksi vendor secara digital. Fitur mencakup autentikasi JWT, CRUD data vendor dan item, serta data-data mengenai vendor.

---

### 🚀 Tech Stack

- **Framework**: Laravel 10+
- **Database**: MySQL (relational database)
- **Auth**: JWT (tymon/jwt-auth)
- **Docs**: [Scramble (dedoc)](https://scramble.dedoc.co) – Otomatisasi dokumentasi API

---

### ✅ Fitur Utama

| No | Fitur                                                         | Status |
|----|---------------------------------------------------------------|--------|
| 1  | Autentikasi user menggunakan JWT                              | ✅     |
| 2  | Endpoint login & register                                     | ✅     |
| 3  | Sistem CRUD: Vendor, Item, Order                              | ✅     |
| 4  | Validasi menggunakan FormRequest                              | ✅     |
| 5  | Dokumentasi API otomatis menggunakan Scramble (`/docs`)       | ✅     |
| 6  | Script migration untuk semua tabel disediakan (`/database`)   | ✅     |
| 7  | Laporan item per vendor, ranking transaksi, perubahan harga   | ✅     |

---

### 🔐 Autentikasi

- Gunakan endpoint `POST /v1/auth/login` untuk login.
- Gunakan `Authorization: Bearer {access_token}` untuk akses protected API.

---

### 🧪 Sample User

```json
{
  "email": "admin@example.com",
  "password": "password"
}
```

---

### 📁 Struktur Utama

```
app/
├── Http/
│   ├── Controllers/
│   ├── Requests/
├── Interfaces/
├── Repositories/
├── Providers/
database/
├── migrations/
routes/
├── api.php
```

---

### 📊 Dokumentasi API

Setelah server berjalan:

📄 Akses: `http://localhost:8000/docs/api`

- Didukung oleh **Scramble**
- Otomatis menampilkan input, response, dan validasi
- Termasuk input Bearer Token

---

### 📜 Cara Menjalankan

```bash
# 1. Install depedensi
composer install

# 2. Copy env
cp .env.example .env

# 3. Atur database di .env
DB_DATABASE=vendor_selection
DB_USERNAME=root
DB_PASSWORD=

# 4. Generate key & JWT secret
php artisan key:generate
php artisan jwt:secret

# 5. Migrasi dan seed
php artisan migrate --seed

# 6. Jalankan server
php artisan serve
```

---

### 📊 Endpoints Penting

| Endpoint                      | Method | Auth | Keterangan                          |
|------------------------------|--------|------|--------------------------------------|
| `/v1/auth/register`          | POST   | ❌   | Register user baru                   |
| `/v1/auth/login`             | POST   | ❌   | Login dan dapatkan token             |
| `/v1/auth/logout`            | POST   | ✅   | Logout pengguna                      |
| `/v1/report/items`           | GET    | ✅   | List item yang disediakan vendor     |
| `/v1/report/ranking`         | GET    | ✅   | Urutan vendor berdasarkan transaksi  |
| `/v1/report/price-change`    | GET    | ✅   | Laporan perubahan harga per item     |

---

### 🛠 Dev Notes

- Arsitektur dipisah: Controller → Repository → Interface → Model
- Validasi menggunakan FormRequest
- Try-catch dan logging diterapkan di level Repository
