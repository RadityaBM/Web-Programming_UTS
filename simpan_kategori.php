<?php
include 'koneksi.php';
/** @var mysqli $conn */

$nama = $_POST['nama_kategori'];
$keterangan = $_POST['keterangan'];

$stmt = $conn->prepare("INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES (?, ?)");
$stmt->bind_param("ss", $nama, $keterangan);

if ($stmt->execute()) {
    echo "sukses";
} else {
    echo "gagal";
}

$stmt->close();
$conn->close();
?>