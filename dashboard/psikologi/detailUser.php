<?php
include "../koneksi.php";

$functionName = htmlspecialchars($_GET['functionName']);
$user_id = htmlspecialchars($_GET['user_id']);

switch($functionName) {
    case 'getMentalHealthScores':
        getMentalHealthScores($user_id);
        break;
    default:
        echo json_encode([]);
        break;
}

function getMentalHealthScores($user_id) {
    global $conn;

    $data3 = [];
    $query3 = mysqli_query($conn, "SELECT mentalhealthtests.score
                                   FROM users 
                                   JOIN consultations ON users.user_id = consultations.user_id
                                   JOIN mentalhealthtests ON users.user_id = mentalhealthtests.user_id
                                   WHERE users.user_id = '$user_id'");

    while ($row3 = mysqli_fetch_assoc($query3)) {
        $data3[] = $row3;
    }
    echo json_encode($data3);
    // Debugging
    error_log("Mental health scores for user_id $user_id: " . json_encode($data3));
}
mysqli_close($conn);

