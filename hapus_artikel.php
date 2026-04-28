<?php
include 'koneksi.php';
/** @var mysqli $conn */

$id = $_POST['id'];

$res = mysqli_query($conn, "SELECT gambar FROM artikel WHERE id = $id");
$row = mysqli_fetch_assoc($res);
if (!empty($row['gambar']) && file_exists("uploads_artikel/" . $row['gambar'])) {
    unlink("uploads_artikel/" . $row['gambar']);
}

if(mysqli_query($conn, "DELETE FROM artikel WHERE id = $id")){
    echo "sukses";
} else {
    echo "gagal";
}
?>