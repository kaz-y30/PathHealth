<?php
include "../koneksi.php";

$functionName = htmlspecialchars($_GET['functionName']);
$psychologist_id = htmlspecialchars($_GET['psychologist_id']);

switch($functionName) {
    case 'getDataPatient':
        getDataPatient($psychologist_id);
        break;
        case 'getDiagnosaPatient':
            getDiagnosaPatient($psychologist_id);
            break;
    default:
        echo json_encode([]);
        break;
}

function getDataPatient($psychologist_id) {
    global $conn;

    $data1 = [];
    $query1 = mysqli_query($conn, "SELECT status FROM consultations WHERE psychologist_id = '$psychologist_id'");

    while ($row1 = mysqli_fetch_assoc($query1)) {
        $data1[] = $row1;
    }
    echo json_encode($data1);
}

function getDiagnosaPatient($psychologist_id) {
    global $conn;

    $data2 = [];
    $query2 = mysqli_query($conn, "SELECT mentalhealthtests.potential_diagnosis
                                   FROM users 
                                   JOIN consultations ON users.user_id = consultations.user_id
                                   JOIN mentalhealthtests ON users.user_id = mentalhealthtests.user_id
                                   WHERE consultations.psychologist_id = $psychologist_id");

    while ($row2 = mysqli_fetch_assoc($query2)) {
        $data2[] = $row2;
    }
    echo json_encode($data2);
}


mysqli_close($conn);
