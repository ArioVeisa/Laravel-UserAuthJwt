# OrderIt! Microservices – Sistem Pemesanan dengan REST API

OrderIt! adalah proyek contoh sistem pemesanan berbasis microservices dengan Laravel. Terdiri dari empat service terpisah:
- AuthService (User Management & JWT Auth)
- ProductService (Manajemen Produk)
- OrderService (Manajemen Order)
- PaymentService (Pembayaran)

Setiap service menggunakan Laravel 11 dan terhubung melalui REST API.

## 🔧 Persiapan Awal

### 1. Clone Repository Masing-masing Service

```bash
git clone https://github.com/yourname/auth-service.git
cd auth-service
```

Lakukan hal yang sama untuk:
- product-service
- order-service
- payment-service

### 2. Ubah Konfigurasi Database

Edit file `.env` di masing-masing folder dan ubah koneksi database ke:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=orderit_db
DB_USERNAME=root
DB_PASSWORD=
```

> **Catatan**: Pastikan MySQL berjalan dan database `orderit_db` sudah dibuat.

### 3. Instalasi Dependency dan Generate Key

```bash
composer install
php artisan key:generate
```

### 4. Jalankan Migrasi Database

```bash
php artisan migrate
```

## 🚀 Menjalankan Masing-masing Service

Buka terminal baru untuk tiap folder dan jalankan:

```bash
php artisan serve --port=8001 # AuthService
php artisan serve --port=8002 # ProductService
php artisan serve --port=8003 # OrderService
php artisan serve --port=8004 # PaymentService
```

## 🔐 Autentikasi (AuthService)

- `POST /api/register` → Register user baru
- `POST /api/login` → Login user dan dapatkan JWT
- `GET /api/profile` → Ambil profile user (wajib pakai token)

## 📦 Manajemen Produk (ProductService)

- `GET /api/products`
- `POST /api/products`
- `GET /api/products/{id}`
- `PUT /api/products/{id}`
- `DELETE /api/products/{id}`

## 🛒 Order (OrderService)

- `GET /api/orders`
- `POST /api/orders` *(menggunakan JWT dari AuthService)*
- `GET /api/orders/{id}`

> Order akan mengakses ProductService dan AuthService menggunakan HTTP client

## 💳 Payment (PaymentService)

- `POST /api/payments` *(terkait order ID)*
- `GET /api/payments/{id}`

## 🧪 Testing API via Postman

Import collection Postman dari folder `postman/OrderIt.postman_collection.json` dan atur environment URL sesuai port service masing-masing.

## 📌 Notes

- Semua service share database `orderit_db`, tapi memiliki tabel masing-masing.
- Middleware JWT sudah disesuaikan untuk Laravel 11 menggunakan bootstrap `app.php`
- Untuk komunikasi antar service, gunakan `Http::get()` / `Http::post()` dari Laravel HTTP Client

## 🧑‍💻 Kontributor

Made with 💻 by [Your Name]

