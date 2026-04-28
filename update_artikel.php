<?php
include 'koneksi.php';
/** @var mysqli $conn */

$id = $_POST['id_artikel'];
$judul = $_POST['judul'];
$id_penulis = $_POST['id_penulis'];
$id_kategori = $_POST['id_kategori'];
$isi = $_POST['isi'];

$res = mysqli_query($conn, "SELECT gambar FROM artikel WHERE id = $id");
$row = mysqli_fetch_assoc($res);
$gambar_update = $row['gambar'];

if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
    $gambar_update = time() . "_" . basename($_FILES['gambar']['name']);
    move_uploaded_file($_FILES['gambar']['tmp_name'], "uploads_artikel/" . $gambar_update);
    if (!empty($row['gambar']) && file_exists("uploads_artikel/" . $row['gambar'])) {
        unlink("uploads_artikel/" . $row['gambar']);
    }
}

$stmt = $conn->prepare("UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?");
$stmt->bind_param("iisssi", $id_penulis, $id_kategori, $judul, $isi, $gambar_update, $id);
echo $stmt->execute() ? "sukses" : "gagal";
?>