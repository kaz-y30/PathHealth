<?php
include "../koneksi.php";

if (isset($_POST['notes']) && isset($_POST['scheduled_date'])) {

    $notes = $_POST['notes'];
    $scheduled_date = $_POST['scheduled_date'];
    $status = "pending"; // Anda bisa mengubah sesuai kebutuhan
    $created_at = date("Y-m-d H:i:s"); // Mendapatkan waktu saat ini

    $query = "INSERT INTO consultations (user_id, psychologist_id, scheduled_date, status, notes, created_at) VALUES ('1', '1', '$scheduled_date', '$status', '$notes', '$created_at')";
    
    if (mysqli_query($conn, $query)) {
        echo 'Simpan Sukses';
    } else {
        echo 'Gagal menyimpan data: ' . mysqli_error($conn);
    }
}

