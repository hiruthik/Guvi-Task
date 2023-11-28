<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (isset($_POST['username'], $_POST['email'], $_POST['password'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the username or email already exists
    $checkStmt = $con->prepare('SELECT id FROM accounts WHERE username = ? OR email = ?');
    $checkStmt->bind_param('ss', $username, $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Username or email already exists, display an alert
        echo '<script>alert("Username or email already exists."); window.location.href = "index.html";</script>';
    } else {
        // Username and email are unique, proceed with registration
        $insertStmt = $con->prepare('INSERT INTO accounts (username, email, password, dob, age, gender) VALUES (?, ?, ?, 0, 0, 0)');
        $insertStmt->bind_param('sss', $username, $email, $password);

        if ($insertStmt->execute()) {
            // Registration successful, redirect to index.html
            header('Location:index.html');
        } else {
            // Error during registration, display an alert
            echo '<script>alert("Error during registration. Please try again."); window.location.href = "index.html";</script>';
        }

        $insertStmt->close();
    }

    $checkStmt->close();
} else {
    echo 'Please fill all the fields.';
}

$con->close();
?>
