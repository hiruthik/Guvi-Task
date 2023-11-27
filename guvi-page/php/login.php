<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$email = $_POST['email'];
$enteredPassword = $_POST['password'];


$sql = "SELECT id, name, email, password FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    $row = $result->fetch_assoc();
    $hashedPassword = $row['password'];

    if (password_verify($enteredPassword, $hashedPassword)) {
        
        echo "Login successful";
    } else {
        
        echo "Incorrect credentials";
    }
} else {
    
    echo "Incorrect credentials";
}


$conn->close();
?>
