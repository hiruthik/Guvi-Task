<?php
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

    $checkStmt = $con->prepare('SELECT id FROM accounts WHERE username = ? OR email = ?');
    $checkStmt->bind_param('ss', $username, $email);
    $checkStmt->execute();
    $checkStmt->store_result();
    if ($checkStmt->num_rows > 0) {
        echo 'Username or email already exists.';
    } else {
        $insertStmt = $con->prepare('INSERT INTO accounts (username, email, password, dob, age, gender) VALUES (?, ?, ?, 0, 0, 0)');
        $insertStmt->bind_param('sss', $username, $email, $password);

        if ($insertStmt->execute()) {
            echo 'Registration successful.';
        } else {
            echo 'Error during registration. Please try again.';
        }

        $insertStmt->close();
    }

    $checkStmt->close();
} else {
    echo 'Please fill all the fields.';
}

$con->close();
?>
