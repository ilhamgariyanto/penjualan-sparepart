<?php
// master_barang/index.php
require_once(__DIR__ . '/../config/db.php');
$judul = 'Master Barang';
include('../layout/header.php');


$query = "SELECT * FROM master_barang";
$result = mysqli_query($con, $query);

// Memeriksa apakah query berhasil dijalankan
if (!$result) {
    die("Error: " . mysqli_error($con));
}
?>

<div class="page-wrapper">
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl d-flex flex-column justify-content-center">
            <div class="card">
                <div class="card-header">
                    <h1>Master Barang</h1>
                </div>
                <div class="card-body">
                    <a href="add.php" class="btn btn-sm btn-primary">Tambah Barang</a>

                    <table class="table table-border">
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga Jual</th>
                            <th>Harga Beli</th>
                            <th>Satuan</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row['kode_barang'] ?></td>
                                <td><?= $row['nama_barang'] ?></td>
                                <td><?= $row['harga_jual'] ?></td>
                                <td><?= $row['harga_beli'] ?></td>
                                <td><?= $row['satuan'] ?></td>
                                <td><?= $row['kategori'] ?></td>
                                <td>
                                    <a href="edit.php?kode=<?= $row['kode_barang'] ?>">Edit</a> |
                                    <a href="hapus.php?kode=<?= $row['kode_barang'] ?>" onclick="return confirm('Apakah Anda yakin?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../layout/footer.php'); ?>