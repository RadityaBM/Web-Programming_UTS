<?php
include 'koneksi.php';
/** @var mysqli $conn */

$query = "SELECT * FROM kategori_artikel ORDER BY id DESC";
$result = mysqli_query($conn, $query);

echo '<div class="d-flex justify-content-between align-items-center mb-3">';
echo '<h4>Data Kategori Artikel</h4>';
echo '<button class="btn btn-success" onclick="showModalTambahKategori()">+ Tambah Kategori</button>';
echo '</div>';

echo '<table class="table table-bordered table-hover bg-white">';
echo '<thead class="table-light"><tr><th>NAMA KATEGORI</th><th>KETERANGAN</th><th>AKSI</th></tr></thead>';
echo '<tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['nama_kategori']) . '</td>';
    echo '<td>' . htmlspecialchars($row['keterangan']) . '</td>';
    echo '<td>
            <button class="btn btn-primary btn-sm" onclick="editKategori('.$row['id'].')">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="hapusKategori('.$row['id'].')">Hapus</button>
          </td>';
    echo '</tr>';
}
echo '</tbody></table>';
?>