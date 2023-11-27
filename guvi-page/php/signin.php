<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Establish a MySQL database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Retrieve form data
$fullName = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Insert data into the database
$sql = "INSERT INTO users ( id, name, email, password) VALUES ( 1,'$fullName', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "User registered successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
