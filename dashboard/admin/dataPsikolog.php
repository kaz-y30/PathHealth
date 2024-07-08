<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$full_name = $_SESSION['full_name'];

$psychologist_id = $_GET['psychologist_id'];

if (!isset($psychologist_id)) {
    echo "Psikolog ID tidak ditemukan.";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Psikolog</title>
    <link rel="stylesheet" href="../../style/psikolog/data.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/collect.js/4.36.1/collect.min.js" integrity="sha512-aub0tRfsNTyfYpvUs0e9G/QRsIDgKmm4x59WRkHeWUc3CXbdiMwiMQ5tTSElshZu2LCq8piM/cbIsNwuuIR4gA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        let psychologist_id = <?php echo json_encode($psychologist_id); ?>;
    </script>
<body onload=getData()>
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
                <h1>Laporan</h1>
            </div>
            <div class="box">
                <div class="patient">
                    <div class="sub">
                        <h2>Data</h2>
                    </div>
                    <div class="data">
                        <div class="card">
                            <div class="table">
                                <table class="bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Experience</th>
                                            <th>Specialist</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Ambil ID psikolog dari URL
                                        if (isset($_GET['psychologist_id'])) {
                                            $psychologist_id = $_GET['psychologist_id'];

                                            // Query untuk mengambil data psikolog berdasarkan ID
                                            $result = mysqli_query($conn, "SELECT * FROM psychologists WHERE psychologist_id = $psychologist_id");

                                            // Cek apakah data ditemukan
                                            if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                                $i = 1
                                        ?>
                                        <tr>
                                            <th><?php echo $i++;?></th>
                                            <th><?php echo $row['psychologist_id']; ?></th>
                                            <th><?php echo $row['full_name'];?></th>
                                            <th><?php echo $row['username']; ?></th>
                                            <th class="skor"><?php echo $row['experience_years'];?></th>
                                            <th class="aksi"><?php echo $row['specialties'];?></th>
                                        </tr>
                                        <?php
                                        }
                                        }
                                        ?>  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>                    
                <div class="history">
                    <canvas id="report"></canvas>
                </div>
            </div>          
        </div>
    </div>
    <script src="detailPsikolog.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>