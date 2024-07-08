<?php
include "../koneksi.php";

if (isset($_POST['user_id']) && isset($_POST['notes']) && isset($_POST['scheduled_date'])) {

    $user_id = $_POST['user_id'];
    $notes = $_POST['notes'];
    $scheduled_date = $_POST['scheduled_date'];
    $status = 'scheduled'; // atau sesuai kebutuhan Anda
    $created_at = date("Y-m-d H:i:s"); // Mendapatkan waktu saat ini

    $query = "INSERT INTO consultations (user_id, psychologist_id, scheduled_date, status, notes, created_at) VALUES ('$user_id', '1', '$scheduled_date', '$status', '$notes', '$created_at')";
    
    if (mysqli_query($conn, $query)) {
        echo 'Simpan Sukses';
    } else {
        echo 'Gagal menyimpan data: ' . mysqli_error($conn);
    }
}
?>
