# RWA Pay

RWA Pay adalah **jembatan gateway pembayaran QRIS** yang berfungsi untuk menerima dan meneruskan webhook dari listener pembayaran (misal: dompet digital, bank) ke endpoint merchant, serta menyimpan log transaksi secara real-time.

---

## 🚀 Cara Kerja Singkat

1. **Merchant** membuat transaksi lewat API `/api/payment/create`
2. Sistem mencatat transaksi (manual/otomatis) ke database dan menghasilkan QRIS dinamis
3. **App Listener** (seperti wallet scanner) mengirim webhook masuk ke endpoint `/webhook/incoming`
4. RWA Pay mencocokkan reference dan meneruskan payload ke `target_url` merchant
5. Webhook response dicatat. Jika gagal, sistem akan retry otomatis
6. Transaksi yang tidak dibayar dalam 30 menit akan **berubah status menjadi expired** dan webhook juga akan dikirim

---

## ⚙️ Cara Menjalankan Proyek (Local)

```bash
git clone https://github.com/username/rwa-pay.git
cd rwa-pay

# Install dependencies
composer install

# Copy env
cp .env.example .env

# Generate app key
php artisan key:generate

# Sesuaikan database & config QRIS di .env
php artisan migrate --seed

# Jalankan queue & scheduler
php artisan queue:work
php artisan schedule:work

# Jalankan server (Octane dengan FrankenPHP)
php artisan octane:start --server=frankenphp
```

> **Note:** Pastikan `qris.statis` diatur di `.env` untuk QRIS template:
> `QRIS_STATIC=...`

---

## 📬 Dokumentasi API

👉 Dokumentasi lengkap tersedia di Apidog:

🔗 **[https://rwa-pay.apidog.io](https://rwa-pay.apidog.io)**

---

## 📦 Fitur Utama (Fast Development Mode)

-   [x] QRIS Dinamis Generator dari QR Statis
-   [x] Pencatatan transaksi manual & otomatis
-   [x] Kirim webhook ke merchant dengan HMAC signature
-   [x] Retry webhook otomatis jika gagal
-   [x] Expired otomatis setelah 30 menit
-   [x] Filament admin panel (Laravel 12 + Filament 3)
-   [x] Fast deploy via Octane + FrankenPHP

---

## 🔐 Keamanan

-   Webhook keluar dilindungi dengan header `X-Signature` (HMAC SHA256)
-   Webhook masuk hanya bisa dilakukan oleh trusted listener
-   API endpoint dilindungi dengan `X-Api-Key` (per merchant)

---

## 📃 License

Project ini bersifat pribadi/internal. Gunakan dengan bijak sesuai kebutuhan.

---
