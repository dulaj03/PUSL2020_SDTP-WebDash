<?php

include "db_connect.php";


$sql = "SELECT location_name, aqi FROM sensors WHERE status = 'active'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    
    function checkForAlerts($aqi, $location) {
        if ($aqi <= 50) {
            return null; 
        } else if ($aqi <= 100) {
            return "Moderate AQI in $location: $aqi - Take precautions!";
        } else if ($aqi <= 150) {
            return "Unhealthy for Sensitive People in $location: $aqi - Stay cautious!";
        } else {
            return "Unhealthy AQI in $location: $aqi - Avoid outdoor activities!";
        }
    }

    
    $locations = [];

   
    while ($row = $result->fetch_assoc()) {
        $alert = checkForAlerts($row['aqi'], $row['location_name']);
        $locations[] = [
            'location' => $row['location_name'],
            'aqi' => $row['aqi'],
            'alert' => $alert
        ];
    }
} else {
    
    $error_message = "No active air quality data found.";
    $locations = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air Quality Alerts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #0a192f;
            color: #d1d5db;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        h1 {
            text-align: center;
            color: #60a5fa;
            margin-bottom: 20px;
        }

        .alert-container {
            width: 80%;
            max-width: 1000px;
            margin: 20px;
            background-color: #1e293b;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #2d3748;
        }

        .alert {
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            color: white;
            font-size: 16px;
        }

        .alert.moderate {
            background-color: #ffb74d;
        }

        .alert.unhealthy-sensitive {
            background-color: #ff7043;
        }

        .alert.unhealthy {
            background-color: #d32f2f;
        }

        .back-button {
            margin-top: 20px;
        }

        .back-button a {
            color: white;
            background-color: red;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .back-button a:hover {
            background-color: orangered;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #60a5fa;
        }
    </style>
</head>
<body>

    <h1>Air Quality Alerts</h1>

    <div class="alert-container">
        <?php if (isset($error_message)): ?>
            <div class="alert"><?php echo $error_message; ?></div>
        <?php elseif (count($locations) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>AQI</th>
                        <th>Alert</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($locations as $location): ?>
                        <tr>
                            <td><?php echo $location['location']; ?></td>
                            <td><?php echo $location['aqi']; ?></td>
                            <td>
                                <?php if ($location['alert']): ?>
                                    <div class="alert <?php echo strpos($location['alert'], 'Moderate') !== false ? 'moderate' : (strpos($location['alert'], 'Sensitive') !== false ? 'unhealthy-sensitive' : 'unhealthy'); ?>">
                                        <?php echo $location['alert']; ?>
                                    </div>
                                <?php else: ?>
                                    No alert
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert">No alerts at the moment. Air quality is good!</div>
        <?php endif; ?>
    </div>

    <div class="back-button">
        <a href="Home.html">Back</a>
    </div>
    <div class="footer">
        <p>&copy; 2025 Air Quality Monitoring System</p>
    </div>

</body>
</html>
