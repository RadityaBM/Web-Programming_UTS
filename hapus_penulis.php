<?php
include 'koneksi.php';
/** @var mysqli $conn */

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id > 0) {
    $cek = mysqli_query($conn, "SELECT id FROM artikel WHERE id_penulis = $id");
    if (mysqli_num_rows($cek) > 0) {
        echo "terikat";
    } else {
        $res = mysqli_query($conn, "SELECT foto FROM penulis WHERE id = $id");
        $row = mysqli_fetch_assoc($res);

        if (!empty($row['foto']) && file_exists("uploads_penulis/" . $row['foto']) && $row['foto'] != "default.png") {
            unlink("uploads_penulis/" . $row['foto']);
        }

        if (mysqli_query($conn, "DELETE FROM penulis WHERE id = $id")) {
            echo "sukses";
        } else {
            echo "gagal";
        }
    }
} else {
    echo "gagal";
}
?>