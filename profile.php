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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for updating user details
    $newDob = $_POST['dob'];
    $newAge = $_POST['age'];
    $newGender = $_POST['gender'];

    $updateStmt = $con->prepare('UPDATE accounts SET dob=?, age=?, gender=? WHERE id=?');
    $updateStmt->bind_param('sssi', $newDob, $newAge, $newGender, $_SESSION['id']);

    if ($updateStmt->execute()) {
        echo 'User details updated successfully.';
        // Refresh the page to display updated details
        header("Refresh:0");
    } else {
        echo 'Error updating user details.';
    }

    $updateStmt->close();
}

$stmt = $con->prepare('SELECT username, password, email, dob, age, gender FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($username, $password, $email, $dob, $age, $gender);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Page</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body class="loggedin">
    <nav class="navtop">
        <div>
            <a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
            <h1>GUVI PROFILE</h1>
        </div>
    </nav>
    <div class="content">
        <h2>Profile Page</h2>
        <div>
            <form method="post" action="profile.php">
                <p>Your account details are below:</p>
                <table>
                    <tr>
                        <td>Username:</td>
                        <td><?= $username ?></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><?= $password ?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?= $email ?></td>
                    </tr>
                    <tr>
                        <td>Date of Birth:</td>
                        <td><input type="text" name="dob" value="<?= $dob ?>"></td>
                    </tr>
                    <tr>
                        <td>Age:</td>
                        <td><input type="text" name="age" value="<?= $age ?>"></td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <td><input type="text" name="gender" value="<?= $gender ?>"></td>
                    </tr>
                </table>
                <input type="submit" value="Update Details">
            </form>
        </div>
    </div>
</body>
</html>
