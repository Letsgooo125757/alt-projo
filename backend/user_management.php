<?php
// Include database configuration
include 'db_config.php';

// Function to register a new user
function registerUser($username, $password) {
    $conn = getDBConnection();
    
    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "User registered successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close connections
    $stmt->close();
    $conn->close();
}

// Function to login a user
function loginUser($username, $password) {
    $conn = getDBConnection();
    
    // Prepare and bind
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        
        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            echo "Login successful";
            // Start session and set user session variables here
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }
    
    // Close connections
    $stmt->close();
    $conn->close();
}

// Function to retrieve user profile
function getUserProfile($username) {
    $conn = getDBConnection();
    
    // Prepare and bind
    $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($username);
    
    if ($stmt->fetch()) {
        echo "User Profile: " . $username;
    } else {
        echo "User not found";
    }
    
    // Close connections
    $stmt->close();
    $conn->close();
}

// Example usage
// registerUser('testuser', 'testpassword');
// loginUser('testuser', 'testpassword');
// getUserProfile('testuser');
?>
