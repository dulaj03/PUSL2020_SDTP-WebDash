<?php
header("Content-Type: application/json");
include "db_connect.php";

$sql = "SELECT location_name, latitude, longitude, aqi, pm25, pm10, co, no2, so2, o3, temperature, humidity, last_updated FROM sensors WHERE status = 'active'";
$result = $conn->query($sql);

$locations = [];

while ($row = $result->fetch_assoc()) {
    $locations[] = [
        "location" => $row["location_name"],
        "lat" => $row["latitude"],
        "lng" => $row["longitude"],
        "aqi" => $row["aqi"],
        "pm25" => $row["pm25"],
        "pm10" => $row["pm10"],
        "co" => $row["co"],
        "no2" => $row["no2"],
        "so2" => $row["so2"],
        "o3" => $row["o3"],
        "temperature" => $row["temperature"],
        "humidity" => $row["humidity"],
        "last_updated" => $row["last_updated"]
    ];
}

$conn->close();
echo json_encode($locations);
?>
