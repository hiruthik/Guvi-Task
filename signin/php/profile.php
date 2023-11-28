<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newDob = $_POST['dob'];
    $newAge = $_POST['age'];
    $newGender = $_POST['gender'];

    $updateStmt = $con->prepare('UPDATE accounts SET dob=?, age=?, gender=? WHERE username=?');
    $updateStmt->bind_param('ssss', $newDob, $newAge, $newGender, $_POST['username']);

    if ($updateStmt->execute()) {
        echo 'User details updated successfully.';
    } else {
        echo 'Error updating user details.';
    }

    $updateStmt->close();
}

$stmt = $con->prepare('SELECT username, password, email, dob, age, gender FROM accounts WHERE username = ?');
$stmt->bind_param('s', $_POST['username']);
$stmt->execute();
$stmt->bind_result($username, $password, $email, $dob, $age, $gender);
$stmt->fetch();
$stmt->close();
?>