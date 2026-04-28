<?php
include 'koneksi.php';
/** @var mysqli $conn */

$judul = $_POST['judul'];
$id_penulis = $_POST['id_penulis'];
$id_kategori = $_POST['id_kategori'];
$isi = $_POST['isi'];

date_default_timezone_set('Asia/Jakarta');
$hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$bulan = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
];
$sekarang = new DateTime();
$nama_hari = $hari[$sekarang->format('w')];
$tanggal = $sekarang->format('j');
$nama_bulan = $bulan[(int)$sekarang->format('n')];
$tahun = $sekarang->format('Y');
$jam = $sekarang->format('H:i');
$hari_tanggal = "$nama_hari, $tanggal $nama_bulan $tahun | $jam";

$gambar_nama = "";
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
    $gambar_nama = time() . "_" . basename($_FILES['gambar']['name']);
    move_uploaded_file($_FILES['gambar']['tmp_name'], "uploads_artikel/" . $gambar_nama);
}

$stmt = $conn->prepare("INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iissss", $id_penulis, $id_kategori, $judul, $isi, $gambar_nama, $hari_tanggal);
echo $stmt->execute() ? "sukses" : "gagal";
?>