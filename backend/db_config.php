<?php
// Database connection constants
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Njuki22157');
define('DB_DATABASE', 'CMS');

// Function to create a database connection
function getDBConnection() {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

// function to create a database
function createDatabase() {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $sql = "CREATE DATABASE CMS";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $conn->error;
    }
    $conn->close();
}

?>
