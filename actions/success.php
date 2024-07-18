<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../config/connection.php'; 
require '../Functions/functions.php'; 
require '../Functions/session.php'; 

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
            session_start();

            // Process form data from the URL
            if (isset($_SESSION['username'])) {
                $user_name = $_SESSION['user_name'];
                 
                $booking_date = date("Y-m-d H:i:s");
                $invoice_no = mt_rand();
                $phone = $connection->real_escape_string($_GET['phone']);
                $title = $connection->real_escape_string($_GET['title']);
                $fname = $connection->real_escape_string($_GET['fname']);
                $lname = $connection->real_escape_string($_GET['lname']);
                $email = $connection->real_escape_string($_GET['email']);
                $departure_time = $connection->real_escape_string($_GET['departure_time']);
                $pickup = $connection->real_escape_string($_GET['pickup_location']);
                $dropoff = $connection->real_escape_string($_GET['dropoff_location']);
                $seats = $connection->real_escape_string($_GET['number_of_seats']);          
                $sql = "INSERT INTO booking (user_id, title, fname, lname, email, phone, departure_time, pickup_location, dropoff_location, number_of_seats, invoice_number, created_at)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                         
                if ($stmt = $connection->prepare($sql)) {
                    $stmt->bind_param("issssssssiss", $user_id, $title, $fname, $lname, $email, $phone, $departure_time, $pickup, $dropoff, $seats, $invoice_no, $booking_date);
                    echo 'good';
                    if ($stmt->execute()) {
                      $session->msg("s", "Booking and Payment Successful");
                        echo "Booking successful.";
                        header('Location: ../trip-details.php');
                        exit;
                    } else {
                        echo "Error: " . $stmt->error;
                    }

                    $stmt->close();
                } else {
                    echo "Error: " . $conn->error;
                }
                $connection->close();
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
