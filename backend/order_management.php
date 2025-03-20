<?php
// Include database configuration
include 'db_config.php';

// Function to create a new order
function createOrder($userId, $menuItemId, $quantity) {
    $conn = getDBConnection();
    
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO orders (user_id, menu_item_id, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $userId, $menuItemId, $quantity);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Order created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close connections
    $stmt->close();
    $conn->close();
}

// Function to update an existing order
function updateOrder($orderId, $quantity) {
    $conn = getDBConnection();
    
    // Prepare and bind
    $stmt = $conn->prepare("UPDATE orders SET quantity = ? WHERE id = ?");
    $stmt->bind_param("ii", $quantity, $orderId);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Order updated successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close connections
    $stmt->close();
    $conn->close();
}

// Function to retrieve order details
function getOrderDetails($orderId) {
    $conn = getDBConnection();
    
    // Prepare and bind
    $stmt = $conn->prepare("SELECT user_id, menu_item_id, quantity FROM orders WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $stmt->bind_result($userId, $menuItemId, $quantity);
    
    if ($stmt->fetch()) {
        echo "Order ID: " . $orderId . " - User ID: " . $userId . " - Menu Item ID: " . $menuItemId . " - Quantity: " . $quantity;
    } else {
        echo "Order not found";
    }
    
    // Close connections
    $stmt->close();
    $conn->close();
}

// Example usage
// createOrder(1, 2, 3);
// updateOrder(1, 5);
// getOrderDetails(1);
?>
