<?php
include "../koneksi.php";

$tampil = mysqli_query($conn, "SELECT * FROM consultations ORDER BY consultation_id");

$dataArr = array();
while($data = mysqli_fetch_assoc($tampil)){
    $dataArr[] = array(
        'id' => $data['consultation_id'],
        'start' => $data['scheduled_date'],
        'title' => $data['notes'], // Title digunakan untuk menampilkan teks pada event
        'status' => $data['status']
    );
}

echo json_encode($dataArr);

