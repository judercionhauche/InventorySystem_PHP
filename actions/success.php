Here is the modified `success.php` code that includes inserting payment details into the `payments` table after a successful payment:

```php
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('../includes/load.php');

if (isset($_GET['ref'])) {
    $reference = $_GET['ref'];
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer sk_test_06b949231274ff999daf09f43ce5df0d65c96dcf", // Use your secret key here
            "Cache-Control: no-cache",
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        // Handle cURL error
        echo "cURL Error #: " . $err;
        exit;
    } else {
        // Verify transaction status
        $response_data = json_decode($response, true);
        if ($response_data['status'] && $response_data['data']['status'] == 'success') {
            // Process form data from the URL
            if (isset($_SESSION['username'])) {
                $user_name = $_SESSION['username'];
                 
                $order_date = date("Y-m-d H:i:s");
                $invoice_no = mt_rand();
                $user_id = $_SESSION['user_id'];
                $status = "Pending";
                $payment_method = 'Paystack'; // You can update this based on your payment method
                
                if (isset($_GET['items'])) {
                    $items = $_GET['items'];
                    $total_amount = 0;
                    
                    // Process items
                    foreach ($items as $item) {
                        $id = $item['id'];
                        $price = $item['price'];
                        $qty = $item['qty'];
                        $total_amount += $price * $qty; // Calculate total amount
                        
                        $sql = "INSERT INTO orders (user_id, sale_id, price, qty, order_date, invoice, status)
                        VALUES ('$user_id', '$id', '$price', '$qty', '$order_date', '$invoice_no', '$status')";
                        
                        $result = $db->query($sql);
                         
                        if ($result) {
                            $order_id = $db->insert_id(); // Get the last inserted order ID
                            $sql1 = "UPDATE sale SET qty = qty - '$qty' wHERE id = '$id' AND qty > 0";
                            $result1 = $db->query($sql1);
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Failed to add/update item in cart']);
                        }
                    }
                    
                    // Insert payment details
                    $payment_date = date("Y-m-d H:i:s");
                    $payment_sql = "INSERT INTO payments (order_id, amount, payment_date, payment_method, user_id)
                                    VALUES ('$order_id', '$total_amount', '$payment_date', '$payment_method', '$user_id')";
                    
                    $payment_result = $db->query($payment_sql);
                    
                    if ($payment_result) {
                        $session->msg("s", "Order and Payment Successful");
                        header('Location: ../add_to_cart.php');
                        exit;
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to record payment']);
                    }
                } else {
                    echo "No items received.";
                }
            } else {
                echo "Invalid request.";
            }
        } else {
            echo "Transaction verification failed.";
        }
    }
} else {
    echo "No reference provided.";
}
?>
```

This code includes the following changes:

1. Calculates the total amount for the order.
2. After processing the items and inserting them into the `orders` table, it fetches the last inserted order ID.
3. Inserts the payment details into the `payments` table with the total amount, payment date, payment method, and user ID.

Make sure to replace `"Authorization: Bearer sk_test_06b949231274ff999daf09f43ce5df0d65c96dcf"` with your actual secret key.