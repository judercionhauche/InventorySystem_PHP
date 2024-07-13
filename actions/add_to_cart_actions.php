<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../includes/load.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user ID from session (assuming it's stored there)
    $user_id = $_SESSION['user_id']; // Adjust as per your session handling

    // Escape and sanitize input data
    $sale_id = (int) $db->escape($_POST['item']); // Assuming 'item' is sale_id from Sales table
    var_dump($sale_id);
    $qty = (int) $db->escape($_POST['qty']);

    // Insert into Cart table
    $query = "INSERT INTO Cart (sale_id, user_id, qty) VALUES ('$sale_id', '$user_id', '$qty')";
    $result = $db->query($query);

    if ($result) {
        // Success message and redirect
        $session->msg('s', 'Item added to cart');
        redirect('../add_to_cart.php', false); // Redirect to appropriate page
    } else {
        // Error message and redirect
        $session->msg('d', 'Failed to add item to cart');
        redirect('../add_to_cart.php', false); // Redirect to appropriate page
    }
} else {
    // If not a POST request, handle accordingly (optional)
    $session->msg('d', 'Invalid request method');
    redirect('../add_to_cart.php', false); // Redirect to appropriate page
}
?>
