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
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../style/admin/dashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/collect.js/4.36.1/collect.min.js" integrity="sha512-aub0tRfsNTyfYpvUs0e9G/QRsIDgKmm4x59WRkHeWUc3CXbdiMwiMQ5tTSElshZu2LCq8piM/cbIsNwuuIR4gA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="../../bahan/leaflet.ajax.js"></script>
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
                <h1>Dashboard</h1>
                <p>there is the latest update in the last 7 days, check now</p>
                <div class="summary">
                    <div class="bio">
                        <div class="sub-bio">
                            <div class="bagan">
                                <h3>Psikolog</h3>
                            </div>
                            <div class="bagan">
                                <i class="fa-solid fa-user-secret fa-2x"></i>
                            </div>
                        </div>
                        <div class="skor">
                            <?php
                            $query = mysqli_query($conn, "SELECT COUNT(psychologist_id) as jumlah FROM psychologists");
                            $dataUsers = mysqli_fetch_array($query, MYSQLI_ASSOC);
                            ?>
                            <h2><?php echo $dataUsers['jumlah'];?></h2>
                        </div>
                    </div>
                    <div class="bio">
                        <div class="sub-bio">
                            <div class="bagan">
                                <h3>Pasien</h3>
                            </div>
                            <div class="bagan">
                                <i class="fa-solid fa-user-injured fa-2x"></i>
                            </div>
                        </div>
                        <div class="skor">
                            <?php
                            $query = mysqli_query($conn, "SELECT COUNT(user_id) as jumlah FROM users");
                            $dataUsers = mysqli_fetch_array($query, MYSQLI_ASSOC);
                            ?>
                            <h2><?php echo $dataUsers['jumlah'];?></h2>
                        </div>
                    </div>
                    <div class="bio">
                        <div class="sub-bio">
                            <div class="bagan">
                                <h3>Konsultasi</h3>
                            </div>
                            <div class="bagan">
                                <i class="fa-regular fa-hospital fa-2x"></i>
                            </div>
                        </div>
                        <div class="skor">
                        <?php
                            $queryA = mysqli_query($conn, "SELECT COUNT(consultation_id) as jumlah FROM `consultations` WHERE `status` LIKE '%Completed%';");
                            $pasienCompleted = mysqli_fetch_array($queryA, MYSQLI_ASSOC);

                            $queryB = mysqli_query($conn, "SELECT COUNT(consultation_id) as jumlah FROM `consultations` WHERE `status` LIKE '%Scheduled%';");
                            $pasienSchedule = mysqli_fetch_array($queryB, MYSQLI_ASSOC);
                            ?>
                            <h2><?php echo $pasienCompleted['jumlah']+$pasienSchedule['jumlah'];?></h2>
                        </div>
                    </div>
                    <div class="bio">
                        <div class="sub-bio">
                            <div class="bagan">
                                <h3>Acuh</h3>
                            </div>
                            <div class="bagan">
                                <i class='bx bxs-user-x fa-3x'></i>
                            </div>
                        </div>
                        <div class="skor">
                            <?php
                            $query = mysqli_query($conn, "SELECT COUNT(consultation_id) as jumlah FROM `consultations` WHERE `status` LIKE '%Cancelled%';");
                            $pasienAcuh = mysqli_fetch_array($query, MYSQLI_ASSOC);
                            ?>
                            <h2><?php echo $pasienAcuh['jumlah'];?></h2>
                        </div>
                    </div>
                </div>
                <div class="summary1">
                    <div class="diagnosis">
                        <canvas id="chartLevel"></canvas>
                    </div>
                    <div class="diagnosis">
                        <canvas id="chartDiagnosa"></canvas>
                    </div>
                    <div class="diagnosis">
                        <canvas id="chartPatient"></canvas>
                    </div>
                </div>
            </div>

            <div class="special">
                <canvas id="chartUser"></canvas>
            </div>

            <div class="barProv">
                <canvas id="boxProv"></canvas>
            </div>

            <div class="provinsi">
                <div id="map"></div>
            </div>

        </div>
    </div>
    <script src="psikolog.js"></script>
    <!-- <script src="maping.js"></script> -->
</body>
</html>

<?php mysqli_close($conn); ?>