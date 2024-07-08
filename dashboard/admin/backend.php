<?php
include "../koneksi.php";

$functionName = htmlspecialchars($_GET['functionName']);

switch($functionName) {
    case 'getDataPsikolog':
        getDataPsikolog();
        break;
    case 'getDataPatient':
        getDataPatient();
        break;
    case 'getProvData':
        getProvData();
        break;
    case 'getSeverityLevels':
        getSeverityLevels();
        break;
    case 'getPotentialDiagnosisData':
        getPotentialDiagnosisData();
        break;
    default:
        echo json_encode([]);
        break;
}

function getDataPsikolog() {
    global $conn;

    $data = [];
    $query = mysqli_query($conn, "SELECT specialties FROM psychologists");

    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }
    echo json_encode($data);
}

function getDataPatient() {
    global $conn;

    $data1 = [];
    $query1 = mysqli_query($conn, "SELECT status FROM consultations");

    while ($row1 = mysqli_fetch_assoc($query1)) {
        $data1[] = $row1;
    }
    echo json_encode($data1);
}

function getProvData() {
    global $conn;

    $data = [];
    $query = mysqli_query($conn, "SELECT w.provinsi, 
                            COUNT(DISTINCT u.user_id) AS jumlah_user, 
                            COUNT(DISTINCT p.psychologist_id) AS jumlah_psikolog
                                FROM wilayah w
                                LEFT JOIN users u ON w.id_wilayah = u.id_wilayah
                                LEFT JOIN psychologists p ON w.id_wilayah = p.id_wilayah
                                GROUP BY w.provinsi
    ");

    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }
    echo json_encode($data);
}

function getSeverityLevels() {
    global $conn;

    $data = [];
    $query = mysqli_query($conn, "SELECT severity_level, COUNT(*) as count FROM mentalhealthtests GROUP BY severity_level");

    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }
    echo json_encode($data);
}

function getPotentialDiagnosisData() {
    global $conn;

    $data = [];
    $query = mysqli_query($conn, "SELECT potential_diagnosis FROM mentalhealthtests");

    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }
    echo json_encode($data);
}


mysqli_close($conn);
