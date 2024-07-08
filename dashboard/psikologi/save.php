<?php
include "../koneksi.php";

if (isset($_POST['notes']) && isset($_POST['scheduled_date']) && isset($_POST['psychologist_id'])) {

    $notes = $_POST['notes'];
    $scheduled_date = $_POST['scheduled_date'];
    $psychologist_id = $_POST['psychologist_id'];
    $status = 'scheduled'; // Anda bisa mengubah sesuai kebutuhan
    $created_at = date("Y-m-d H:i:s"); // Mendapatkan waktu saat ini

    $query = "INSERT INTO consultations (user_id, psychologist_id, scheduled_date, status, notes, created_at) VALUES ('1', '$psychologist_id', '$scheduled_date', '$status', '$notes', '$created_at')";
    
    if (mysqli_query($conn, $query)) {
        echo 'Simpan Sukses';
    } else {
        echo 'Gagal menyimpan data: ' . mysqli_error($conn);
    }
}

