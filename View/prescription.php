<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Form</title>
    <link rel="stylesheet" href="../libs/css/prescription.css">
    <style>
        /* CSS styles remain the same */
    </style>
</head>
<body>
<div class="container">
    <form method="POST" action="">
        <div class="form-section">
            <h2>Prescription Details</h2>
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
                    <input class="input-field" type="text" name="dosage" required>
                </div>
                <div class="column">
                    <label class="label">Number of Days</label>
                    <input class="input-field" type="number" name="numberOfDays" required>
                </div>
                <div class="column">
                    <label class="label">Frequency</label>
                    <input class="input-field" type="text" name="frequency" required>
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
                    <label class="label">Instructions</label>
                    <textarea class="input-field" name="instructions" rows="4" required></textarea>
                </div>
            </div>
        </div>
        <button type="submit">Prescribe</button>
    </form>
</div>


</body>
</html>
