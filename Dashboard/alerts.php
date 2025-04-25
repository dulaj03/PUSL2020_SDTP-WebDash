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
    <title>Air Quality Monitor - Alerts</title>
    <link rel="icon" type="image/png" href="Img/IMG_9098.PNG">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #0a192f;
        color: #d1d5db;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        text-align: center;
    }

    h1 {
        font-size: 2.2rem;
        color: #60a5fa;
        margin-bottom: 20px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
    }

    .alert-container {
        width: 85%;
        max-width: 1000px;
        background-color: #1e293b;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
        margin-bottom: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 14px;
        text-align: center;
        border-bottom: 1px solid rgba(209, 213, 219, 0.2);
    }

    th {
        background-color: #2d3748;
        color: #60a5fa;
        font-size: 16px;
    }

    td {
        font-size: 15px;
        color: #d1d5db;
    }

    .alert {
        padding: 15px;
        margin: 15px 0;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        color: white;
    }

    .alert.moderate {
        background-color: #f59e0b;
    }

    .alert.unhealthy-sensitive {
        background-color: #f97316;
    }

    .alert.unhealthy {
        background-color: #ef4444;
    }

    .back-button {
        margin-top: 20px;
    }

    .back-button a {
        background-color: #ef4444;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 16px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .back-button a:hover {
        background-color: #dc2626;
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
