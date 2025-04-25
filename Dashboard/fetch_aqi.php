<?php
header("Content-Type: application/json");
include "db_connect.php";

$sql = "SELECT location_name, latitude, longitude, aqi, last_updated FROM sensors WHERE status = 'active'";
$result = $conn->query($sql);

$locations = [];

while ($row = $result->fetch_assoc()) {
    $locations[] = [
        "location" => $row["location_name"],
        "lat" => $row["latitude"],
        "lng" => $row["longitude"],
        "aqi" => $row["aqi"],
        "last_updated" => $row["last_updated"]
    ];
}

$conn->close();
echo json_encode($locations);
?>
