<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Confirmation</title>
    <link rel="stylesheet" href="../libs/css/confirmation.css">
    <style>
        /* Additional styles */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 70vh;
            background-color: #f9f9f9;
            border-radius: 10px;
        }

        .tick-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 100px;
            background-color: #4CAF50;
            border-radius: 50%;
            margin-bottom: 20px;
            position: relative;
        }

        .tick {
            width: 50px;
            height: 25px;
            border-left: 5px solid white;
            border-bottom: 5px solid white;
            transform: rotate(-45deg);
            position: absolute;
            top: 50%;
            left: 50%;
            transform-origin: left bottom;
            animation: drawTick 0.5s ease-in-out forwards;
        }

        @keyframes drawTick {
            from {
                width: 0;
                height: 0;
            }
            to {
                width: 50px;
                height: 25px;
            }
        }

        .message {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 1.5em;
            color: #333;
            text-align: center;
        }

        .prescription-details {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin-top: 20px;
            font-size: 1.2em;
            color: #666;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="tick-container">
        <div class="tick"></div>
    </div>
    <div class="message">Prescription successful to <span id="patientName"></span></div>
    <div class="prescription-details">
        <p><strong>Medicine Name:</strong> <span id="medicineName"></span></p>
        <p><strong>Dosage:</strong> <span id="dosage"></span></p>
        <p><strong>Number of Days:</strong> <span id="numberOfDays"></span></p>
        <p><strong>Frequency:</strong> <span id="frequency"></span></p>
        <p><strong>Route:</strong> <span id="route"></span></p>
        <p><strong>Instructions:</strong> <span id="instructions"></span></p>
    </div>
</div>

<script>
    // Dummy data to simulate the prescription details
    const prescription = {
        patientName: 'John Doe',
        medicineName: 'Medicine 1',
        dosage: '500mg',
        numberOfDays: 7,
        frequency: '3 times a day',
        route: 'Oral',
        instructions: 'Take with food'
    };

    // Populate the prescription details
    document.getElementById('patientName').textContent = prescription.patientName;
    document.getElementById('medicineName').textContent = prescription.medicineName;
    document.getElementById('dosage').textContent = prescription.dosage;
    document.getElementById('numberOfDays').textContent = prescription.numberOfDays;
    document.getElementById('frequency').textContent = prescription.frequency;
    document.getElementById('route').textContent = prescription.route;
    document.getElementById('instructions').textContent = prescription.instructions;
</script>

</body>
</html>
