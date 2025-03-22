<?php
include "db_config.php";
function addToCart($userId, $menuItemId, $quantity) {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $stmt = $conn->prepare("INSERT INTO cart (user_id, menu_item_id, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $userId, $menuItemId, $quantity);
    
    if ($stmt->execute()) {
        echo "Item added to cart successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
function removeFromCart($userId, $menuItemId) {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND menu_item_id = ?");
    $stmt->bind_param("ii", $userId, $menuItemId);
    
    if ($stmt->execute()) {
        echo "Item removed from cart successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}

function getCartContents($userId) {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT menu_item_id, quantity FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Menu Item ID: " . $row["menu_item_id"]. " - Quantity: " . $row["quantity"]. "<br>";
        }
    } else {
        echo "Cart is empty";
    }
    
    $stmt->close();
    $conn->close();
}

?>
