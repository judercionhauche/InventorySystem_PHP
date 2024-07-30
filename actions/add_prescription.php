
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../includes/load.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = make_date();
    $med =remove_junk($db->escape($_POST['medicineName']));
    
    $split = explode(",", remove_junk($_POST['patientName']));
    $id = $split[0];
    $patient = $split[1];
    
    $dosage = remove_junk($_POST['dosage']);
    $days = remove_junk($_POST['numberOfDays']);
    $user_id = $_SESSION['user_id'];
    $frequency = remove_junk($_REQUEST['frequency']);
    $route = remove_junk($db->escape($_POST['route']));
    $instructions = remove_junk($_POST['instructions']);    
    
    
    $query  = "INSERT INTO prescriptions (";
    $query .= "date,medicine_id,patient_id,patient_name,dosage,number_of_days,frequency,route,instructions,pharma_id";
    $query .= ") VALUES (";
    $query .= " '{$date}','{$med}','{$id}','{$patient}', '{$dosage}','{$days}','{$frequency}','{$route}', '{$instructions}', '{$user_id}'";
    $query .= ")";

    if($db->query($query)){
        $session->msg('s',"Prescription added ");
        redirect('../prescription.php', false);
    } else {
        $session->msg('d','Failed to add');
        redirect('../prescription.php', false);
    }
}

?>