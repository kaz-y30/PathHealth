<?php
session_start();
include "../koneksi.php";
use LucianoTonet\GroqPHP\Groq;

require '../../vendor/autoload.php'; // Letakkan di sini

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan kunci $_POST ada sebelum mengaksesnya
    // Array untuk menyimpan nilai jawaban
    $answers = [
        isset($_POST['q1']) ? $_POST['q1'] : "",
        isset($_POST['q2']) ? $_POST['q2'] : "",
        isset($_POST['q3']) ? $_POST['q3'] : "",
        isset($_POST['q4']) ? $_POST['q4'] : "",
        isset($_POST['q5']) ? $_POST['q5'] : "",
        isset($_POST['q6']) ? $_POST['q6'] : "",
        isset($_POST['q7']) ? $_POST['q7'] : "",
        isset($_POST['q8']) ? $_POST['q8'] : "",
        isset($_POST['q9']) ? $_POST['q9'] : "",
        isset($_POST['q10']) ? $_POST['q10'] : "",
        isset($_POST['q11']) ? $_POST['q11'] : "",
        isset($_POST['q12']) ? $_POST['q12'] : "",
        isset($_POST['q13']) ? $_POST['q13'] : "",
        isset($_POST['q14']) ? $_POST['q14'] : "",
        isset($_POST['q15']) ? $_POST['q15'] : "",
        isset($_POST['q16']) ? $_POST['q16'] : "",
        isset($_POST['q17']) ? $_POST['q17'] : "",
        isset($_POST['q18']) ? $_POST['q18'] : "",
        isset($_POST['q19']) ? $_POST['q19'] : "",
        isset($_POST['q20']) ? $_POST['q20'] : "",
        isset($_POST['q21']) ? $_POST['q21'] : "",
        isset($_POST['q22']) ? $_POST['q22'] : "",
        isset($_POST['q23']) ? $_POST['q23'] : "",
        isset($_POST['q24']) ? $_POST['q24'] : "",
        isset($_POST['q25']) ? $_POST['q25'] : "",
        isset($_POST['q26']) ? $_POST['q26'] : "",
        isset($_POST['q27']) ? $_POST['q27'] : "",
        isset($_POST['q28']) ? $_POST['q28'] : "",
        isset($_POST['q29']) ? $_POST['q29'] : "",
        isset($_POST['q30']) ? $_POST['q30'] : "",
        isset($_POST['q31']) ? $_POST['q31'] : "",
        isset($_POST['q32']) ? $_POST['q32'] : "",
        isset($_POST['q33']) ? $_POST['q33'] : "",
        isset($_POST['q34']) ? $_POST['q34'] : "",
        isset($_POST['q35']) ? $_POST['q35'] : "",
        isset($_POST['q36']) ? $_POST['q36'] : "",
        isset($_POST['q37']) ? $_POST['q37'] : "",
        isset($_POST['q38']) ? $_POST['q38'] : "",
        isset($_POST['q39']) ? $_POST['q39'] : "",
        isset($_POST['q40']) ? $_POST['q40'] : "",
    ];

    // Memastikan kunci $_POST ada sebelum mengaksesnya
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'q') === 0) {
            // Simpan nilai jawaban ke dalam array answers
            $answers[(int) substr($key, 1)] = $value;
        }
    }

    // Fungsi untuk menghitung skor berdasarkan jawaban
    function calculateScore($answer) {
        $score_mapping = [
            'strongly_agree' => 10,
            'agree' => 8,
            'neutral' => 5,
            'disagree' => 3,
            'strongly_disagree' => 0,
        ];

        return isset($score_mapping[$answer]) ? $score_mapping[$answer] : 0;
    }

    // Menghitung skor untuk setiap kategori
    $depression_score = 0;
    $ptsd_score = 0;
    $stress_score = 0;
    $bipolar_score = 0;

    foreach ($answers as $index => $value) {
        $score = calculateScore($value);
        if ($index >= 1 && $index <= 10) {
            $depression_score += $score;
        } elseif ($index >= 11 && $index <= 20) {
            $ptsd_score += $score;
        } elseif ($index >= 21 && $index <= 30) {
            $stress_score += $score;
        } elseif ($index >= 31 && $index <= 40) {
            $bipolar_score += $score;
        }
    }

    // Temukan skor tertinggi di antara kategori-kategori
    $maxScore = max($depression_score, $ptsd_score, $stress_score, $bipolar_score);

    // Tentukan kategori yang memiliki skor tertinggi
    $highestCategory = "";
    if ($maxScore == $depression_score) {
        $highestCategory = "Depression";
    } elseif ($maxScore == $ptsd_score) {
        $highestCategory = "PTSD";
    } elseif ($maxScore == $stress_score) {
        $highestCategory = "Stress";
    } elseif ($maxScore == $bipolar_score) {
        $highestCategory = "Bipolar";
    }

    // Tentukan potensial diagnosis berdasarkan kategori skor yang lebih tinggi
    if ($maxScore == $depression_score) {
        if ($depression_score >= 94) {
            $severity_level = 'Severe';
            $potential_diagnosis = 'Depression';
        } elseif ($depression_score >= 86) {
            $severity_level = 'High';
            $potential_diagnosis = 'Depression';
        } elseif ($depression_score >= 65) {
            $severity_level = 'Moderate';
            $potential_diagnosis = 'Depression';
        } elseif ($depression_score >= 40) {
            $severity_level = 'Low';
            $potential_diagnosis = 'Depression';
        } else {
            $severity_level = 'Normal';
            $potential_diagnosis = 'No Depression';
        }
    } elseif ($maxScore == $ptsd_score) {
        if ($ptsd_score >= 94) {
            $severity_level = 'Severe';
            $potential_diagnosis = 'PTSD';
        } elseif ($ptsd_score >= 86) {
            $severity_level = 'High';
            $potential_diagnosis = 'PTSD';
        } elseif ($ptsd_score >= 65) {
            $severity_level = 'Moderate';
            $potential_diagnosis = 'PTSD';
        } elseif ($ptsd_score >= 40) {
            $severity_level = 'Low';
            $potential_diagnosis = 'PTSD';
        } else {
            $severity_level = 'Normal';
            $potential_diagnosis = 'No PTSD';
        }
    } elseif ($maxScore == $stress_score) {
        if ($stress_score >= 94) {
            $severity_level = 'Severe';
            $potential_diagnosis = 'Stress';
        } elseif ($stress_score >= 86) {
            $severity_level = 'High';
            $potential_diagnosis = 'Stress';
        } elseif ($stress_score >= 65) {
            $severity_level = 'Moderate';
            $potential_diagnosis = 'Stress';
        } elseif ($stress_score >= 40) {
            $severity_level = 'Low';
            $potential_diagnosis = 'Stress';
        } else {
            $severity_level = 'Normal';
            $potential_diagnosis = 'No Stress';
        }
    } elseif ($maxScore == $bipolar_score) {
        if ($bipolar_score >= 94) {
            $severity_level = 'Severe';
            $potential_diagnosis = 'Bipolar Angular';
        } elseif ($bipolar_score >= 86) {
            $severity_level = 'High';
            $potential_diagnosis = 'Bipolar Angular';
        } elseif ($bipolar_score >= 65) {
            $severity_level = 'Moderate';
            $potential_diagnosis = 'Bipolar Angular';
        } elseif ($bipolar_score >= 40) {
            $severity_level = 'Low';
            $potential_diagnosis = 'Bipolar Angular';
        } else {
            $severity_level = 'Normal';
            $potential_diagnosis = 'No Bipolar Angular';
        }
    } else {
        echo 'Data Tidak Ada';
    }

    // Periksa apakah pengguna sudah memiliki hasil tes sebelumnya
   // Debug sebelum melakukan INSERT atau UPDATE
    echo "Max Score: $maxScore, Severity Level: $severity_level, Potential Diagnosis: $potential_diagnosis";

    // Periksa apakah pengguna sudah memiliki hasil tes sebelumnya
    $stmt = $conn->prepare("SELECT * FROM mentalhealthtests WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $existingTest = $result->fetch_assoc();
    $stmt->close();

    if ($existingTest) {
        // Perbarui hasil tes yang sudah ada
        $stmt = $conn->prepare("UPDATE mentalhealthtests SET test_date = NOW(), score = ?, severity_level = ?, potential_diagnosis = ?, created_at = NOW() WHERE user_id = ?");
        $stmt->bind_param("sssi", $maxScore, $severity_level, $potential_diagnosis, $user_id);
        $stmt->execute();
        $stmt->close();

    } else {
        // Simpan hasil tes baru
        $stmt = $conn->prepare("INSERT INTO mentalhealthtests (user_id, test_date, score, severity_level, potential_diagnosis, created_at) VALUES (?, NOW(), ?, ?, ?, NOW())");
        $stmt->bind_param("iisss", $user_id, $maxScore, $severity_level, $potential_diagnosis);
        $stmt->execute();
        $stmt->close();
    }

    // Ambil hasil tes terbaru
    $stmt = $conn->prepare("SELECT * FROM mentalhealthtests WHERE user_id = ? ORDER BY test_id DESC LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $testResults = $result->fetch_assoc();
    $stmt->close();


    // Debug untuk hasil tes terbaru
    echo "Test Results: " . json_encode($testResults);

    // Buat konteks data untuk chatbot
    $contextData = "Hasil tes: " . json_encode($testResults);
    $userMessage = "Berikan rekomendasi berdasarkan hasil tes ini dalam bahasa Indonesia.";
    $prompt = $contextData . ' ' . $userMessage;

    // Panggil API Groq untuk mendapatkan rekomendasi
    try {
        $groq = new Groq('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');
        $chatCompletion = $groq->chat()->completions()->create([
            'model'    => 'mixtral-8x7b-32768',
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ]
        ]);

        $recommendations = $chatCompletion['choices'][0]['message']['content'];
        $recommendations = stripslashes($recommendations);
        echo "$recommendations";
    } catch (Exception $e) {
        echo 'Terjadi kesalahan saat menghubungi API Groq: ' . $e->getMessage();
        exit();
    }

    // Periksa apakah ada entri di tabel recommendations untuk test_id yang sama
    $stmt = $conn->prepare("SELECT * FROM recommendations WHERE user_id = ? AND test_id = ?");
    $stmt->bind_param("ii", $user_id, $testResults['test_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $existingRecommendation = $result->fetch_assoc();
    $stmt->close();

    if ($existingRecommendation) {
        // Perbarui entri yang sudah ada
        $stmt = $conn->prepare("UPDATE recommendations SET recommendation = ?, created_at = NOW() WHERE user_id = ? AND test_id = ?");
        $stmt->bind_param("sii", $recommendations, $user_id, $testResults['test_id']);
        $stmt->execute();
        $stmt->close();
    } else {
        // Simpan rekomendasi baru
        $stmt = $conn->prepare("INSERT INTO recommendations (user_id, test_id, recommendation, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iis", $user_id, $testResults['test_id'], $recommendations);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect atau tampilkan hasil
    header("Location: dashboard.php?recommendations=" . urlencode($recommendations));
    exit();

}
?>
