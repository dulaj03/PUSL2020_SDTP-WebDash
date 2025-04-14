<?php
header("Content-Type: application/json");
include "db_connect.php";
date_default_timezone_set('Asia/Colombo');

$api_key = "f68a2cae892afcfaa6efb0003d5391a2ab6673d0";  
$locations = ["Colombo", "India", "Chennai", "Tokyo", "London"]; 

$results = [];

foreach ($locations as $city) {
    $api_url = "https://api.waqi.info/feed/$city/?token=$api_key";

    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if ($data && isset($data["status"]) && $data["status"] === "ok") {
        
        $aqi = $data["data"]["aqi"];
        $pm25 = $data["data"]["iaqi"]["pm25"]["v"] ?? "N/A";
        $pm10 = $data["data"]["iaqi"]["pm10"]["v"] ?? "N/A";
        $co = $data["data"]["iaqi"]["co"]["v"] ?? "N/A";
        $no2 = $data["data"]["iaqi"]["no2"]["v"] ?? "N/A";
        $so2 = $data["data"]["iaqi"]["so2"]["v"] ?? "N/A";
        $o3 = $data["data"]["iaqi"]["o3"]["v"] ?? "N/A";
        $temperature = $data["data"]["iaqi"]["t"]["v"] ?? "N/A";
        $humidity = $data["data"]["iaqi"]["h"]["v"] ?? "N/A";
        $lat = $data["data"]["city"]["geo"][0];
        $lng = $data["data"]["city"]["geo"][1];
        $last_updated = date("Y-m-d H:i:s");

        
        $stmt = $conn->prepare("
            INSERT INTO sensors (location_name, latitude, longitude, aqi, pm25, pm10, co, no2, so2, o3, temperature, humidity, status, last_updated) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active', ?)
            ON DUPLICATE KEY UPDATE 
                aqi = VALUES(aqi), pm25 = VALUES(pm25), pm10 = VALUES(pm10), co = VALUES(co), 
                no2 = VALUES(no2), so2 = VALUES(so2), o3 = VALUES(o3), 
                temperature = VALUES(temperature), humidity = VALUES(humidity),
                last_updated = VALUES(last_updated)
        ");

        $stmt->bind_param("sddiiiiiiidds", $city, $lat, $lng, $aqi, $pm25, $pm10, $co, $no2, $so2, $o3, $temperature, $humidity, $last_updated);
        $stmt->execute();
        $stmt->close();

        $results[] = [
            "location" => $city,
            "lat" => $lat,
            "lng" => $lng,
            "aqi" => $aqi,
            "last_updated" => $last_updated
        ];
    }
}

$conn->close();
header ('Location: dashbord.php');
echo json_encode(["success" => true, "data" => $results]);
?>
