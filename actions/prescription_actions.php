
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../includes/load.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $patientName =remove_junk($db->escape($_POST['patientName'])) ;
    $surname = remove_junk($_REQUEST['surname']);
    $email = remove_junk($_REQUEST['email']);
    $dob = remove_junk($db->escape($_POST['dateOfBirth']));
    $gender = remove_junk($_POST['gender']);
    $weight = remove_junk($db->escape($_POST['weight']));
    $height = remove_junk($db->escape($_POST['height']));
    $respiratoryRate = remove_junk($db->escape($_POST['respiratoryRate']));
    $bloodSugar = remove_junk($db->escape($_POST['bloodSugar']));
    $bmi = remove_junk($db->escape($_POST['bmi']));
    $query  = "INSERT INTO Patients (";
    $query .= "patient_name,surname,date_of_birth,gender,weight,height,respiratory_rate,blood_sugar,bmi, Email";
    $query .= ") VALUES (";
    $query .= " '{$patientName}','{$surname}','{$dob}','$gender', '$weight','$height','{$respiratoryRate}','{$bloodSugar}','{$bmi}','{$email}'";
    $query .= ")";
    if($db->query($query)){
        $session->msg('s',"Patient Registered");
        redirect('../patient-registration.php', false);
    } else {
        $session->msg('d','Failed to add sale');
        redirect('../patient-registration.php', false);
    }
}

?>