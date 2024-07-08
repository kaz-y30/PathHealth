<?php
session_start();
include "../koneksi.php";

// Periksa apakah pengguna telah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

// Ambil user_id dari sesi
$user_id = $_SESSION['user_id'];

// Masukkan autoload Composer
require '../../vendor/autoload.php';

use LucianoTonet\GroqPHP\Groq;

$response = '';

try {
    $groq = new Groq('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');

    if (!empty($_POST['message'])) {
        $userMessage = htmlspecialchars($_POST['message']);

        // Ambil data dari database sesuai dengan pertanyaan
        $contextData = '';

        if (strpos($userMessage, 'jadwal konsultasi') !== false) {
            // Mengambil jadwal konsultasi dengan JOIN
            $stmt = $conn->prepare("SELECT c.scheduled_date, c.status FROM consultations c JOIN users u ON c.user_id = u.user_id WHERE u.user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $contextData .= "Tanggal: " . $row['scheduled_date'] . " - Status: " . $row['status'] ;
                }
            } else {
                $contextData = "Tidak ada jadwal konsultasi yang ditemukan.";
            }
            $stmt->close();
        } elseif (strpos($userMessage, 'data kesehatan mental') !== false || strpos($userMessage, 'skor kesehatan mental') !== false || strpos($userMessage, 'skor') !== false) {
            // Mengambil data kesehatan mental dengan JOIN
            $stmt = $conn->prepare("SELECT m.test_date, m.score, m.severity_level, m.potential_diagnosis FROM mentalhealthtests m JOIN users u ON m.user_id = u.user_id WHERE u.user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $contextData .= "Tanggal Tes: " . $row['test_date'] . "Skor: " . $row['score'] . "Tingkat Keparahan: " . $row['severity_level'] . "Potensi Diagnosis: " . $row['potential_diagnosis'] ;
                }
            } else {
                $contextData = "Tidak ada data kesehatan mental yang ditemukan.";
            }
            $stmt->close();
        } elseif (strpos($userMessage, 'psikolog') !== false) {
            // Contoh: mengambil data psikolog dari database
            $stmt = $conn->prepare("SELECT p.full_name, p.qualifications FROM psychologists p JOIN consultations c ON p.psychologist_id = c.psychologist_id WHERE c.user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $contextData .= "Nama Psikolog: " . $row['full_name'] . "Kualifikasi: " . $row['qualifications'] ;
                }
            } else {
                $contextData = "Tidak ada data psikolog yang ditemukan.";
            }
            $stmt->close();
        } elseif (strpos($userMessage, 'catatan psikolog') !== false) {
            // Contoh: mengambil catatan psikolog dari database
            $stmt = $conn->prepare("SELECT n.note, n.created_at FROM psychologistsnotes n JOIN consultations c ON n.consultation_id = c.consultation_id WHERE c.user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $contextData .= "Catatan: " . $row['note'] . "Dibuat pada: " . $row['created_at'] ;
                }
            } else {
                $contextData = "Tidak ada catatan psikolog yang ditemukan.";
            }
            $stmt->close();
        }

        // Gabungkan data konteks dengan pesan pengguna
        $prompt = $contextData . "Pertanyaan pengguna: " . $userMessage;

        // Kirim prompt ke API Groq
        $chatCompletion = $groq->chat()->completions()->create([
            'model'    => 'mixtral-8x7b-32768',
            'messages' => [
                [
                    'role'    => 'user',
                    'content' => $prompt
                ],
            ]
        ]);

        $response = $chatCompletion['choices'][0]['message']['content'];
        $response = stripslashes($response);

        // Simpan percakapan ke database dengan prepared statement
        $stmt = $conn->prepare("INSERT INTO chat (user_id, user_message, bot_response) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $userMessage, $response);
        $stmt->execute();
        $stmt->close();
    }
} catch (Exception $e) {
    $response = 'Kesalahan: ' . $e->getMessage();
}

echo json_encode($response);

$conn->close(); // Tutup koneksi

