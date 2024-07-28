
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../includes/load.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sale_date = make_date();
    $item =remove_junk($db->escape($_POST['item'])) ;
    $price = floatval(remove_junk($_POST['price']));
    $barcode = remove_junk($_POST['barcode']);
    $brand = remove_junk($_POST['brand_name']);
    // var_dump($price);
    $user_id = $_SESSION['user_id'];
    $total = remove_junk($_REQUEST['total']);
    $category = remove_junk($db->escape($_POST['category']));
    $qty = remove_junk($db->escape($_POST['qty']));    
    $query  = "INSERT INTO Sale (";
    $query .= "item,price,qty,total,category_id,added_date,barcode,brand,distributor_id";
    $query .= ") VALUES (";
    $query .= " '{$item}','{$price}','{$qty}','{$total}', '{$category}','{$sale_date}','{$barcode}','{$brand}', '{$user_id}'";
    $query .= ")";
    $query .= " ON DUPLICATE KEY UPDATE item='{$item}'";
    if($db->query($query)){
        $session->msg('s',"Sale added ");
        redirect('../add_sale.php', false);
    } else {
        $session->msg('d','Failed to add sale');
        redirect('../add_sale.php', false);
    }
}

?>