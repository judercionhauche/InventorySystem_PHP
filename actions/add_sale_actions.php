
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../includes/load.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sale_date = make_date();
    $item =remove_junk($db->escape($_POST['item'])) ;
    $price = floatval(remove_junk($_POST['price']));
    var_dump($price);
    $total = remove_junk($_REQUEST['total']);
    $category = remove_junk($db->escape($_POST['category']));
    $qty = remove_junk($db->escape($_POST['qty']));    
    $query  = "INSERT INTO Sale (";
    $query .= "item,price,qty,total,category_id,added_date";
    $query .= ") VALUES (";
    $query .= " '{$item}','{$price}','{$qty}','{$total}', '{$category}','{$sale_date}'";
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