<?php
include "config.php"; 
include "Buku.php";

$db = new Database();
$pdo = $db->pdo;

$limit = 3;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $limit;

$sql = "SELECT id_buku, judul, penulis, tahun_terbit, kategori, status, sampul 
        FROM buku 
        LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$bukuList = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
$totalPages = ceil($total / $limit);


$buku = new Buku($pdo);
if (isset($_GET['delete_id'])) {
    if ($buku->hapus($_GET['delete_id'])) {
        echo "<script>
                alert('Data berhasil dihapus');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>alert('Data gagal dihapus');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/style.css">
    <title>Manajemen Buku</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
  <!-- Sidebar -->
  <?php include "src/navbar.php"; ?>

  <!-- Main Content -->
  <div class="main">

    <!-- Tabel Data Buku -->
    <div class="table-card">
    <h2>Daftar Buku</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Tahun</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Sampul</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($bukuList) > 0): ?>
            <?php foreach ($bukuList as $buku): ?>
            <tr>
                <td><?= htmlspecialchars($buku['id_buku']) ?></td>
                <td><?= htmlspecialchars($buku['judul']) ?></td>
                <td><?= htmlspecialchars($buku['penulis']) ?></td>
                <td><?= htmlspecialchars($buku['tahun_terbit']) ?></td>
                <td><?= htmlspecialchars($buku['kategori']) ?></td>
                <td><?= htmlspecialchars($buku['status']) ?></td>
                <td>
                <?php if (!empty($buku['sampul'])): ?>
                    <img src="<?= htmlspecialchars($buku['sampul']) ?>" alt="Sampul" width="60">
                <?php else: ?>
                    -
                <?php endif; ?>
                </td>
                <td style="width: 20%;">
                <a href="detail.php?id=<?= $buku['id_buku'] ?>" class="btn-detail"><i class="fa-solid fa-eye" style="margin-right: 3px;"></i>Detail</a>
                <a href="edit.php?id=<?= $buku['id_buku'] ?>" class="btn-edit"><i class="fa-solid fa-pencil" style="margin-right: 3px;"></i>Edit</a>
                <a href="?delete_id=<?= $buku['id_buku'] ?>" class="btn-delete"
                    onclick="return confirm('Yakin hapus buku ini?')"><i class="fa-solid fa-trash" style="margin-right: 3px;"></i>Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
            <td colspan="8" class="no-data">Tidak ada data buku.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    </div>
        <div class="pagination">
            <p>Halaman:</p>
            
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" 
                class="<?= $i == $page ? 'active' : '' ?>">
                <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>

  </div>
</body>
</html>