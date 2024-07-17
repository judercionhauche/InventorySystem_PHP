<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('includes/load.php');
$page_title = 'Prescription Form';
include_once('layouts/header.php');
// page_require_level(2);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Form</title>
    <link rel="stylesheet" href="libs/css/prescription.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .container {
            margin-top: 50px;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        .form-section {
            margin-bottom: 20px;
        }
        .form-section h2 {
            margin-bottom: 20px;
            color: #343a40;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .column {
            flex: 1;
            min-width: 200px;
            padding: 10px;
        }
        .label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .input-field {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background-color: #f8f9fa;
        }
        button {
            background-color: #51aded;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            display: block;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php echo display_msg($msg); ?>
<div class="container">
    <form method="POST" action="">
        <div class="form-section">
            <h2>Prescribe Patient</h2>
            <div class="row">
                <div class="column">
                    <label class="label">Medicine Name</label>
                    <select class="input-field" name="medicineName" required>
                        <!-- Options should be dynamically loaded from the database -->
                        <option value="">Select Medicine</option>
                        <option value="medicine1">Medicine 1</option>
                        <option value="medicine2">Medicine 2</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="column">
                    <label class="label">Patient Name</label>
                    <select class="input-field" name="patientName" required>
                        <!-- Options should be dynamically loaded from the database -->
                        <option value="">Select Patient</option>
                        <option value="patient1">Patient 1</option>
                        <option value="patient2">Patient 2</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="column">
                    <label class="label">Dosage</label>
                    <input class="input-field" type="text" name="dosage" placeholder="Dosage" required>
                </div>
                <div class="column">
                    <label class="label">Number of Days</label>
                    <input class="input-field" type="number" name="numberOfDays" placeholder="number of days" required>
                </div>
                <div class="column">
                    <label class="label">Frequency</label>
                    <input class="input-field" type="text" name="frequency" placeholder="frequency" required>
                </div>
                <div class="column">
                    <label class="label">Route</label>
                    <select class="input-field" name="route" required>
                        <option value="">Select Route</option>
                        <option value="oral">Oral</option>
                        <option value="sublingual">Sublingual</option>
                        <option value="buccal">Buccal</option>
                        <option value="rectal">Rectal</option>
                        <option value="intravenous">Intravenous</option>
                        <option value="intramuscular">Intramuscular</option>
                        <option value="subcutaneous">Subcutaneous</option>
                    </select>
                </div>
                <div class="column">
                <h2>Indicate Further instructions Below:</h2>
                    <label class="label">Instructions</label>
                    <textarea class="input-field" name="instructions" rows="4" required></textarea>
                </div>
            </div>
        </div>
        <button type="submit">Prescribe</button>
    </form>
</div>
<?php include_once('layouts/footer.php'); ?>

</body>
</html>
