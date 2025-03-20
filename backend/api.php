<?php
// Include database configuration and other management files
include 'db_config.php';
include 'user_management.php';
include 'menu_details.php';
include 'cart.php';
include 'order_management.php';

// Set the response header to JSON
header('Content-Type: application/json');

// Get the request method
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Handle API requests based on the request method
switch ($requestMethod) {
    case 'POST':
        // Handle user registration
        if (isset($_POST['action']) && $_POST['action'] == 'register') {
            registerUser($_POST['username'], $_POST['password']);
        }
        // Handle user login
        elseif (isset($_POST['action']) && $_POST['action'] == 'login') {
            loginUser($_POST['username'], $_POST['password']);
        }
        // Handle adding to cart
        elseif (isset($_POST['action']) && $_POST['action'] == 'add_to_cart') {
            addToCart($_POST['user_id'], $_POST['menu_item_id'], $_POST['quantity']);
        }
        // Handle creating an order
        elseif (isset($_POST['action']) && $_POST['action'] == 'create_order') {
            createOrder($_POST['user_id'], $_POST['menu_item_id'], $_POST['quantity']);
        }
        break;

    case 'GET':
        // Handle retrieving menu details
        if (isset($_GET['action']) && $_GET['action'] == 'get_menu') {
            getMenuDetails();
        }
        // Handle retrieving cart contents
        elseif (isset($_GET['action']) && $_GET['action'] == 'get_cart') {
            getCartContents($_GET['user_id']);
        }
        // Handle retrieving order details
        elseif (isset($_GET['action']) && $_GET['action'] == 'get_order') {
            getOrderDetails($_GET['order_id']);
        }
        break;

    default:
        echo json_encode(['message' => 'Invalid request method']);
        break;
}
?>
