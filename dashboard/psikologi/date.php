<?php
include "../koneksi.php";

if (isset($_GET['psychologist_id'])) {
    $psychologist_id = $_GET['psychologist_id'];

    $tampil = mysqli_query($conn, "SELECT * FROM consultations WHERE psychologist_id = '$psychologist_id' ORDER BY consultation_id");

    $dataArr = array();
    while ($data = mysqli_fetch_array($tampil)) {
        $dataArr[] = array(
            'id' => $data['consultation_id'],
            'start' => $data['scheduled_date'],
            'status' => $data['status'],
            'title' => $data['notes'],
            'created' => $data['created_at']
        );
    }

    echo json_encode($dataArr);
}

