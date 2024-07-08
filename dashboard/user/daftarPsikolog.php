<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$full_name = $_SESSION['full_name'];

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 20;
$offset = ($page - 1) * $records_per_page;

$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM psychologists");
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $records_per_page);

$result = mysqli_query($conn, "SELECT * FROM psychologists LIMIT $offset, $records_per_page");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Psikolog</title>
    <link rel="stylesheet" href="../../style/user/daftarPsikolog.css">
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
                <h1>Daftar Psikolog</h1>
                <p>there is the latest update in the last 7 days, check now</p>
                <div class="box">
                    <?php
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                    {
                    ?>
                    <div class="box-barang">
                        <img src="../../asset/psikolog/<?php echo $row['profile_picture'];?>"  alt="">
                        <div class="info">
                            <div class="text">
                                <h2><?php echo $row['full_name'];?></h2>
                            </div>
                            <div class="text1">
                                <p><?php echo $row['specialties'];?></p>
                            </div>
                            <div class="deskripsi">
                                <p><?php echo $row['description'];?></p>
                            </div>
                            <form method="POST" action="pilihPsikolog.php">
                                <input type="hidden" name="psychologist_id" value="<?php echo $row['psychologist_id']; ?>">
                                <button type="submit">Pilih Psikolog</button>
                            </form>
                            <br>
                        </div>
                    </div>  
                    <?php
                    }
                    ?>                     
                </div>
                <div class="pagination">
                    <?php if($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
                    <?php endif; ?>
                    <?php
                    if ($total_pages <= 10) {
                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo "<a href='?page=" . $i . "' " . ($i == $page ? "class='active'" : "") . ">" . $i . "</a>";
                        }
                    } else {
                        if ($page <= 4) {
                            for ($i = 1; $i <= 5; $i++) {
                                echo "<a href='?page=" . $i . "' " . ($i == $page ? "class='active'" : "") . ">" . $i . "</a>";
                            }
                            echo "<a>...</a>";
                            echo "<a href='?page=" . $total_pages . "'>" . $total_pages . "</a>";
                        } elseif ($page > 4 && $page < $total_pages - 4) {
                            echo "<a href='?page=1'>1</a>";
                            echo "<a>...</a>";
                            for ($i = $page - 2; $i <= $page + 2; $i++) {
                                echo "<a href='?page=" . $i . "' " . ($i == $page ? "class='active'" : "") . ">" . $i . "</a>";
                            }
                            echo "<a>...</a>";
                            echo "<a href='?page=" . $total_pages . "'>" . $total_pages . "</a>";
                        } else {
                            echo "<a href='?page=1'>1</a>";
                            echo "<a>...</a>";
                            for ($i = $total_pages - 4; $i <= $total_pages; $i++) {
                                echo "<a href='?page=" . $i . "' " . ($i == $page ? "class='active'" : "") . ">" . $i . "</a>";
                            }
                        }
                    }
                    ?>

                    <?php if($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>
