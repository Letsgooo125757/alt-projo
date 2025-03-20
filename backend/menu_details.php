<?php
// Database connection constants
include "db_config.php";

// Function to insert menu details into the database
function insertMenuDetails($menuItem, $price) {
    // Database connection
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO menu (item_name, price) VALUES (?, ?)");
    $stmt->bind_param("sd", $menuItem, $price);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "New menu item added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close connections
    $stmt->close();
    $conn->close();
}

// Function to retrieve menu details from the database
function getMenuDetails() {
    // Database connection
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT item_name, price FROM menu";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "Item: " . $row["item_name"]. " - Price: " . $row["price"]. "<br>";
        }
    } else {
        echo "0 results";
    }
    
    // Close connection
    $conn->close();
}

// Example usage
// insertMenuDetails('Pizza', 12.99);
// getMenuDetails();
?>
