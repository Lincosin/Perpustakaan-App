<?php
include "config.php";
include "Buku.php";

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

if (!$bukuData) {
    echo "<script>alert('Data buku tidak ditemukan'); window.location.href='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Buku</title>
  <link rel="stylesheet" href="src/style.css">
  <style>
    
  </style>
</head>
<body>
  <?php include "src/navbar.php"; ?>

  <div class="detail-card">
    <h2>Detail Buku</h2>
    <div class="detail-item"><span>ID:</span> <?= htmlspecialchars($bukuData['id_buku']) ?></div>
    <div class="detail-item"><span>Judul:</span> <?= htmlspecialchars($bukuData['judul']) ?></div>
    <div class="detail-item"><span>Penulis:</span> <?= htmlspecialchars($bukuData['penulis']) ?></div>
    <div class="detail-item"><span>Tahun:</span> <?= htmlspecialchars($bukuData['tahun_terbit']) ?></div>
    <div class="detail-item"><span>Kategori:</span> <?= htmlspecialchars($bukuData['kategori']) ?></div>
    <div class="detail-item"><span>Status:</span> <?= htmlspecialchars($bukuData['status']) ?></div>
    
    <div class="detail-sampul">
      <?php if (!empty($bukuData['sampul'])): ?>
        <img src="<?= htmlspecialchars($bukuData['sampul']) ?>" alt="Sampul Buku">
      <?php else: ?>
        <p><em>Tidak ada sampul</em></p>
      <?php endif; ?>
    </div>

    <a href="index.php" class="back-link">⬅ Kembali ke Daftar</a>
  </div>
</body>
</html>
