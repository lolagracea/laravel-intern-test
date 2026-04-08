# 📌 Laravel User & Hobby API

## Deskripsi

Program implementasi API sederhana berbasis Laravel untuk mengelola data **User** dan **Hobi**. API ini dirancang untuk memenuhi kebutuhan test backend dengan fokus pada penerapan konsep dasar Laravel seperti Eloquent ORM, relasi antar model, serta validasi request.

Sistem memungkinkan satu user memiliki banyak hobi (_one-to-many relationship_), dengan struktur yang sederhana namun tetap mengikuti praktik pengembangan backend yang baik.

---

## Teknologi yang Digunakan

- PHP (Laravel Framework)
- MySQL
- Eloquent ORM
- RESTful API
- JSON Response

---

## Struktur Fitur

### 🔹 User

- Menambahkan user baru
- Menampilkan daftar user beserta hobi

### 🔹 Hobby

- Menambahkan hobi untuk user tertentu
- Menghapus hobi berdasarkan ID

---

## Endpoint API

| Method | Endpoint            | Deskripsi                           |
| ------ | ------------------- | ----------------------------------- |
| GET    | `/api/users`        | Menampilkan semua user beserta hobi |
| POST   | `/api/users`        | Menambahkan user baru               |
| POST   | `/api/hobbies`      | Menambahkan hobi ke user            |
| DELETE | `/api/hobbies/{id}` | Menghapus hobi                      |

---

## Format Request & Response

### Tambah User

**Request:**

```json
{
    "nama": "John Doe",
    "email": "john@example.com"
}
```

---

### Tambah Hobby

**Request:**

```json
{
    "nama_hobi": "Membaca",
    "user_id": 1
}
```

---

### Response Umum

```json
{
  "success": true,
  "data": ...
}
```

---

## Instalasi & Setup

### 1. Clone Repository

```bash
git clone <repository-url>
cd laravel-intern-test
```

---

### 2. Install Dependency

```bash
composer install
```

---

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Atur koneksi database:

```
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

---

### 4. Generate App Key

```bash
php artisan key:generate
```

---

### 5. Jalankan Migration

```bash
php artisan migrate
```

---

### 6. Jalankan Server

```bash
php artisan serve
```

---

## Keamanan (Security)

API ini telah dilengkapi dengan mekanisme **Rate Limiting** untuk membatasi jumlah request:

- Maksimal: **1000 request per jam**
- Berdasarkan: **User (jika login) atau IP Address**

Tujuan:

- Mencegah abuse
- Menjaga stabilitas server

---

## Konsep yang Diimplementasikan

- Eloquent Relationship (`hasMany`, `belongsTo`)
- Request Validation
- REST API Design
- Rate Limiting (Throttle)
- Database Migration
- JSON Response Standardization

---

## Testing

Pengujian dapat dilakukan menggunakan:

- Postman
- cURL
- Laravel Feature Test

---

## Catatan Pengembangan

Beberapa peningkatan yang dapat dilakukan untuk pengembangan lebih lanjut:

- Menggunakan **Form Request** untuk validasi
- Implementasi **API Resource** untuk response
- Menambahkan **pagination**
- Penerapan **Service Layer**
- Implementasi **Authentication (Sanctum/JWT)**

---

## Author

Dikembangkan sebagai bagian dari **Laravel Backend Intern Test**.

---

## Kesimpulan

Proyek ini menunjukkan pemahaman dasar hingga menengah dalam pengembangan backend menggunakan Laravel, dengan implementasi fitur yang sesuai kebutuhan serta perhatian terhadap aspek keamanan dan struktur kode.
