# CodeIgniter 4 BSI Bank Sampah

## Apa itu Bank Sampah?

Bank Sampah adalah sebuah sistem penyimpanan sampah dengan cara kita setor sampah ke pihak bank sampah lalu nanti sampah kita akan di konversi menjadi uang dalam bentuk saldo yang nanti akan tersimpan di rekening kita

## Setup

- [XAMPP](https://www.apachefriends.org/download.html) XAMPP Versi 7.4 atau diatasnya
- [intl](http://php.net/manual/en/intl.requirements.php) Aktifkan intl pada XAMPP -> Apache -> Config -> PHP (php.ini) -> Cari ;extension=intl -> Hapus titik koma di awal lalu save
- [Composer](https://getcomposer.org/)

## Instalasi

1. Konfigurasi database di `app/Config/Database.php`.
2. Download atau clone repository ini.
3. Buka terminal atau cmd di direktori project.
4. `composer update` dan `composer install` untuk menginstall dependencies.
5. `php spark migrate` untuk mengisi struktur database.
6. `php spark db:seed MainSeeder` untuk mengisi database dengan data awal.
7. Jalankan server dengan `php spark serve`.
8. Buka browser dan masuk ke [http://localhost:8080](http://localhost:8080).
