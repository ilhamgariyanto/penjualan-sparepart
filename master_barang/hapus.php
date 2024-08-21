<?php
include '../config/db.php';

$kode_barang = $_GET['kode'];

$kode_barang = mysqli_real_escape_string($con, $kode_barang);

$query = "DELETE FROM master_barang WHERE kode_barang = '$kode_barang'";

if (mysqli_query($con, $query)) {
    header("Location: index.php");
    exit;
} else {
    echo "Error deleting record: " . mysqli_error($con);
}
