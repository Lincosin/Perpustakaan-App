<?php
include "config.php";
include "Validator.php";
include "Buku.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db   = new Database();
    $pdo  = $db->pdo;
    $buku = new Buku($pdo);

    try {
        $judul= Validator::teks($_POST['judul'], "Judul");
        $penulis = Validator::teks($_POST['penulis'], "Penulis");
        $tahunTerbit = Validator::year($_POST['tahun']);
        $kategori = Validator::teks($_POST['kategori'], "Kategori");
        $status = Validator::pilihan($_POST['status'], ['tersedia', 'kosong'], "Status");
        $sampul = Validator::file($_FILES['sampul']);

        if ($buku->tambah($judul, $penulis, $tahunTerbit, $kategori, $status, $sampul)) {
            echo "<script>alert('Data berhasil disimpan!');
            window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Data gagal disimpan!');</script>";
        }

    } catch (Exception $e) {
        echo "<script>alert('Error: ".addslashes($e->getMessage())."');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="src/style.css">
</head>
<body>
    <?php include "src/navbar.php"; ?>

    <div class="form-card">
      <h2>Tambah Buku</h2>
      <form action="" method="POST" enctype="multipart/form-data">
        <label for="judul">Judul Buku</label>
        <input type="text" id="judul" name="judul" maxlength="255" placeholder="Masukkan judul buku" required><br><br>

        <label for="penulis">Penulis</label>
        <input type="text" id="penulis" name="penulis" maxlength="255" placeholder="Masukkan Nama Penulis" required><br><br>

        <label for="tahun_terbit">Tahun Terbit</label>
        <input type="number" id="tahun" name="tahun" min="0" max="9999" placeholder="Masukkan Tahun Terbit Buku" required><br><br>

        <label for="kategori">Kategori</label>
        <input type="text" id="kategori" name="kategori" maxlength="15" placeholder="Masukkan Kategori buku" required><br><br>

        <label for="status">Status</label>
        <select id="status" name="status" required>
        <option value="tersedia">Tersedia</option>
        <option value="kosong">Kosong</option>
        </select><br><br>

        <label for="sampul">Upload Sampul Buku</label>
        <input type="file" id="sampul" name="sampul" accept="image/jpeg,image/png" required><br><br>

        <button type="submit">Simpan</button>
        <a class="kembali" href="index.php">kembali</a>
      </form>
    </div>
</body>
</html>