<?php
$page_title = 'Register Patient';
require_once('includes/load.php');
page_require_level(3);
include_once('layouts/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration Form</title>
    <link rel="stylesheet" href="libs/css/patient-style.css">
</head>
<body>
<?php echo display_msg($msg); ?>
<div class="container">
    <form method="POST" action="actions/patient_registration_actions.php">
        <div class="form-section">
            <h2>Patient Details</h2>
            <div class="row">
                <div class="column">
                    <label class="label">Patient Name</label>
                    <input class="input-field" type="text" name="patientName" placeholder=" First Name" required>
                </div>
                <div class="column">
                    <label class="label">Surname</label>
                    <input class="input-field" type="text" name="surname" placeholder="Last Name" required>
                </div>
                <div class="column">
                    <label class="label">Email</label>
                    <input class="input-field" type="text" name="email" placeholder="email" required>
                </div>
                <div class="column">
                    <label class="label">Date of Birth</label>
                    <input class="input-field" type="date" name="dateOfBirth"  required>
                </div>
                <div class="column">
                    <label class="label">Gender</label>
                    <select class="input-field" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="form-section">
            <h2>Medical Information</h2>
            <div class="row">
                <div class="column">
                    <label class="label">Weight (kg)</label>
                    <input class="input-field" type="number" name="weight" id="weight" step="0.01" placeholder="Weight(cm)" required>
                </div>
                <div class="column">
                    <label class="label">Height (cm)</label>
                    <input class="input-field" type="number" name="height" id="height" step="0.01" placeholder="Height" required>
                </div>
                <div class="column">
                    <label class="label">Respiratory Rate (/min)</label>
                    <input class="input-field" type="number" name="respiratoryRate" placeholder="respiratory rate" required>
                </div>
                <div class="column">
                    <label class="label">Blood Sugar</label>
                    <input class="input-field" type="number" name="bloodSugar" placeholder="Blood Sugar" required>
                </div>
            </div>
        </div>
        <div class="form-section">
            <h2>BMI(kg/m²)</h2>
            <div class="row">
                <div class="column">
                    <label class="label">BMI (kg/m²)</label>
                    <input class="input-field" type="text" name="bmi" id="bmi" readonly>
                </div>
            </div>
        </div>
        <button type="submit">Submit</button>
    </form>
</div>

<script>
    // Get references to weight, height, and BMI input fields
    const weightInput = document.getElementById('weight');
    const heightInput = document.getElementById('height');
    const bmiInput = document.getElementById('bmi');

    // Function to calculate BMI
    function calculateBMI() {
        const weight = parseFloat(weightInput.value);
        const height = parseFloat(heightInput.value) / 100; // Convert height to meters

        if (weight > 0 && height > 0) {
            const bmi = (weight / (height * height)).toFixed(2);
            bmiInput.value = bmi;
        } else {
            bmiInput.value = '';
        }
    }

    // Event listeners to trigger BMI calculation
    weightInput.addEventListener('input', calculateBMI);
    heightInput.addEventListener('input', calculateBMI);
</script>

<?php include_once('layouts/footer.php'); ?>
</body>
</html>
