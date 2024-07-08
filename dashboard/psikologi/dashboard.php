<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['psychologist_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$psychologist_id = $_SESSION['psychologist_id'];
$full_name = $_SESSION['full_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../style/psikolog/dashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/collect.js/4.36.1/collect.min.js" integrity="sha512-aub0tRfsNTyfYpvUs0e9G/QRsIDgKmm4x59WRkHeWUc3CXbdiMwiMQ5tTSElshZu2LCq8piM/cbIsNwuuIR4gA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        let psychologist_id = <?php echo json_encode($psychologist_id); ?>;
    </script>
</head>
<body onload="getData()">
    <div class="page">
        <div class="navbar">
            <div class="logo"><img src="../../asset/logo2.png" alt=""></div>
            <div class="dashboard"><i class='fas fa-qrcode '></i><a href="dashboard.php">Dashboard</a></div>
            <div class="daftarPsikolog"><i class="fa-solid fa-users"></i><a href="daftarPasien.php">Daftar Pasien</a></div>
            <div class="jadwal"><i class="fa-regular fa-calendar"></i><a href="jadwalKonsultasi.php">Jadwal Konsultasi</a></div>
            <div class="jadwal"><i class="fa-solid fa-right-from-bracket"></i><a href="../login/login.php">Logout</a></div>
        </div>
        <div class="main">
            <div class="container">   
                <div class="profil">
                    <div class="user"><h4>Hello <?php echo $full_name; ?></h4></div>
                </div>         
            </div>
            <div class="menu">
                <h1>Dashboard</h1>
                <p>there is the latest update in the last 7 days, check now</p>
                <div class="summary">
                    <div class="bio">
                        <div class="sub-bio">
                            <div class="bagan">
                                <h3>Total Pasien</h3>
                            </div>
                            <div class="bagan">
                                <i class="fa-solid fa-hospital-user fa-2x"></i>
                            </div>
                        </div>
                        <div class="skor">
                            <?php
                            $query = mysqli_query($conn, "SELECT COUNT(DISTINCT user_id) as jumlah FROM consultations WHERE psychologist_id = $psychologist_id");
                            $totalPasien = mysqli_fetch_array($query, MYSQLI_ASSOC);
                            ?>
                            <h2><?php echo $totalPasien['jumlah'];?></h2>
                        </div>
                    </div>
                    <div class="bio">
                        <div class="sub-bio">
                            <div class="bagan">
                                <h3>Pasien Sembuh</h3>
                            </div>
                            <div class="bagan">
                                <i class='bx bxs-user-check fa-3x'></i>
                            </div>
                        </div>
                        <div class="skor">
                            <?php
                            $query = mysqli_query($conn, "SELECT COUNT(consultation_id) as jumlah FROM consultations WHERE status LIKE '%Completed%' AND psychologist_id = $psychologist_id");
                            $pasienSembuh = mysqli_fetch_array($query, MYSQLI_ASSOC);
                            ?>
                            <h2><?php echo $pasienSembuh['jumlah'];?></h2>
                        </div>
                    </div>
                    <div class="bio">
                        <div class="sub-bio">
                            <div class="bagan">
                                <h3>Dalam Penanganan</h3>
                            </div>
                            <div class="bagan">
                                <i class="fa-solid fa-bed-pulse fa-2x"></i>
                            </div>
                        </div>
                        <div class="skor">
                            <?php
                            $query = mysqli_query($conn, "SELECT COUNT(consultation_id) as jumlah FROM consultations WHERE status LIKE '%Scheduled%' AND psychologist_id = $psychologist_id");
                            $pasienDalamPenanganan = mysqli_fetch_array($query, MYSQLI_ASSOC);
                            ?>
                            <h2><?php echo $pasienDalamPenanganan['jumlah'];?></h2>
                        </div>
                    </div>
                    <div class="bio">
                        <div class="sub-bio">
                            <div class="bagan">
                                <h3>Tidak Melanjutkan</h3>
                            </div>
                            <div class="bagan">
                                <i class="fa-solid fa-user-minus fa-2x"></i>
                            </div>
                        </div>
                        <div class="skor">
                            <?php
                            $query = mysqli_query($conn, "SELECT COUNT(consultation_id) as jumlah FROM consultations WHERE status LIKE '%Cancelled%' AND psychologist_id = $psychologist_id");
                            $pasienTidakMelanjutkan = mysqli_fetch_array($query, MYSQLI_ASSOC);
                            ?>
                            <h2><?php echo $pasienTidakMelanjutkan['jumlah'];?></h2>
                        </div>
                    </div>
                </div>
                <div class="summary1">
                    <div class="grafik">
                        <canvas id="diagnosaPatient"></canvas>
                    </div>
                    <div class="test">
                        <canvas id="chartPatient"></canvas>
                    </div>
                </div>
            </div>
            <div class="patient">
                <div class="sub">
                    <div class="box-sub">
                        <h5>All Patient</h5>
                    </div>
                    <div class="box-sub1">
                        <form method="POST">
                            <i class='bx bx-search-alt-2'>
                                <input type="search" id="gsearch" name="gsearch" placeholder="Cari Pasien">
                            </i>
                            <button type="submit" name="search"></button>
                        </form>
                    </div>
                </div>
                <div class="data">
                    <div class="card">
                        <div class="table">
                            <table class="bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Born</th>
                                        <th>Created Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $searchQuery = "";
                                    if (isset($_POST['search'])) {
                                        $searchQuery = $_POST['gsearch'];
                                    }

                                    $query = "SELECT psychologists.psychologist_id, users.user_id, users.full_name, users.gender, users.date_of_birth, consultations.status, consultations.created_at
                                            FROM consultations 
                                            JOIN users ON consultations.user_id = users.user_id
                                            JOIN psychologists ON consultations.psychologist_id = psychologists.psychologist_id
                                            WHERE consultations.psychologist_id = $psychologist_id";

                                    if ($searchQuery != "") {
                                        $query .= " AND (consultations.user_id LIKE '%$searchQuery%' OR users.full_name LIKE '%$searchQuery%')";
                                    }

                                     // Debug: Menampilkan query untuk pengecekan
                                     echo "<!-- Query: $query -->";

                                     $result = mysqli_query($conn, $query);
 
                                     if (!$result) {
                                         // Debug: Menampilkan error jika query gagal
                                         echo "<!-- Error: " . mysqli_error($conn) . " -->";
                                     }

                                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    ?>
                                    <tr>
                                        <th><?php echo $i++;?></th>
                                        <th><?php echo $row['full_name'];?></th>
                                        <th><?php echo $row['gender'];?></th>
                                        <th><?php echo $row['date_of_birth'];?></th>
                                        <th><?php echo $row['created_at'];?></th>
                                        <th class="status"><?php echo $row['status'];?></th>
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
        </div>
    </div>
    <script src="chart.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>
