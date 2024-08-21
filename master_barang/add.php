<?php
include '../config/db.php';
include('../layout/header.php');

function generateKodeBarang($con)
{
    // Query untuk mendapatkan kode_barang terakhir
    $query = "SELECT kode_barang FROM master_barang ORDER BY kode_barang DESC LIMIT 1";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $lastKodeBarang = $row['kode_barang'];
        $number = (int)substr($lastKodeBarang, 2) + 1;
        $newKodeBarang = 'KB' . str_pad($number, 4, '0', STR_PAD_LEFT);
    } else {
        $newKodeBarang = 'KB0001';
    }

    return $newKodeBarang;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_barang = generateKodeBarang($con);
    $nama_barang = trim($_POST['nama_barang']);
    $harga_jual = trim($_POST['harga_jual']);
    $harga_beli = trim($_POST['harga_beli']);
    $satuan = trim($_POST['satuan']);
    $kategori = trim($_POST['kategori']);

    if (empty($nama_barang)) {
        $errors[] = 'Nama barang tidak boleh kosong.';
    }

    if (!is_numeric($harga_jual) || $harga_jual <= 0) {
        $errors[] = 'Harga jual harus berupa angka dan lebih besar dari 0.';
    }

    if (!is_numeric($harga_beli) || $harga_beli <= 0) {
        $errors[] = 'Harga beli harus berupa angka dan lebih besar dari 0.';
    }

    if (empty($satuan)) {
        $errors[] = 'Satuan tidak boleh kosong.';
    }

    if (empty($kategori)) {
        $errors[] = 'Kategori tidak boleh kosong.';
    }

    if (empty($errors)) {
        $query = "INSERT INTO master_barang (kode_barang, nama_barang, harga_jual, harga_beli, satuan, kategori) 
                               VALUES ('$kode_barang', '$nama_barang', '$harga_jual', '$harga_beli', '$satuan', '$kategori')";
        $result = mysqli_query($con, $query);

        if ($result) {
            header("Location: index.php");
            exit();
        } else {
            echo "Terjadi kesalahan: " . mysqli_error($con);
        }
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
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
                        <h1>Tambah Barang</h1>
                        <form action="add.php" method="post">
                            <div class="mb-3">
                                <label>Kode Barang:</label>
                                <input type="text" class="form-control" name="kode_barang" value="<?php echo generateKodeBarang($con); ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label>Nama Barang:</label>
                                <input type="text" class="form-control" name="nama_barang" required>
                            </div>
                            <div class="mb-3">
                                <label>Harga Jual:</label>
                                <input type="number" class="form-control" name="harga_jual" required>
                            </div>
                            <div class="mb-3">
                                <label>Harga Beli:</label>
                                <input type="number" class="form-control" name="harga_beli" required>
                            </div>
                            <div class="mb-3">
                                <label>Satuan:</label>
                                <input type="text" class="form-control" name="satuan" required>
                            </div>

                            <div class="mb-3">
                                <label>Kategori:</label>
                                <input type="text" class="form-control" name="kategori" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Tambah</button>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include '../layout/footer.php' ?>