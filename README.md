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
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_laravel_intern
DB_USERNAME=root
DB_PASSWORD=
```

---

### 4. Jalankan Migration

```bash
php artisan migrate
```

---

### 5. Jalankan Server

```bash
php artisan serve
```

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

## Author

Dikembangkan sebagai bagian dari **Laravel Backend Intern Test**.

---
