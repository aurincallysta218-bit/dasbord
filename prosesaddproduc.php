<?php

if (isset($_POST['simpan'])) {

    include 'koneksi.php';

    $produk    = $_POST['nama_produk'];
    $kategori  = $_POST['kategori'];
    $harga     = (int) $_POST['harga'];
    $stok      = (int) $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];
    $gambar    = '';

    // ===== Upload gambar =====
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {

        $folder   = __DIR__ . '/media/';
        $boleh    = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext      = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $ukuran   = $_FILES['gambar']['size'];
        $tmp      = $_FILES['gambar']['tmp_name'];

        if (!in_array($ext, $boleh)) {
            die("Gagal: format gambar harus JPG, PNG, GIF, atau WEBP. <a href='javascript:history.back()'>Kembali</a>");
        }
        if ($ukuran > 2 * 1024 * 1024) {
            die("Gagal: ukuran gambar maksimal 2 MB. <a href='javascript:history.back()'>Kembali</a>");
        }
        if (getimagesize($tmp) === false) {
            die("Gagal: file yang diupload bukan gambar. <a href='javascript:history.back()'>Kembali</a>");
        }

        // buat folder media otomatis kalau belum ada
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        // nama unik supaya tidak bentrok
        $gambar = uniqid('produk_') . '.' . $ext;

        if (!move_uploaded_file($tmp, $folder . $gambar)) {
            die("Gagal menyimpan gambar ke folder media.");
        }
    }

    // ===== Simpan ke database (prepared statement, aman dari tanda kutip dll) =====
    $stmt = mysqli_prepare($dbconnect,
        "INSERT INTO produk
        (id_produk, nama_produk, kategori, harga, stok, deskripsi, gambar, tanggal_ditambahkan)
        VALUES
        (NULL, ?, ?, ?, ?, ?, ?, NOW())");

    mysqli_stmt_bind_param($stmt, "ssiiss", $produk, $kategori, $harga, $stok, $deskripsi, $gambar);

    if (mysqli_stmt_execute($stmt)) {
        header("location: index.php?page=produk");
        exit;
    } else {
        echo "Gagal menambahkan produk: " . mysqli_error($dbconnect);
    }
}

?>
