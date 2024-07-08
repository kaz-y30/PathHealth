<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../koneksi.php';

// Query untuk mendapatkan jumlah user dan psikolog per wilayah
$sql = " SELECT w.provinsi, COUNT(DISTINCT u.user_id) AS jumlah_user, COUNT(DISTINCT p.psychologist_id) AS jumlah_psikolog
            FROM wilayah w
            LEFT JOIN users u ON w.id_wilayah = u.id_wilayah
            LEFT JOIN psychologists p ON w.id_wilayah = p.id_wilayah
            GROUP BY w.provinsi
        ";

$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);

