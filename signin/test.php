<?php
require __DIR__ . '/vendor/autoload.php';
$mongoUri = 'mongodb://localhost:27017/';
$databaseName = 'my_application_database';
try {
    $mongoClient = new MongoDB\Client($mongoUri);
    $mongoDB = $mongoClient->selectDatabase($databaseName);
    $users = $mongoDB->users;
    $testUser = [
        'username' => 'test_user',
        'email' => 'test@example.com',
        'password' => 'test_password',
    ];
    $result = $users->insertOne($testUser);
    if ($result->getInsertedCount() > 0) {
        echo "Successfully inserted a test user.";
    } else {
        echo "Failed to insert a test user.";
    }
} catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
    echo "Connection failed: " . $e->getMessage();
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "MongoDB error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
