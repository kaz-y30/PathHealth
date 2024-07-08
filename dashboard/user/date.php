<?php
include "../koneksi.php";

$user_id = $_GET['user_id'];

$tampil = mysqli_query($conn, "SELECT * FROM consultations WHERE user_id = '$user_id' ORDER BY consultation_id");

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
?>
