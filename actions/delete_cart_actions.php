<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../includes/load.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; 
    $sale_id = (int) $db->escape($_POST['item']);

    // Delete item from cart
    $query = "DELETE FROM Cart WHERE sale_id = '$sale_id' AND user_id = '$user_id'";
    $result = $db->query($query);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete item from cart']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
