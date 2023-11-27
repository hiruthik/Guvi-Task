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

// Retrieve login form data
$email = $_POST['email'];
$enteredPassword = $_POST['password'];

// Retrieve hashed password from the database based on the provided email
$sql = "SELECT id, name, email, password FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User found, check password
    $row = $result->fetch_assoc();
    $hashedPassword = $row['password'];

    if (password_verify($enteredPassword, $hashedPassword)) {
        // Password is correct, login successful
        echo "Login successful";
    } else {
        // Password is incorrect
        echo "Incorrect credentials";
    }
} else {
    // User not found
    echo "Incorrect credentials";
}

// Close the database connection
$conn->close();
?>
