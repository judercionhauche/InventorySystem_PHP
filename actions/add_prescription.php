<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../includes/load.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = make_date();
    $med = remove_junk($db->escape($_POST['medicineName']));
    
    $split = explode(",", remove_junk($_POST['patientName']));
    $id = $split[0];
    $patient = $split[1];
    
    $dosage = remove_junk($_POST['dosage']);
    $qty = remove_junk($_POST['qty']);
    $user_id = $_SESSION['user_id'];
    $frequency = remove_junk($_REQUEST['frequency']);
    $route = remove_junk($db->escape($_POST['route']));
    $instructions = remove_junk($_POST['instructions']);    
    
    $query  = "INSERT INTO prescriptions (";
    $query .= "date,medicine_id,patient_id,patient_name,dosage,qty,frequency,route,instructions,pharma_id";
    $query .= ") VALUES (";
    $query .= " '{$date}','{$med}','{$id}','{$patient}', '{$dosage}','{$qty}','{$frequency}','{$route}', '{$instructions}', '{$user_id}'";
    $query .= ")";

    if($db->query($query)){
        // Reduce the quantity in the products table
        $update_query = "UPDATE products SET qty = qty - '{$qty}' WHERE id = '{$med}'";
        if($db->query($update_query)){
            $session->msg('s',"Prescription added and stock updated.");
        } else {
            $session->msg('d',"Prescription added but failed to update stock.");
        }
        redirect('../prescription.php', false);
    } else {
        $session->msg('d','Failed to add prescription');
        redirect('../prescription.php', false);
    }
}
?>
