"use strict";

var map = L.map("map").setView([7.8731, 80.7718], 7);
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

let markers = [];

function loadAQIData() {
    fetch("fetch_aqi.php")
        .then(response => response.json())
        .then(data => {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];

            data.forEach(sensor => {
                let color = getAQIColor(sensor.aqi);
                let marker = L.circleMarker([sensor.lat, sensor.lng], {
                    radius: 10,
                    color: "black",
                    fillColor: color,
                    fillOpacity: 0.8
                }).bindPopup(`<b>${sensor.location}</b><br>AQI: ${sensor.aqi}`).addTo(map);

                markers.push(marker);
            });
        })
        .catch(error => console.error("Error fetching AQI data:", error));
}

function getAQIColor(aqi) {
    if (aqi <= 50) return "green";
    if (aqi <= 100) return "yellow";
    if (aqi <= 150) return "orange";
    return "red";
}

loadAQIData();
setInterval(loadAQIData, 10000);
