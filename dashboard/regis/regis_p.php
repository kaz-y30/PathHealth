<?php
include "../koneksi.php";

// Get form data
$fullname = $_POST['fullname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$register_as = $_POST['register_as'];

// Prepare the SQL statement based on the user type
if ($register_as == 'user') {
    $sql = "INSERT INTO users (username, password, email, full_name, date_of_birth, gender, created_at, id_wilayah) VALUES ('$username', '$password', '$email', '$fullname', NULL, '', NOW(), NULL)";
} elseif ($register_as == 'psychologist') {
    $sql = "INSERT INTO psychologists (username, password, email, full_name, qualifications, id_wilayah) VALUES ('$username', '$password', '$email', '$fullname', '', NULL)";
} else {
    // If the registration type is not valid, redirect back to the registration form
    header("Location: regis.php");
    exit();
}

// Execute the query
if (mysqli_query($conn, $sql)) {
    // Redirect to the login page on successful registration
    header("Location: ../login/login.php");
} else {
    // Redirect back to the registration form with an error message
    header("Location: regis.php?error=1");
}

// Close the database connection
mysqli_close($conn);
?>
