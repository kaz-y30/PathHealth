<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$full_name = $_SESSION['full_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <link rel="stylesheet" href="../../style/user/data.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/collect.js/4.36.1/collect.min.js" integrity="sha512-aub0tRfsNTyfYpvUs0e9G/QRsIDgKmm4x59WRkHeWUc3CXbdiMwiMQ5tTSElshZu2LCq8piM/cbIsNwuuIR4gA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        let user_id = <?php echo json_encode($user_id); ?>;
    </script>
<body onload=getData()>
    <div class="page">
        <div class="navbar">
            <div class="logo"><img src="../../asset/logo2.png" alt=""></div>
            <div class="dashboard"><i class='fas fa-qrcode '></i><a href="dashboard.php">Dashboard</a></div>
            <div class="daftarPsikolog"><i class="fa-solid fa-users"></i><a href="daftarPsikolog.php">Daftar Psikolog</a></div>
            <div class="jadwal"><i class="fa-regular fa-calendar"></i><a href="jadwalKonsultasi.php">Jadwal Konsultasi</a></div>
            <div class="laporan"><i class="fa-solid fa-message"></i><a href="chatbot.php">Chatbot</a></div>
            <div class="laporan"><i class='bx bxs-report'></i><a href="report.php">Laporan</a></div>
            <div class="laporan"><i class="fa-solid fa-right-from-bracket"></i><a href="../login/login.php">Logout</a></div>
        </div>
        <div class="main">
            <div class="container">
                <div class="profil">
                    <div class="user"><h4>Hello <?php echo $full_name; ?></h4></div>
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
                                            <th>Tanggal Tes</th>
                                            <th>Age</th>
                                            <th>Rekomendasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $result = mysqli_query($conn, "SELECT users.user_id, users.date_of_birth, users.full_name, consultations.status, mentalhealthtests.test_date, mentalhealthtests.score
                                              FROM users 
                                              JOIN consultations ON users.user_id = consultations.user_id
                                              JOIN mentalhealthtests ON users.user_id = mentalhealthtests.user_id  WHERE users.user_id = '$user_id'");
                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                        {
                                        // Hitung usia
                                        $birthDate = new DateTime($row['date_of_birth']);
                                        $today = new DateTime('today');
                                        $age = $birthDate->diff($today)->y;

                                        // Rekomendasi berdasarkan score
                                        if ($row['score'] > 50) {
                                            $recommendation = "Konsul";
                                        } else {
                                            $recommendation = "Pertahankan Kesehatan Mental Anda";
                                        }
                                        ?>
                                        <tr>
                                            <th><?php echo $i++?></th>
                                            <th><?php echo $row['user_id'];?></th>
                                            <th><?php echo $row['full_name'];?></th>
                                            <th><?php echo $row['test_date'];?></th>
                                            <th><?php echo $age;?></th>
                                            <th class="aksi"><?php echo $recommendation;?></th>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="history">
                    <div class="judul">
                        <h1>Overall Health</h1>
                    </div>
                    <div class="pie">
                        <canvas id="report"></canvas>
                    </div>
                    <div class="statistik">
                        <h3>Statistik Pasien</h3>
                    </div>
                    <div class="desc">
                        <div class="tekanan">
                            <div class="warna">
                                <p></p>
                            </div>
                            <div class="sub">
                                <p>Tekanan</p>
                            </div>
                        </div>
                        <div class="normal">
                            <div class="warna"></div>
                            <div class="sub">
                                <p>Enjoy</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
    <script src="chart.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>