<?php
session_start();
include "../koneksi.php";

// Periksa apakah pengguna telah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login/login.php");
    exit();
}

// Ambil admin_id dari sesi
$admin_id = $_SESSION['admin_id'];

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

        if (preg_match('/nama psikolog yang menangani (.*)/i', $userMessage, $matches)) {
            $userName = trim($matches[1]);

            // Query untuk mendapatkan psikolog yang menangani pengguna tertentu
            $stmt = $conn->prepare("SELECT p.full_name AS psychologist_name
                    FROM consultations c
                    JOIN users u ON c.user_id = u.user_id
                    JOIN psychologists p ON c.psychologist_id = p.psychologist_id
                    WHERE u.full_name = ?
            ");
            $stmt->bind_param("s", $userName);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $contextData = "Nama psikolog yang menangani $userName adalah " . $row['psychologist_name'];
            } else {
                $contextData = "Tidak ada data psikolog yang menangani $userName ditemukan.";
            }
            $stmt->close();
        } elseif (preg_match('/jadwal konsultasi psikolog (.*)/i', $userMessage, $matches)) {
            $psychologistName = trim($matches[1]);

            // Query untuk mendapatkan jadwal konsultasi berdasarkan psikolog
            $stmt = $conn->prepare("SELECT c.scheduled_date, c.status, u.full_name AS user_name
                FROM consultations c
                JOIN psychologists p ON c.psychologist_id = p.psychologist_id
                JOIN users u ON c.user_id = u.user_id
                WHERE p.full_name = ?
            ");
            $stmt->bind_param("s", $psychologistName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $contextData .= "Tanggal " . $row['scheduled_date'] . " - Status " . $row['status'] . " - Pengguna " . $row['user_name'] . "<br>";
                }
            } else {
                $contextData = "Tidak ada jadwal konsultasi untuk psikolog $psychologistName yang ditemukan.";
            }
            $stmt->close();
        } elseif (preg_match('/jadwal konsultasi user (.*)/i', $userMessage, $matches)) {
            $userName = trim($matches[1]);

            // Query untuk mendapatkan jadwal konsultasi berdasarkan user
            $stmt = $conn->prepare("SELECT c.scheduled_date, c.status, p.full_name AS psychologist_name
                FROM consultations c
                JOIN users u ON c.user_id = u.user_id
                JOIN psychologists p ON c.psychologist_id = p.psychologist_id
                WHERE u.full_name = ?
            ");
            $stmt->bind_param("s", $userName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $contextData .= "Tanggal " . $row['scheduled_date'] . " - Status " . $row['status'] . " - Psikolog " . $row['psychologist_name'] . "<br>";
                }
            } else {
                $contextData = "Tidak ada jadwal konsultasi untuk user $userName yang ditemukan.";
            }
            $stmt->close();
        } elseif (preg_match('/data kesehatan mental user (.*)/i', $userMessage, $matches)) {
            $userName = trim($matches[1]);

            // Query untuk mendapatkan data kesehatan mental berdasarkan user
            $stmt = $conn->prepare("SELECT m.test_date, m.score, m.severity_level, m.potential_diagnosis
                FROM mentalhealthtests m
                JOIN users u ON m.user_id = u.user_id
                WHERE u.full_name = ?
            ");
            $stmt->bind_param("s", $userName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $contextData .= "Tanggal Tes " . $row['test_date'] . " - Skor " . $row['score'] . " - Tingkat Keparahan " . $row['severity_level'] . " - Potensi Diagnosis " . $row['potential_diagnosis'] . "<br>";
                }
            } else {
                $contextData = "Tidak ada data kesehatan mental untuk user $userName yang ditemukan.";
            }
            $stmt->close();
        } elseif (preg_match('/data kesehatan mental psikolog (.*)/i', $userMessage, $matches)) {
            $psychologistName = trim($matches[1]);

            // Query untuk mendapatkan data kesehatan mental berdasarkan psikolog
            $stmt = $conn->prepare("SELECT m.test_date, m.score, m.severity_level, m.potential_diagnosis, u.full_name AS user_name
                FROM mentalhealthtests m
                JOIN consultations c ON m.user_id = c.user_id
                JOIN psychologists p ON c.psychologist_id = p.psychologist_id
                JOIN users u ON m.user_id = u.user_id
                WHERE p.full_name = ?
            ");
            $stmt->bind_param("s", $psychologistName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $contextData .= "Tanggal Tes " . $row['test_date'] . " - Skor " . $row['score'] . " - Tingkat Keparahan " . $row['severity_level'] . " - Potensi Diagnosis " . $row['potential_diagnosis'] . " - Pengguna " . $row['user_name'] . "<br>";
                }
            } else {
                $contextData = "Tidak ada data kesehatan mental untuk psikolog $psychologistName yang ditemukan.";
            }
            $stmt->close();
        } elseif (strpos($userMessage, 'provinsi dengan jumlah user paling banyak') !== false) {
            // Query untuk mendapatkan provinsi dengan jumlah user paling banyak
            $stmt = $conn->prepare("SELECT w.provinsi, COUNT(u.user_id) AS jumlah_user
                FROM users u
                JOIN wilayah w ON u.id_wilayah = w.id_wilayah
                GROUP BY w.provinsi
                ORDER BY jumlah_user DESC
                LIMIT 1
            ");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $contextData = "Provinsi dengan jumlah user paling banyak adalah " . $row['provinsi'] . " dengan " . $row['jumlah_user'] . " user.";
            } else {
                $contextData = "Tidak ada data user ditemukan.";
            }
            $stmt->close();
        } elseif (strpos($userMessage, 'provinsi dengan jumlah user paling sedikit') !== false) {
            // Query untuk mendapatkan provinsi dengan jumlah user paling sedikit
            $stmt = $conn->prepare("SELECT w.provinsi, COUNT(u.user_id) AS jumlah_user
                FROM users u
                JOIN wilayah w ON u.id_wilayah = w.id_wilayah
                GROUP BY w.provinsi
                ORDER BY jumlah_user ASC
                LIMIT 1
            ");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $contextData = "Provinsi dengan jumlah user paling sedikit adalah " . $row['provinsi'] . " dengan " . $row['jumlah_user'] . " user.";
            } else {
                $contextData = "Tidak ada data user ditemukan.";
            }
            $stmt->close();
        } elseif (strpos($userMessage, 'provinsi dengan jumlah psikolog paling banyak') !== false) {
            // Query untuk mendapatkan provinsi dengan jumlah psikolog paling banyak
            $stmt = $conn->prepare("SELECT w.provinsi, COUNT(p.psychologist_id) AS jumlah_psikolog
                FROM psychologists p
                JOIN wilayah w ON p.id_wilayah = w.id_wilayah
                GROUP BY w.provinsi
                ORDER BY jumlah_psikolog DESC
                LIMIT 1
            ");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $contextData = "Provinsi dengan jumlah psikolog paling banyak adalah " . $row['provinsi'] . " dengan " . $row['jumlah_psikolog'] . " psikolog.";
            } else {
                $contextData = "Tidak ada data psikolog ditemukan.";
            }
            $stmt->close();
        } elseif (strpos($userMessage, 'provinsi dengan jumlah psikolog paling sedikit') !== false) {
            // Query untuk mendapatkan provinsi dengan jumlah psikolog paling sedikit
            $stmt = $conn->prepare("SELECT w.provinsi, COUNT(p.psychologist_id) AS jumlah_psikolog
                    FROM psychologists p
                    JOIN wilayah w ON p.id_wilayah = w.id_wilayah
                    GROUP BY w.provinsi
                    ORDER BY jumlah_psikolog ASC
                    LIMIT 1
            ");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $contextData = "Provinsi dengan jumlah psikolog paling sedikit adalah " . $row['provinsi'] . " dengan " . $row['jumlah_psikolog'] . " psikolog.";
            } else {
                $contextData = "Tidak ada data psikolog ditemukan.";
            }
            $stmt->close();
        } elseif (preg_match('/jumlah user di provinsi (.*)/i', $userMessage, $matches)) {
            $provinsi = trim($matches[1]);

            // Query untuk mendapatkan jumlah user di provinsi tertentu
            $stmt = $conn->prepare("SELECT COUNT(u.user_id) AS jumlah_user
                FROM users u
                JOIN wilayah w ON u.id_wilayah = w.id_wilayah
                WHERE w.provinsi = ?
            ");
            $stmt->bind_param("s", $provinsi);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $contextData = "Jumlah user di provinsi $provinsi adalah " . $row['jumlah_user'] . " user.";
            } else {
                $contextData = "Tidak ada data user di provinsi $provinsi ditemukan.";
            }
            $stmt->close();
        } elseif (preg_match('/jumlah psikolog di provinsi (.*)/i', $userMessage, $matches)) {
            $provinsi = trim($matches[1]);

            // Query untuk mendapatkan jumlah psikolog di provinsi tertentu
            $stmt = $conn->prepare("SELECT COUNT(p.psychologist_id) AS jumlah_psikolog
                FROM psychologists p
                JOIN wilayah w ON p.id_wilayah = w.id_wilayah
                WHERE w.provinsi = ?
            ");
            $stmt->bind_param("s", $provinsi);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $contextData = "Jumlah psikolog di provinsi $provinsi adalah " . $row['jumlah_psikolog'] . " psikolog.";
            } else {
                $contextData = "Tidak ada data psikolog di provinsi $provinsi ditemukan.";
            }
            $stmt->close();
        } else {
            $contextData = "Maaf, saya tidak mengerti pertanyaan Anda.";
        }

        // Mengirimkan respons berdasarkan konteks
        $response = $contextData;
    }
} catch (Exception $e) {
    $response = "Terjadi kesalahan " . $e->getMessage();
}

echo $response;
?>
