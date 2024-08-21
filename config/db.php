<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "sparepart_db";


$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$con) {
    echo "Koneksi Ke Database gagal" . mysqli_connect_error();
}


// config url
function base_url($url = null)
{
    $base_url = 'http://localhost/penjualan';

    if ($url != null) {
        return rtrim($base_url, '/') . '/' . ltrim($url, '/');
    } else {
        return $base_url;
    }
}
