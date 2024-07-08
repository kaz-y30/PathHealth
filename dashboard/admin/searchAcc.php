<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$full_name = $_SESSION['full_name'];

$search_query_psikolog = "";
if (isset($_POST['gsearch_psikolog'])) {
    $search_query_psikolog = $_POST['gsearch_psikolog'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="../../style/admin/search.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="page">
        <div class="navbar">
            <div class="logo"><img src="../../asset/logo1.png" alt=""></div>
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
                <h1>Search Results for "<?php echo htmlspecialchars($search_query_psikolog); ?>"</h1>
            </div>
            <div class="patient">
                <div class="sub">
                    <div class="box-sub">
                        <h5>All Psikolog</h5>
                    </div>
                    <div class="box-sub1">
                        <form action="searchPsikolog.php" method="POST">
                            <i class='bx bx-search-alt-2' >
                                <input type="search" id="gsearch_psikolog" name="gsearch_psikolog" placeholder="Searching" value="<?php echo htmlspecialchars($search_query_psikolog); ?>">
                            </i>
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
                                        <th>Email</th>
                                        <th>Specialist</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                    $i = 1;
                                    $sql1 = "SELECT * FROM psychologists WHERE status = 'pending'";

                                    if (!empty($search_query_psikolog)) {
                                        $sql1 .= " AND full_name LIKE '%" . mysqli_real_escape_string($conn, $search_query_psikolog) . "%'";
                                    }

                                    $result_psikolog = mysqli_query($conn, $sql1);

                                    if (!$result_psikolog) {
                                        die("Query Error: " . mysqli_error($conn));
                                    }

                                    while($row = mysqli_fetch_array($result_psikolog, MYSQLI_ASSOC)) {
                                    ?>
                                    <tr>
                                        <th><?php echo $i++; ?></th>
                                        <th><?php echo $row['full_name']; ?></th>
                                        <th><?php echo $row['email']; ?></th>
                                        <th class="aksi"><?php echo $row['specialties']; ?></th>
                                        <th>
                                            <a href="approve_psychologists.php?id={$row['psychologist_id']}">Accept</a>
                                        </th>
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
</body>
</html>

<?php mysqli_close($conn); ?>
