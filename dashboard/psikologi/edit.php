<?php
include "../koneksi.php";

if (isset($_POST['consultation_id']) && isset($_POST['scheduled_date']) && isset($_POST['notes']) && isset($_POST['status']) && isset($_POST['psychologist_id'])) {

    $id = $_POST['consultation_id'];
    $notes = $_POST['notes'];
    $scheduled_date = $_POST['scheduled_date'];
    $status = $_POST['status'];
    $psychologist_id = $_POST['psychologist_id'];
    $created_at = date("Y-m-d H:i:s");

    $query = "UPDATE consultations SET notes = '$notes', scheduled_date = '$scheduled_date', status = '$status', created_at = '$created_at' WHERE consultation_id = '$id' AND psychologist_id = '$psychologist_id'";

    if (mysqli_query($conn, $query)) {
        echo 'Simpan Sukses';
    } else {
        echo 'Gagal menyimpan data: ' . mysqli_error($conn);
    }
}

