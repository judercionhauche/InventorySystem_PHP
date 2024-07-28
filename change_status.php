<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once('includes/load.php');
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        
        $status = remove_junk($_POST['status']);
        $order_id = $_GET['order_id'];
        $user = $_GET['user'];
        
        if (isset($status)){
        
            $query = "UPDATE orders SET status = '$status' wHERE order_id = '$order_id'";
            $result = $db->query($query);
            
            $result = True;
            
            if ($result && $status == 'Received'){
            
                $items = array();
                $order_date = date("Y-m-d H:i:s");
                $user_id = $_SESSION['user_id'];
                $check_query = "SELECT s.item, s.price, o.qty, s.category_id, s.barcode, s.brand 
                                FROM sale s 
                                JOIN orders o ON o.sale_id = s.id  
                                WHERE o.order_id = '$order_id'";

                $check_result = $db->query($check_query);
                     
                $row = $check_result->fetch_assoc();
                // echo $row['item'];
            
                $sql = "INSERT INTO products (item, price, qty, category_id, `date`, barcode, brand_name, pharma_id)
                    VALUES ('" . $row['item'] . "', '" . $row['price'] . "', '" . $row['qty'] . "', '" . $row['category_id'] . "', '$order_date', '" . $row['barcode'] . "', '" . $row['brand'] . "', '$user_id')";

                        
                $result1 = $db->query($sql);
            }
            if(isset($result1) && $result1){
                $session->msg('s',"Receipt Acknowledged");
                redirect($user.'_pending.php', false);
            }
            else if($result){
                $session->msg('s',"Status Updated");
                redirect($user.'_pending.php', false);
            } else {
                $session->msg('d','Failed to Update');
                redirect($user.'_pending.php', false);
            }
            
        }
    }

?>