<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('includes/load.php');
$page_title = 'Prescription Form';
include_once('layouts/header.php');
// page_require_level(2);



$items = array();
$sql = "SELECT patient_id, patient_name, surname FROM patients";
$result = $db->query($sql);
while ($row = $result->fetch_assoc()) {
  $items[] = $row;
}



$items1 = array();
$sql1 = "SELECT id, item FROM products";
$result1 = $db->query($sql1);
while ($row1 = $result1->fetch_assoc()) {
  $items1[] = $row1;
}

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
            color: black;
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
    <?php echo display_msg($msg); ?>
    <form method="POST" action="actions/add_prescription.php">
        <div class="form-section">
            <h2>Prescribe Patient</h2>
            <div class="row">
                <div class="column">
                    <label class="label">Medicine Name</label>
                    <select class="input-field" name="medicineName" required>
                        <?php foreach ($items1 as $item): ?>
                            <option value="<?php echo $item['id']; ?>">
                              <?php echo htmlspecialchars($item['item']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="column">
                    <label class="label">Patient Name</label>
                    <select class="input-field" name="patientName" required>
                        <?php foreach ($items as $ite): ?>
                            <option value="<?php echo $ite['patient_id']; ?>,<?php echo $ite['patient_name']; ?> <?php echo $ite['surname']; ?>">
                              <?php echo htmlspecialchars($ite['patient_name']); ?> <?php echo $ite['surname']; ?>
                            </option>
                        <?php endforeach; ?>
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
