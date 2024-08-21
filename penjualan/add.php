<?php

include '../config/db.php';
include('../layout/header.php');

function generate_no_faktur($con)
{
    $prefix = 'NF';
    $query = "SELECT no_faktur FROM penjualan ORDER BY no_faktur DESC LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $last_no_faktur = $row['no_faktur'];
        $last_number = (int)substr($last_no_faktur, strlen($prefix));
        $new_number = $last_number + 1;
    } else {
        $new_number = 1;
    }

    $new_no_faktur = $prefix . str_pad($new_number, 4, '0', STR_PAD_LEFT);
    return $new_no_faktur;
}

$no_faktur = generate_no_faktur($con);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tgl_faktur = $_POST['tgl_faktur'];
    $nama_konsumen = $_POST['nama_konsumen'];
    $kode_barang = $_POST['kode_barang'];
    $jumlah = $_POST['jumlah'];


    $tgl_faktur = mysqli_real_escape_string($con, $tgl_faktur);
    $no_faktur = mysqli_real_escape_string($con, $no_faktur);
    $nama_konsumen = mysqli_real_escape_string($con, $nama_konsumen);
    $kode_barang = mysqli_real_escape_string($con, $kode_barang);
    $jumlah = (int) $jumlah;

    $query = "SELECT harga_jual FROM master_barang WHERE kode_barang = '$kode_barang'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $harga_satuan = $row['harga_jual'];
    } else {
        echo "Kode barang tidak ditemukan.";
        exit;
    }

    $harga_total = $harga_satuan * $jumlah;
    $query = "INSERT INTO penjualan (tgl_faktur, no_faktur, nama_konsumen, kode_barang, jumlah, harga_satuan, harga_total) 
              VALUES ('$tgl_faktur', '$no_faktur', '$nama_konsumen', '$kode_barang', $jumlah, $harga_satuan, $harga_total)";

    if (mysqli_query($con, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

$query = "SELECT kode_barang, nama_barang FROM master_barang";
$result = mysqli_query($con, $query);
$barang_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="page-wrapper">
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl d-flex flex-column justify-content-center">
            <div class="card">
                <div class="card-header">
                    <h1>Tambah Penjualan</h1>
                </div>
                <div class="card-body">
                    <div class="col-md-6">
                        <form action="add.php" method="post">
                            <div class="mb-3">
                                <label>Tgl Faktur:</label>
                                <input type="date" class="form-control" name="tgl_faktur" required>
                            </div>
                            <div class="mb-3">
                                <label>No Faktur:</label>
                                <input type="text" class="form-control" name="no_faktur" value="<?= htmlspecialchars($no_faktur) ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label>Nama Konsumen:</label>
                                <input type="text" class="form-control" name="nama_konsumen" required>
                            </div>
                            <div class="mb-3">
                                <label>Kode Barang:</label>
                                <select name="kode_barang" class="form-control" required>
                                    <?php foreach ($barang_list as $barang): ?>
                                        <option value="<?= htmlspecialchars($barang['kode_barang']) ?>">
                                            <?= htmlspecialchars($barang['nama_barang']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Jumlah:</label>
                                <input type="number" class="form-control" name="jumlah" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>