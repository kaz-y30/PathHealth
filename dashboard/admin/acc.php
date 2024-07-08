<?php
include "../koneksi.php";

// Ambil ID psikolog dari URL atau formulir
$psychologist_id = $_GET['id'];

// Perbarui status psikolog menjadi 'approved'
$sql = "UPDATE psychologists SET status = 'approved' WHERE psychologist_id = '$psychologist_id'";

if (mysqli_query($conn, $sql)) {
    header("Location: dashboard.php");
} else {
    echo "Terjadi kesalahan: " . mysqli_error($conn);
}

// Tutup koneksi database
mysqli_close($conn);
?>
