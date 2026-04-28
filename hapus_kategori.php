<?php
include 'koneksi.php';
/** @var mysqli $conn */

$id = $_POST['id'];

$cek = mysqli_query($conn, "SELECT id FROM artikel WHERE id_kategori = $id");
if (mysqli_num_rows($cek) > 0) {
    echo "terikat";
} else {
    mysqli_query($conn, "DELETE FROM kategori_artikel WHERE id = $id");
    echo "sukses";
}
?>