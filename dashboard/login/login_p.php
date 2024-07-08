<?php
session_start();
include "../koneksi.php";

$email = $_POST['email'];
$password = $_POST['password'];

// Cek apakah pengguna adalah admin
$query_admin = "SELECT * FROM admins WHERE email = '$email' AND password = '$password'";
$result_admin = mysqli_query($conn, $query_admin);

if (mysqli_num_rows($result_admin) > 0) {
    $admin_data = mysqli_fetch_assoc($result_admin);
    $_SESSION['admin_id'] = $admin_data['admin_id'];
    $_SESSION['full_name'] = $admin_data['full_name'];
    header("Location: ../admin/dashboard.php");
    exit();
}

// Cek apakah pengguna adalah pengguna biasa
$query_user = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
$result_user = mysqli_query($conn, $query_user);

if (mysqli_num_rows($result_user) > 0) {
    $user_data = mysqli_fetch_assoc($result_user);
    $_SESSION['user_id'] = $user_data['user_id'];
    $_SESSION['full_name'] = $user_data['full_name'];
    header("Location: ../user/dashboard.php");
    exit();
}

// Cek apakah pengguna adalah psikolog
$query_psychologist = "SELECT * FROM psychologists WHERE email = '$email' AND password = '$password'";
$result_psychologist = mysqli_query($conn, $query_psychologist);

if (mysqli_num_rows($result_psychologist) > 0) {
    $psychologist = mysqli_fetch_assoc($result_psychologist);
    if ($psychologist['status'] == 'approved') {
        // Jika login sebagai psikolog yang disetujui
        $_SESSION['psychologist_id'] = $psychologist['psychologist_id'];
        $_SESSION['full_name'] = $psychologist['full_name'];
        header("Location: ../psikologi/dashboard.php");
        exit();
    } else {
        // Jika login sebagai psikolog yang belum disetujui
        header("Location: login.php?error=not_approved");
        exit();
    }
}


// Jika tidak ada yang cocok, arahkan kembali ke halaman login
header("Location: login.php");
exit();

