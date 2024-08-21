<?php
include '../config/db.php';
include('../layout/header.php');


$kode_barang = $_GET['kode'];

$query = "SELECT * FROM master_barang WHERE kode_barang='$kode_barang'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $barang = mysqli_fetch_assoc($result);
} else {
    echo "Data barang tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $satuan = $_POST['satuan'];
    $kategori = $_POST['kategori'];

    $query = "UPDATE master_barang SET nama_barang='$nama_barang', harga_jual='$harga_jual', harga_beli='$harga_beli', satuan='$satuan', kategori='$kategori' WHERE kode_barang='$kode_barang'";

    if (mysqli_query($con, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
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
                    <div class="col-md-6">
                        <h1>Edit Barang</h1>
                        <form action="edit.php?kode=<?= $kode_barang ?>" method="post">
                            <div class="mb-3">

                            </div>
                            <div class="mb-3">
                                <label>Kode Barang:</label>
                                <input type="text" class="form-control" name="kode_barang" value="<?= $barang['kode_barang'] ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label>Nama Barang:</label><br>
                                <input type="text" class="form-control" name="nama_barang" value="<?= $barang['nama_barang'] ?>" required><br>
                            </div>
                            <div class="mb-3">
                                <label>Harga Jual:</label><br>
                                <input type="number" class="form-control" name="harga_jual" value="<?= $barang['harga_jual'] ?>" required><br>
                            </div>
                            <div class="mb-3">
                                <label>Harga Beli:</label><br>
                                <input type="number" class="form-control" name="harga_beli" value="<?= $barang['harga_beli'] ?>" required><br>
                            </div>
                            <div class="mb-3">
                                <label>Satuan:</label><br>
                                <input type="text" class="form-control" name="satuan" value="<?= $barang['satuan'] ?>" required><br>
                            </div>
                            <div class="mb-3">
                                <label>Kategori:</label><br>
                                <input type="text" class="form-control" name="kategori" value="<?= $barang['kategori'] ?>" required><br><br>
                            </div>
                            <button type="submit" class="btn btn-primary"> Update </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>