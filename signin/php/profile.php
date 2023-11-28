<?php
include_once('../mongo_conn.php');
header('Content-Type: application/json'); 
try {

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        
        if ($username) {
            $existingUser = $users->findOne(['username' => $username]);
            
            if ($existingUser) {
                $updateData = [
                    '$set' => [
                        'email' => isset($_POST['email']) ? $_POST['email'] : null,
                        'age' => isset($_POST['age']) ? $_POST['age'] : null,
                        'gender' => isset($_POST['gender']) ? $_POST['gender'] : null,
                    ],
                ];
                
                $result = $users->updateOne(['username' => $username], $updateData);
                
                if ($result->getModifiedCount() > 0) {
                    echo "Details updated successfully.";
                } else {
                    echo "No changes made.";
                }
            } else {
                $newUserData = [
                    'username' => $username,
                    'email' => isset($_POST['email']) ? $_POST['email'] : null,
                    'password' => isset($_POST['password']) ? $_POST['password'] : null,
                ];
                
                $result = $users->insertOne($newUserData);

                if ($result->getInsertedCount() > 0) {
                    echo "New user inserted successfully.";
                } else {
                    echo "Failed to insert a new user.";
                }
            }
        } else {
            echo "Username not provided.";
        }
    } else {
        echo "Invalid request method.";
    }
} catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
    echo "Connection failed: " . $e->getMessage();
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "MongoDB error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
