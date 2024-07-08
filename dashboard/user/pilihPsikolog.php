<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $psychologist_id = $_POST['psychologist_id'];

    // Cek apakah user sudah memiliki konsultasi
    $result = mysqli_query($conn, "SELECT * FROM consultations WHERE user_id = '$user_id'");
    if (mysqli_num_rows($result) > 0) {
        // Dapatkan consultation_id
        $consultation = mysqli_fetch_assoc($result);
        $consultation_id = $consultation['consultation_id'];

        // Update psikolog yang menangani user di tabel consultations
        mysqli_query($conn, "UPDATE consultations SET psychologist_id = '$psychologist_id' WHERE consultation_id = '$consultation_id'");

        // Update psikolog yang menangani user di tabel psychologistsnotes
        mysqli_query($conn, "UPDATE psychologistnotes SET psychologist_id = '$psychologist_id' WHERE consultation_id = '$consultation_id'");
    } else {
        // Buat konsultasi baru dengan psikolog yang dipilih
        $scheduled_date = '0000-00-00'; // Atur tanggal default atau sesuai kebutuhan
        $status = 'pending';
        mysqli_query($conn, "INSERT INTO consultations (user_id, psychologist_id, scheduled_date, status) VALUES ('$user_id', '$psychologist_id', '$scheduled_date', '$status')");
    }

    // Redirect ke halaman jadwal konsultasi
    header("Location: jadwalKonsultasi.php");
    exit();
}

