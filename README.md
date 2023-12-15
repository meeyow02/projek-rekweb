# Tugas Projek Rekayasa Website
> Website CRUD sederhana.

### Framework

Framework yang digunakan untuk mengembangkan website ini adalah
Laravel, Inertia, Vue

### Fitur

Website ini memiliki fitur:
-    `Add Book` untuk menambahkan data buku
-    `Edit` untuk mengedit data buku yang diinginkan
-    `Delete` untuk menghapus data buku yang diinginkan
-    `Delete All Data` untuk menghapus semua data buku

## Requirments

-   php (min 8.1.2)
-   composer
-   node.js
-   mysql
-   apache

## How to install

1. Clone repository `https://github.com/meeyow02/projek-rekweb.git`
2. Setup database mysql
    - Jika menggunakan xampp pastikan untuk membuat database dengan nama `projek_rekweb` dan
   konfigurasi `username` dan `password` untuk databasenya.
3. Buka folder yang sudah di clone, bukalah terminal dan jalankan `composer install`
4. copy file `env.example` ke `.env`
5. isi data di file `env` dengan bagian awal `DB_` dengan data yang sesuai
6. jalankan `php artisan key:generate`
7. jalankan `php artisan migrate`
8. Jalankan `npm run dev` dan `php artisan serve` di terminal yang berbeda
9. Bukalah website sesuai dengan url

## How to use

Pada tahap ini, website sudah bisa diakses. Namun halaman masih kosong untuk menambah data ada beberapa cara yang dapat dilakukan:

1. Menggunakan data dummy (sebanyak 10 data), jalankan perintah `php artisan db:seed` di terminal, maka data akan terisi secara otomatis.
2. Menambah data secara manual dengan menggunakan fitur `Add Book`

## Hosting on VM

1. Di folder projek-laravel jalankan perintah `npm run build`
2. Jika menyimpan folder projek-laravel yang telah diclone pada folder root `/var/www/html`, maka langsung saja menjalankan perintah `sudo service apache2 start`
3. Jika menyimpan folder projek-laravel yang telah diclone bukan pada folder root `/var/www/html`, maka ikuti instruksi berikut:
   - Rename folder `html` menjadi `oldhtml` yang ada pada folder `/var/www/`. Gunakan perintah `sudo mv html oldhtml`
   - Buat folder `html` yang mengarah pada folder projek-rekweb. Gunakan perintah `sudo ln -s /path/ke/projek-rekweb/public html
   - Tambahkan konfigurasi baru `sites-enabled` pada folder `/etc/apache2/sites-enabled`. Pertama, buat file nama_file.conf pada folder `sites-available` dengan menggunakan perintah `sudo cp 000-default.conf /etc/apache2/sites-available/nama_file.conf`.
   - Kedua, pada folder `/etc/apache2/sites-enabled`, gunakan perintah `sudo ln -s /etc/apache2/sites-available/nama_file.conf nama_file.conf`. Konfigurasi `nama_file.conf` dengan mengarahkan `DocumentRoot`ke `/path/ke/projek-rekweb/public`. Juga pada bagian `<Directory "/path/ke/projek-rekweb"> ... </Directory>`.
   - Jalankan perintah `sudo a2enmod rewrite` dan `sudo service apache2 restart`
4. Copy ip address pada broswer untuk menjalankan website yang telah dihosting di VM (ip addresss bisa dilihat dengan menggunakan perintah `ip addr`)
