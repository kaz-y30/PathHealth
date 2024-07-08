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
    <title>Pengguna</title>
    <link rel="stylesheet" href="../../style/psikolog/daftarPasien.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <h1>Daftar Pasien</h1>
            </div>
            <div class="patient">
                <div class="sub">
                    <div class="box-sub">
                        <h5>All Patient</h5>
                    </div>
                    <div class="box-sub1">
                        <form action="searchUser.php" method="POST">
                            <i class='bx bx-search-alt-2'>
                                <input type="search" id="gsearch_user" name="gsearch_user" placeholder="Searching">
                            </i>
                        </form>
                    </div>
                </div>
                <form method="GET" action="">
                    <label for="patient_limit">Show:</label>
                    <select name="patient_limit" id="patient_limit" onchange="this.form.submit()">
                        <option value="10" <?php if(isset($_GET['patient_limit']) && $_GET['patient_limit'] == 10) echo 'selected'; ?>>10</option>
                        <option value="25" <?php if(isset($_GET['patient_limit']) && $_GET['patient_limit'] == 25) echo 'selected'; ?>>25</option>
                        <option value="50" <?php if(isset($_GET['patient_limit']) && $_GET['patient_limit'] == 50) echo 'selected'; ?>>50</option>
                        <option value="100" <?php if(isset($_GET['patient_limit']) && $_GET['patient_limit'] == 100) echo 'selected'; ?>>100</option>
                        <option value="all" <?php if(isset($_GET['patient_limit']) && $_GET['patient_limit'] == 'all') echo 'selected'; ?>>All</option>
                    </select>
                </form>
                <div class="data">
                    <div class="card">
                        <div class="table">
                            <table class="bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Date of Birth</th>
                                        <th>Score</th>
                                        <th>Level</th>
                                        <th>Diagnosa</th>
                                        <th>Status</th>
                                        <th>Profil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Set default limit untuk pasien
                                    $patient_limit = 10;
                                    if (isset($_GET['patient_limit'])) {
                                        if ($_GET['patient_limit'] == 'all') {
                                            $patient_limit = '18446744073709551615'; // Maximum possible value for LIMIT
                                        } else {
                                            $patient_limit = (int)$_GET['patient_limit'];
                                        }
                                    }
                                    
                                    $i=1;
                                    $result_patients = mysqli_query($conn, "SELECT users.user_id, users.full_name, users.date_of_birth, mentalhealthtests.score, mentalhealthtests.severity_level, mentalhealthtests.potential_diagnosis, consultations.status
                                                        FROM users 
                                                        JOIN consultations ON users.user_id = consultations.user_id
                                                        JOIN mentalhealthtests ON users.user_id = mentalhealthtests.user_id
                                                        LIMIT $patient_limit");
                                    
                                    while($row = mysqli_fetch_array($result_patients, MYSQLI_ASSOC))
                                    {
                                    ?>
                                    <tr>
                                        <th><?php echo $i++;?></th>
                                        <th><?php echo $row['full_name'];?></th>
                                        <th><?php echo $row['date_of_birth'];?></th>
                                        <th><?php echo $row['score'];?></th>
                                        <th class="skor"><?php echo $row['severity_level'];?></th>
                                        <th class="aksi"><?php echo $row['potential_diagnosis'];?></th>
                                        <th class="status"><?php echo $row['status'];?></th>
                                        <th>
                                            <a href="dataPasien.php?user_id=<?php echo $row['user_id']; ?>">
                                                Detail
                                            </a>
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

            <!-- PSIKOLOG -->
            <div class="menu">
                <h1>Daftar Psikolog</h1>
            </div>
            <div class="patient">
                <div class="sub">
                    <div class="box-sub">
                        <h5>All Psikolog</h5>
                    </div>
                    <div class="box-sub1">
                        <form action="searchPsikolog.php" method="POST">
                            <i class='bx bx-search-alt-2'>
                                <input type="search" id="gsearch_psikolog" name="gsearch_psikolog" placeholder="Searching">
                            </i>
                        </form>
                    </div>
                </div>
                <form method="GET" action="">
                    <label for="psychologist_limit">Show:</label>
                    <select name="psychologist_limit" id="psychologist_limit" onchange="this.form.submit()">
                        <option value="10" <?php if(isset($_GET['psychologist_limit']) && $_GET['psychologist_limit'] == 10) echo 'selected'; ?>>10</option>
                        <option value="25" <?php if(isset($_GET['psychologist_limit']) && $_GET['psychologist_limit'] == 25) echo 'selected'; ?>>25</option>
                        <option value="50" <?php if(isset($_GET['psychologist_limit']) && $_GET['psychologist_limit'] == 50) echo 'selected'; ?>>50</option>
                        <option value="100" <?php if(isset($_GET['psychologist_limit']) && $_GET['psychologist_limit'] == 100) echo 'selected'; ?>>100</option>
                        <option value="all" <?php if(isset($_GET['psychologist_limit']) && $_GET['psychologist_limit'] == 'all') echo 'selected'; ?>>All</option>
                    </select>
                </form>
                <div class="data">
                    <div class="card">
                        <div class="table">
                            <table class="bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Experience</th>
                                        <th>Qualification</th>
                                        <th>Specialist</th>
                                        <th>Profil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Set default limit
                                    // Set default limit untuk psikolog
                                    $psychologist_limit = 10;
                                    if (isset($_GET['psychologist_limit'])) {
                                        if ($_GET['psychologist_limit'] == 'all') {
                                            $psychologist_limit = '18446744073709551615'; // Maximum possible value for LIMIT
                                        } else {
                                            $psychologist_limit = (int)$_GET['psychologist_limit'];
                                        }
                                    }

                                    $i=1;
                                    $result_psychologists = mysqli_query($conn, "SELECT * FROM psychologists LIMIT $psychologist_limit");
                                    while($row = mysqli_fetch_array($result_psychologists, MYSQLI_ASSOC))
                                    {
                                    ?>
                                    <tr>
                                        <th><?php echo $i++;?></th>
                                        <th><?php echo $row['full_name'];?></th>
                                        <th><?php echo $row['experience_years'];?></th>
                                        <th class="skor"><?php echo $row['qualifications'];?></th>
                                        <th class="aksi"><?php echo $row['specialties'];?></th>
                                        <th>
                                            <a href="dataPsikolog.php?psychologist_id=<?php echo $row['psychologist_id']; ?>">
                                                Detail
                                            </a>
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
