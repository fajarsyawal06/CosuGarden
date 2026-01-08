# CosuGarden — Simple Costume Shop (Laravel 12)

Aplikasi penjualan sederhana untuk costume cosplayer:
- Autentikasi: Register, Login, Logout
- Role sederhana: `admin` dan `user` (middleware `admin`)
- Admin Panel: CRUD Category & Costume, kelola Order (status)
- Shop (public): katalog + filter (search & category)
- Upload file/gambar costume
- Cart berbasis session: add, update qty, remove, checkout
- Orders: halaman “My Orders” menampilkan item (klik nama item menuju detail produk)
- RESTful routes + Migration + Seeder + Blade templates

---

## 1) Requirements

- PHP >= 8.2 (kamu memakai PHP 8.4.x OK)
- Composer
- Node.js + NPM
- Database MySQL/MariaDB
- (Opsional) Laragon / XAMPP / Valet

---

## 2) Instalasi

### 2.1 Clone project & install dependencies
```bash
git clone <repo-url> cosugarden
cd cosugarden

composer install
npm install
