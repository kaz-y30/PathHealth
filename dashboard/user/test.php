<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$full_name = $_SESSION['full_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PathHealth</title>
    <link rel="stylesheet" href="../../style/user/test.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/collect.js/4.36.1/collect.min.js" integrity="sha512-aub0tRfsNTyfYpvUs0e9G/QRsIDgKmm4x59WRkHeWUc3CXbdiMwiMQ5tTSElshZu2LCq8piM/cbIsNwuuIR4gA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <header>
        <div class="header-container">
            <img src="../../asset/logo2.png" alt="PathHealth" class="logo">
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                </ul>
            </nav>
        </div>
    </header>

    
    <div class="main">
        <div class="menu">
            <section class="hero">
                <h1>Discover Your Mental Health Issue</h1>
                <p>Take our free personality test and get  insightful understanding into your personality traits and gain valuable insights into your emotional landscape.</p>
                <a href="#pertanyaan" class="cta-button">Take the Test</a>
            </section>
            <section class="features">
                <div class="feature">
                    <img src="../../asset/user/1.png" alt="Feature 1">
                    <h2>Understand Yourself</h2>
                    <p>Discover what drives and inspires you.</p>
                </div>
                <div class="feature">
                    <img src="../../asset/user/2.png" alt="Feature 2">
                    <h2>Be a Better Person</h2>
                    <p>Learn how to deepen your connections with others.</p>
                </div>
                <div class="feature">
                    <img src="../../asset/user/3.png" alt="Feature 3">
                    <h2>Grow Your Mental</h2>
                    <p>Find the solution that fits your personality.</p>
                </div>
            </section>
            <section class="test-intro" id="pertanyaan">
                <br><br><br><br>
                <h1>Discover Your Health Score</h1>
                <p>Answer the following questions to get an insight into your mental. The test is free and only takes a few minutes.</p>
                <br><br><br><br>
                <!-- <hr> -->
            </section>               

            <!-- ====================HALAMAN 1========================== -->

            <section class="questions" id="halaman1">
                <form action="testMental.php" method="post">
                   <!-- Depression -->
                    <div class="question">
                        <h2>Tidak dapat melihat hal yang positif dari suatu kejadian</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q1" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q1" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q1" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q1" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q1" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Merasa sepertinya tidak kuat lagi untuk melakukan suatu kegiatan</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q2" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q2" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q2" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q2" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q2" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Merasa pesimis</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q3" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q3" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q3" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q3" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q3" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Merasa sedih dan depresi</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q4" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q4" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q4" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q4" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q4" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Kehilangan minat pada banyak hal (misal: makan, ambulasi, sosialisasi)</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q5" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q5" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q5" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q5" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q5" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Merasa diri tidak layak</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q6" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q6" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q6" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q6" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q6" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Merasa hidup tidak berharga</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q7" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q7" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q7" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q7" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q7" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Tidak dapat menikmati hal-hal yang saya lakukan</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q8" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q8" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q8" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q8" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q8" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Merasa hilang harapan dan putus asa</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q9" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q9" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q9" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q9" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q9" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Sulit untuk antusias pada banyak hal</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q10" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q10" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q10" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q10" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q10" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <!-- <a href="#halaman2" class="cta-button">Next</a> -->
                    <button type="button" onclick="showPage(2)">Next</button>
                
            </section>

            <!-- ====================HALAMAN 2========================== -->

            <section class="questions" id="halaman2" style="display: none;">
                
                   <!-- PTSD -->
                    <div class="question">
                        <h2>Merasakan gangguan dalam bernapas (napas cepat, sulit bernapas)</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q11" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q11" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q11" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q11" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q11" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Cemas yang berlebihan dalam suatu situasi namun bisa lega jika hal/situasi itu berakhir</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q12" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q12" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q12" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q12" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q12" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Berkeringat (misal: tangan berkeringat) tanpa stimulasi oleh cuaca maupun latihan fisik</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q13" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q13" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q13" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q13" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q13" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Ketakutan tanpa alasan yang jelas</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q14" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q14" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q14" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q14" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q14" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Kesulitan dalam menelan</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q15" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q15" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q15" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q15" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q15" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Perubahan kegiatan jantung dan denyut nadi tanpa stimulasi oleh latihan fisik</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q16" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q16" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q16" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q16" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q16" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Mudah panik</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q17" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q17" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q17" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q17" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q17" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Takut diri terhambat oleh tugas-tugas yang tidak biasa dilakukan</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q18" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q18" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q18" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q18" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q18" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Khawatir dengan situasi saat diri Anda mungkin menjadi panik dan mempermalukan diri sendiri</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q19" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q19" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q19" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q19" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q19" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Tubuh sering bergetar</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q20" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q20" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q20" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q20" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q20" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <!-- <button type="submit" class="submit-button">Next</button> -->
                    <button type="button" onclick="showPage(1)">Previous</button>
                    <button type="button" onclick="showPage(3)">Next</button>
                
            </section>

            <!-- ==================HALAMAN 3======================= -->

            <section class="questions" id="halaman3" style="display: none;">
                
                   <!-- Stress -->
                    <div class="question">
                        <h2>Menjadi marah karena hal-hal kecil/sepele</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q21" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q21" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q21" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q21" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q21" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Cenderung bereaksi berlebihan pada situasi</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q22" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q22" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q22" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q22" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q22" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Kesulitan untuk relaksasi/bersantai</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q23" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q23" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q23" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q23" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q23" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Mudah merasa kesal</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q24" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q24" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q24" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q24" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q24" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Merasa banyak menghabiskan energi karena cemas</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q25" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q25" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q25" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q25" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q25" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Tidak sabaran</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q26" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q26" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q26" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q26" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q26" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Mudah tersinggung atau marah</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q27" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q27" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q27" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q27" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q27" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Sulit untuk beristirahat</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q28" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q28" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q28" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q28" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q28" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Merasa hilang harapan dan putus asa</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q29" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q29" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q29" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q29" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q29" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Tidak dapat memaklumi hal apapun yang menghalangi anda untuk menyelesaikan hal yang sedang Anda lakukan</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q30" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q30" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q30" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q30" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q30" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <!-- <button type="submit" class="submit-button">Next</button> -->
                    <button type="button" onclick="showPage(2)">Previous</button>
                    <button type="button" onclick="showPage(4)">Next</button>
                
            </section>

            <!-- ==================HALAMAN 4======================= -->

            <section class="questions" id="halaman4" style="display: none;">
                
                   <!-- Bipolar Disorder -->
                    <div class="question">
                        <h2>Mengalami periode di mana suasana hati berubah-ubah secara ekstrim</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q31" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q31" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q31" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q31" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q31" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Mengalami perubahan drastis dalam kebutuhan tidur</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q32" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q32" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q32" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q32" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q32" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Merasa terlalu bersemangat atau aktif</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q33" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q33" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q33" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q33" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q33" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Kesulitan dalam memusatkan perhatian atau membuat keputusan</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q34" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q34" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q34" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q34" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q34" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Mengalami perasaan tak berarti atau tidak berdaya</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q35" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q35" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q35" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q35" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q35" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Mengalami perubahan dalam tingkat aktivitas yang tidak biasa</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q36" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q36" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q36" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q36" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q36" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Mengalami perilaku impulsif atau tidak terkendali</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q37" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q37" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q37" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q37" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q37" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Merasa sulit untuk tidur atau tidur terlalu banyak</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q38" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q38" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q38" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q38" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q38" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Mengalami periode energi yang berlebihan tanpa alasan yang jelas</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q39" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q39" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q39" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q39" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q39" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <div class="question">
                        <h2>Mengalami pikiran yang begitu memaksakan diri atau mengganggu yang lain</h2>
                        <div class="nomor">
                            Agree
                            <label>
                                <input type="radio" name="q40" value="strongly_agree">
                            </label>
                            <label>
                                <input type="radio" name="q40" value="agree">
                            </label>
                            <label>
                                <input type="radio" name="q40" value="neutral">
                            </label>
                            <label>
                                <input type="radio" name="q40" value="disagree">
                            </label>
                            <label>
                                <input type="radio" name="q40" value="strongly_disagree">
                            </label>
                            Disagree
                        </div>
                        <hr>
                    </div>
                    <!-- <button type="submit" class="submit-button">Next</button> -->
                    <button type="button" onclick="showPage(3)">Previous</button>
                    <button type="submit" >Submit</button>
                </form>
            </section>
            </div>
        </div>
    </div>
    <script src="test.js"></script>
</body>
</html>

<?php mysqli_close($conn); ?>
