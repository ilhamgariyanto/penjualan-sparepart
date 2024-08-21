<?php
require_once(__DIR__ . '/../config/db.php');
$judul = 'Penjualan';
include('../layout/header.php');

$query = "SELECT * FROM penjualan";
$result = mysqli_query($con, $query);

if ($result) {
    $penjualan = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "Error: " . mysqli_error($con);
    exit;
}
?>

<div class="page-wrapper">
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl d-flex flex-column justify-content-center">
            <div class="card">
                <div class="card-header">
                    <h1>Daftar Penjualan</h1>
                </div>
                <div class="card-body">
                    <a href="add.php" class="btn btn-sm btn-primary">Tambah Penjualan</a>

                    <table class="table table-border">
                        <tr>
                            <th>Tgl Faktur</th>
                            <th>No Faktur</th>
                            <th>Nama Konsumen</th>
                            <th>Kode Barang</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Harga Total</th>
                        </tr>
                        <?php if (!empty($penjualan)): ?>
                            <?php foreach ($penjualan as $row): ?>
                                <tr>
                                    <td><?= $row['tgl_faktur'] ?></td>
                                    <td><?= $row['no_faktur'] ?></td>
                                    <td><?= $row['nama_konsumen'] ?></td>
                                    <td><?= $row['kode_barang'] ?></td>
                                    <td><?= $row['jumlah'] ?></td>
                                    <td><?= $row['harga_satuan'] ?></td>
                                    <td><?= $row['harga_total'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">Tidak ada data penjualan.</td>
                            </tr>
                        <?php endif; ?>
                    </table>

                    <?php include('../layout/footer.php'); ?>