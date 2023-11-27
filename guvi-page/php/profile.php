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

session_start();
$userId = $_SESSION['user_id'];


$sql = "SELECT id, name, email FROM users WHERE id = '$userId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
} else {
    
    die("User not found");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $newName = $_POST['newName'];
    $newEmail = $_POST['newEmail'];


    $updateSql = "UPDATE users SET name = '$newName', email = '$newEmail' WHERE id = '$userId'";

    if ($conn->query($updateSql) === TRUE) {
        
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating user information: " . $conn->error;
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>

<h2>User Profile</h2>


<p>Name: <?php echo $name; ?></p>
<p>Email: <?php echo $email; ?></p>


<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="newName">New Name:</label>
    <input type="text" name="newName" value="<?php echo $name; ?>" required><br>

    <label for="newEmail">New Email:</label>
    <input type="email" name="newEmail" value="<?php echo $email; ?>" required><br>

    <input type="submit" value="Update">
</form>

</body>
</html>
