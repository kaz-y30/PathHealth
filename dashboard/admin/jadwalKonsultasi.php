<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$full_name = $_SESSION['full_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Konsultasi</title>
    <link rel="stylesheet" href="../../style/admin/jadwalKonsultasi.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../style/user/fullcalendar.css">
    <script src="../../style/user/jquery.min.js"></script>
    <script src="../../style/user/jquery-ui.min.js"></script>
    <script src="../../style/user/moment.min.js"></script>
    <script src="../../style/user/fullcalendar.min.js"></script>
</head>
</head>
<body>
    <div class="page">
        <div class="navbar">
            <div class="logo"><img src="../../asset/logo2.png" alt=""></div>
            <div class="dashboard"><i class='fas fa-qrcode '></i><a href="dashboard.php">Dashboard</a></div>
            <div class="daftarPsikolog"><i class="fa-solid fa-users"></i><a href="pengguna.php">Pengguna</a></div>
            <div class="jadwal"><i class="fa-regular fa-calendar"></i><a href="jadwalKonsultasi.php">Jadwal Konsultasi</a></div>
            <div class="laporan"><i class="fa-solid fa-message"></i><a href="chatbot.php">Chatbot</a></div>
            <div class="jadwal"><i class="fa-solid fa-right-from-bracket"></i><a href="../login/login.php">Logout</a></div>
        </div>
        <div class="main">
            <div class="container">
                <div class="profil">
                    <div class="user"><h4>Hello <?php echo $full_name; ?></h4></div>
                </div>  
                <div class="notification">
                    <a href="notification.php"><i class="fa-regular fa-bell"></i></a>
                </div>       
            </div>
            <div class="menu">
                <h1>Jadwal Konsultasi</h1>
                <p>Pilih jadwal yang masih kosong, isi tabel sebelah kanan untuk atur jadwal</p>
                <div class="summary">
                    <div class="bio">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="calender.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>