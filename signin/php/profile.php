<?php
include_once('../mongo_conn.php');
header('Content-Type: application/json'); 

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        
            $existingUser = $users->findOne(['username' => $username]);
            
            $updateData = [
                '$set' => [
                    'username'=>isset($_POST['email']) ? $_POST['email'] : null,
                    'email' => isset($_POST['email']) ? $_POST['email'] : null,
                    'age' => isset($_POST['age']) ? $_POST['age'] : null,
                    'gender' => isset($_POST['gender']) ? $_POST['gender'] : null,
                    'dob' => isset($_POST['dob']) ? $_POST['dob'] : null
                ],
            ];

            $result = $users->updateOne(['username' => $username], $updateData);
            
            if ($result->getModifiedCount() > 0 || $result->getUpsertedCount() > 0) {
                echo "Details updated successfully.";
            } else {
                echo "No changes made.";
            }
        } else {
            echo "Username not provided.";
        }
    
} catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
    echo "Connection failed: " . $e->getMessage();
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "MongoDB error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
