<?php
class Buku {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    private function uploadFile($file) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = time() . "_" . uniqid() . "." . $ext;
        $uploadPath = "uploads/" . $newName;
        move_uploaded_file($file['tmp_name'], $uploadPath);
        return $uploadPath;
    }

    public function tambah($judul, $penulis, $tahun, $kategori, $status, $sampul) {
        if (!Validator::teks($judul, 255))  die("Judul wajib isi.");
        if (!Validator::teks($penulis, 255)) die("Penulis wajib isi.");
        if (!Validator::teks($kategori, 15)) die("Kategori wajib isi.");
        if (!Validator::angka($tahun))       die("Tahun harus angka 0–9999.");
        if (!Validator::pilihan($status, ['tersedia','kosong'])) die("Status tidak valid.");
        if (!Validator::file($sampul))       die("File harus jpg/png dan < 2MB.");

        $sampulPath = $this->uploadFile($sampul);

        $sql = "INSERT INTO buku (judul, penulis, tahun_terbit, kategori, status, sampul) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$judul, $penulis, $tahun, $kategori, $status, $sampulPath]);
    }

    public function edit($id_buku, $judul, $penulis, $tahun, $kategori, $status, $sampul = null) {
    try {
        $stmt = $this->pdo->prepare("SELECT sampul FROM buku WHERE id_buku = ?");
        $stmt->execute([$id_buku]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $sampulPath = $row ? $row['sampul'] : null;

        if ($sampul && $sampul['error'] == UPLOAD_ERR_OK) {
            if (!empty($row['sampul'])) {
                $oldFile = __DIR__ . "/uploads/" . $row['sampul'];
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $targetPath = __DIR__ . "/" . $row['sampul'];
            if (move_uploaded_file($sampul['tmp_name'], $targetPath)) {
                $sampulPath = $row['sampul'];
            }
        }

        $sql = "UPDATE buku 
                SET judul=?, penulis=?, tahun_terbit=?, kategori=?, status=?, sampul=? 
                WHERE id_buku=?";
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute([$judul, $penulis, $tahun, $kategori, $status, $sampulPath, $id_buku]);

        // if (!$success) {
        //     var_dump($stmt->errorInfo()); // debug jika gagal
        // }

        return $success;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function hapus($id_buku) {
        $stmt = $this->pdo->prepare("SELECT sampul FROM buku WHERE id_buku = ?");
        $stmt->execute([$id_buku]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && !empty($row['sampul'])) {
            $filePath = realpath(__DIR__ . "/" . $row['sampul']);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $stmt = $this->pdo->prepare("DELETE FROM buku WHERE id_buku = ?");
        return $stmt->execute([$id_buku]);
    }
}
?>