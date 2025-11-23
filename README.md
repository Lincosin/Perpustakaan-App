# **Deskripsi Aplikasi**

- Aplikasi Create Read Update Delete (CRUD) sederhana untuk memanajemen
  data buku perpustakaan.

- Entitas Utama pada aplikasi ini adalah **buku**. Dengan atribut:

1.  id_buku

2.  judul

3.  penulis

4.  tahun_terbit

5.  kategori

6.  status

7.  sampul

- Adapun beberapa fungsi dari aplikasi ini:

1.  Menampilkan daftar buku dalam tabel

2.  Menambahkan data buku baru

3.  Melihat detail data buku tertentu

4.  Mengedit data buku tertentu

5.  Menghapus data buku

# **Spesifikasi Teknis**

- Versi **PHP**: 8.2.12

- **DBMS** yang digunakan: MySQL/MariaDB.

- **Struktur Folder:**

  - App/

<!-- -->

- config.php

- index.php

- tambah.php

- edit.php

- detail.php

- buku.php

- Validator.php

- src/

  - style.css

  - navbar.php

  <!-- -->

  - uploads/

<!-- -->

- Class Utama:

  - Database: mengatur koneksi PDO ke MySQL.

  - Buku: berisi operasi CRUD (tambah, tampil, edit, hapus).

  - Validator: validasi input teks, angka, pilihan, dan file.

# **Intruksi Menjalankan Aplikasi**

6.  

<!-- -->

1.  Jalankan Perintah CLI ini secara bertahap:

    - **mysql -u root -p** (sesuaikan dengan username dan password
      masing-masing)

    - **CREATE DATABASE perpustakaan;** (nama database bisa disesuaikan)

    - **SOURCE path schema.sql;** (sesuaikan path schema.sql pada
      komputer,

> Contoh; D:/ projectphp/BA243/App/schema.sql;)

2.  Atur konfigurasi database di file **config.php**

> class Database {
>
> public \$pdo;
>
> public function \_\_construct() {
>
> \$host = \"localhost\";
>
> \$dbname = \"perpustakaan\";
>
> \$user = \"root\";
>
> \$pass = \"\";
>
> \$this-\>pdo = new PDO(\"mysql:host=\$host;dbname=\$dbname\", \$user,
> \$pass);
>
> \$this-\>pdo-\>setAttribute(PDO::ATTR_ERRMODE,
> PDO::ERRMODE_EXCEPTION);
>
> }
>
> }

Sesuaikan dengan nama database, username, dan password.

3.  Jalankan aplikasi dengan CLI dari folder aplikasi: **php -S
    localhost:8000**

4.  Akses dengan membuka browser lalu ketikkan
    **<http://localhost:8000/index.php>**

5.  Jika ingin menghentikan server localhost:8000, klik **CTRL + C**
    pada saat di terminal.

Dan aplikasi sudah dapat digunakan dengan contoh skenario:

# **Contoh Skenario Uji Singkat**

1.  **Tambah** 1 data

- dengan mengklik tombol "**+ Tambah Data Buku**",

- kemudian isi form (judul, penulis, tahun, kategori, status, sampul).

- Jika sudah terisi semua data maka klik tombol **Submit**, maka data
  baru akan muncul di tabel.

- Dan jika ingin membatalkan menambah data terdapat tombol **Kembali**
  yang akan mengarahkan ke halaman utama (tabel).

2.  **Tampilkan** daftar data,

- pada halaman utama (index.php) yang menampilkan tabel daftar buku.

- Dan pastikan data baru tadi sudah masuk.

3.  **Ubah** data tertentu,

- dengan klik tombol **Edit** pada salah satu baris.

- Pada halaman edit bisa mengubah semua data yang diperlukan untuk
  dirubah (kecuali id_buku).

- Dan klik submit sehingga tabel menampilkan data yang sudah diperbarui.

- Dan jika ingin membatalkan mengedit data terdapat tombol **Kembali**
  yang akan mengarahkan ke halaman utama (tabel).

4.  **Hapus** data,

- Dengan mengklik tombol **Delete.**

- Kemudian konfirmasi dengan mengklik tombol konfirmasi alert dan data
  akan hilang dari tabel setelah reload.
