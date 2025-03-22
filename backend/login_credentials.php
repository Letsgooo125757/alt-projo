<?php
// Database connection constants
include "db_config.php";

if (!function_exists('password_hash')) {
    die("Error: password_hash function is not available.");
}
function storeUserCredentials($username, $password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);
    
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}

if (version_compare(PHP_VERSION, '7.0.0', '<')) {
    die("Error: PHP version must be 7.0.0 or higher.");
}

?>
