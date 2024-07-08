<?php
include "../koneksi.php";

$functionName = htmlspecialchars($_GET['functionName']);
$psychologist_id = htmlspecialchars($_GET['psychologist_id']);

switch($functionName) {
    case 'getDataPatient':
        getDataPatient($psychologist_id);
        break;
    default:
        echo json_encode([]);
        break;
}

function getDataPatient($psychologist_id) {
    global $conn;

    $data = [];
    $query = mysqli_query($conn, "SELECT status FROM consultations WHERE psychologist_id = '$psychologist_id'");

    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }
    echo json_encode($data);
}

mysqli_close($conn);

