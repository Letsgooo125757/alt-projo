<?php
// Database connection constants
include "db_config.php";

// Function to add an item to the cart
function addToCart($userId, $menuItemId, $quantity) {
    // Database connection
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO cart (user_id, menu_item_id, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $userId, $menuItemId, $quantity);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Item added to cart successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close connections
    $stmt->close();
    $conn->close();
}

// Function to remove an item from the cart
function removeFromCart($userId, $menuItemId) {
    // Database connection
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare and bind
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND menu_item_id = ?");
    $stmt->bind_param("ii", $userId, $menuItemId);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Item removed from cart successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close connections
    $stmt->close();
    $conn->close();
}

// Function to retrieve cart contents
function getCartContents($userId) {
    // Database connection
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT menu_item_id, quantity FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "Menu Item ID: " . $row["menu_item_id"]. " - Quantity: " . $row["quantity"]. "<br>";
        }
    } else {
        echo "Cart is empty";
    }
    
    // Close connection
    $stmt->close();
    $conn->close();
}

// Example usage
// addToCart(1, 2, 3);
// removeFromCart(1, 2);
// getCartContents(1);
?>
