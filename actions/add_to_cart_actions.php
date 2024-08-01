<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../includes/load.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; 
    $sale_id = (int) $db->escape($_POST['item']);
    $qty = (int) $db->escape($_POST['qty']);
    
    // Check if item already exists in cart
    $check_query = "SELECT * FROM cart WHERE sale_id = '$sale_id' AND user_id = '$user_id'";
    $check_result = $db->query($check_query);

    if ($check_result->num_rows > 0) {
        // Update quantity if item exists
        $update_query = "UPDATE cart SET qty = qty + '$qty' WHERE sale_id = '$sale_id' AND user_id = '$user_id'";
        $result = $db->query($update_query);
    } else {
        // Insert new item if it doesn't exist
        $query = "INSERT INTO cart (sale_id, user_id, qty) VALUES ('$sale_id', '$user_id', '$qty')";
        $result = $db->query($query);
    }

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add/update item in cart']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

