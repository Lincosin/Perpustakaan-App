<?php
include "config.php";
include "Validator.php";
require_once "Buku.php";

$db  = new Database();
$pdo = $db->pdo;
$bukuObj = new Buku($pdo);

$id_buku = $_GET['id'] ?? null;
$bukuData = null;
if ($id_buku) {
    $stmt = $pdo->prepare("SELECT * FROM buku WHERE id_buku = ?");
    $stmt->execute([$id_buku]);
    $bukuData = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $judul       = Validator::teks($_POST['judul'], "Judul");
        $penulis     = Validator::teks($_POST['penulis'], "Penulis");
        $tahunTerbit = Validator::year($_POST['tahun']);
        $kategori    = Validator::teks($_POST['kategori'], "Kategori");
        $status      = Validator::pilihan($_POST['status'], ['tersedia', 'kosong'], "Status");
        $sampul      = Validator::file($_FILES['sampul']);

        if ($bukuObj->edit($_POST['id_buku'], $judul, $penulis, $tahunTerbit, $kategori, $status, $sampul)) {
            echo "<script>alert('Update Data berhasil disimpan!');
                window.location.href = 'index.php'; </script>";
        } else {
            echo "<script>alert('Update Data gagal disimpan!');</script>";
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
    <title>Edit Buku</title>
    <link rel="stylesheet" href="src/style.css">
</head>
<body>
    <?php include "src/navbar.php"; ?>
    <div class="form-card">
      <h2>Edit Data Buku</h2>
      <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_buku" value="<?= htmlspecialchars($bukuData['id_buku']) ?>">
        Judul: <input type="text" name="judul" value="<?= htmlspecialchars($bukuData['judul']) ?>"><br>
        Penulis: <input type="text" name="penulis" value="<?= htmlspecialchars($bukuData['penulis']) ?>"><br>
        Tahun: <input type="number" name="tahun" value="<?= htmlspecialchars($bukuData['tahun_terbit']) ?>"><br>
        Kategori: <input type="text" name="kategori" value="<?= htmlspecialchars($bukuData['kategori']) ?>"><br>
        Status:
        <select name="status">
            <option value="tersedia" <?= $bukuData['status']=='tersedia'?'selected':'' ?>>Tersedia</option>
            <option value="kosong" <?= $bukuData['status']=='kosong'?'selected':'' ?>>Kosong</option>
        </select><br>

        <div class="sampul-wrapper">
        <label>Sampul lama:</label><br>
        <?php if (!empty($bukuData['sampul'])): ?>
            <img src="<?= htmlspecialchars($bukuData['sampul']) ?>" class="sampul-lama">
        <?php endif; ?>

        <label for="sampul" class="ganti-label">Ganti sampul:</label>
        <input type="file" name="sampul" id="sampul">
        </div>

        <button type="submit">Update</button>
        <a class="kembali" href="index.php">kembali</a>
    </form>
    </div>
</body>
</html>