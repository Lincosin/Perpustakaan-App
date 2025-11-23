<?php
class Validator {
    public static function teks($input, $fieldName) {
        if (empty(trim($input))) {
            throw new Exception("$fieldName tidak boleh kosong");
        }
        return htmlspecialchars(trim($input));
    }

    public static function year($year) {
        if (!is_numeric($year) || $year < 1901 || $year > 2155) {
            throw new Exception("Tahun harus antara 1901–2155");
        }
        return (int)$year;
    }

    public static function angka($value, $min = 0, $max = 9999) {
        return is_numeric($value) && $value >= $min && $value <= $max;
    }

    public static function pilihan($value, $allowed, $fieldName = "Field") {
        if (!is_array($allowed)) {
            throw new Exception("Parameter pilihan untuk $fieldName harus berupa array");
        }

        // Cek apakah value ada di daftar allowed
        if (!in_array($value, $allowed)) {
            throw new Exception("$fieldName harus salah satu dari: " . implode(", ", $allowed));
        }

        return $value;
    }

    public static function file($file) {
        if (!is_array($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("File harus diupload dengan benar");
        }

        $allowed = ['jpg','jpeg','png'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            throw new Exception("File harus jpg/png");
        }
        if ($file['size'] > 2 * 1024 * 1024) {
            throw new Exception("Ukuran file maksimal 2MB");
        }
        return $file;
    }
}

?>
