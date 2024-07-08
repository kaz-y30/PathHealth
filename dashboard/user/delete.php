<?php
session_start();
include "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $consultation_id = $_POST['consultation_id'];

    $query = "DELETE FROM consultations WHERE consultation_id = '$consultation_id'";
    if (mysqli_query($conn, $query)) {
        echo 'Jadwal Berhasil Dihapus';
    } else {
        echo 'Gagal menghapus data';
    }
}

mysqli_close($conn);
?>
