<?php
session_start();
include "../koneksi.php";

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$full_name = $_SESSION['full_name'];

// Ambil hasil tes terbaru pengguna dan rekomendasi terkait
$stmt = $conn->prepare("SELECT t.test_date, t.score, t.severity_level, t.potential_diagnosis, r.recommendation 
                        FROM mentalhealthtests t 
                        LEFT JOIN recommendations r ON t.test_id = r.test_id 
                        WHERE t.user_id = ? 
                        ORDER BY t.test_date DESC 
                        LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$testResult = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../style/user/dashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/collect.js/4.36.1/collect.min.js" integrity="sha512-aub0tRfsNTyfYpvUs0e9G/QRsIDgKmm4x59WRkHeWUc3CXbdiMwiMQ5tTSElshZu2LCq8piM/cbIsNwuuIR4gA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
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
                    <div class="user"><h4>Hallo <?php echo $full_name; ?></h4></div>
                </div>        
            </div>
            <div class="menu">
                <h1>Your latest activity</h1>
                <p>Here is your mental health results are a snapshot of where you are today. Use this insight to guide your path to wellness and seek support when needed.</p>
                <div class="test">
                    <h2>Ingin melakukan test?</h2>
                    <p><a href="test.php" id="testbutton">Klik Disini</a></p>
                </div>
                <div class="summary">
                    <div class="bio">
                        <div class="sub-bio">
                            <div class="bagan">
                                <h3>Skor Kesehatan Mental</h3>
                            </div>
                            <div class="bagan">
                                <i class="fa-sharp fa-solid fa-spa fa-2x"></i>
                            </div>
                        </div>
                        <div class="skor">
                            <?php
                            $query = mysqli_query($conn, "SELECT score FROM mentalhealthtests WHERE user_id = $user_id ORDER BY test_date DESC LIMIT 1");
                            $dataScore = mysqli_fetch_array($query, MYSQLI_ASSOC);
                            ?>
                            <h3>
                                <?php 
                                if (!empty($dataScore['score'])) {
                                    echo $dataScore['score'];
                                } else {
                                    echo "Anda belum melakukan test";
                                }
                                ?>
                            </h3>
                        </div>
                    </div>
                    <div class="bio">
                        <div class="sub-bio">
                            <div class="bagan">
                                <h3>Tingkat Keparahan</h3>
                            </div>
                            <div class="bagan">
                                <i class="fa-solid fa-hand-holding-medical fa-2x"></i>
                            </div>
                        </div>
                        <div class="skor">
                            <?php
                            $query = mysqli_query($conn, "SELECT severity_level FROM mentalhealthtests WHERE user_id = $user_id ORDER BY test_date DESC LIMIT 1");
                            $dataSeverity = mysqli_fetch_array($query, MYSQLI_ASSOC);
                            ?>
                            <h3>
                                <?php 
                                if (!empty($dataSeverity['severity_level'])) {
                                    echo $dataSeverity['severity_level'];
                                } else {
                                    echo "Anda belum melakukan test";
                                }
                                ?>
                            </h3>
                        </div>
                    </div>
                    <div class="bio">
                        <div class="sub-bio">
                            <div class="bagan">
                                <h3>Diagnosis</h3>
                            </div>
                            <div class="bagan">
                                <i class="fa-solid fa-stethoscope fa-2x"></i>
                            </div>
                        </div>
                        <div class="skor">
                            <?php
                            $query = mysqli_query($conn, "SELECT potential_diagnosis FROM mentalhealthtests WHERE user_id = $user_id ORDER BY test_date DESC LIMIT 1");
                            $dataDiagnosis = mysqli_fetch_array($query, MYSQLI_ASSOC);
                            ?>
                            <h3>
                                <?php 
                                if (!empty($dataDiagnosis['potential_diagnosis'])) {
                                    echo $dataDiagnosis['potential_diagnosis'];
                                } else {
                                    echo "Anda belum melakukan test";
                                }
                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="testResult">
                    <h2>Hasil Tes Mental</h2>
                    <?php if (!empty($testResult)): ?>
                        <h3>Rekomendasi</h3>
                        <p><?php echo nl2br($testResult['recommendation']); ?></p>
                    <?php else: ?>
                        <p>Anda belum melakukan tes.</p>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>
