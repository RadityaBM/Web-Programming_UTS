<?php
include 'koneksi.php';
/** @var mysqli $conn */

$id = $_POST['id_kategori'];
$nama = $_POST['nama_kategori'];
$keterangan = $_POST['keterangan'];

$stmt = $conn->prepare("UPDATE kategori_artikel SET nama_kategori=?, keterangan=? WHERE id=?");
$stmt->bind_param("ssi", $nama, $keterangan, $id);
echo $stmt->execute() ? "sukses" : "gagal";
?>