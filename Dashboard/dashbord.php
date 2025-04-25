<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air Quality - Update Dashboard</title>
    <link rel="icon" type="image/png" href="Img/IMG_9098.PNG">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(to right, #0a192f, #1e293b);
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
    font-size: 36px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    margin-bottom: 10px;
}

.container {
    width: 90%;
    max-width: 1200px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 20px;
}

.table-container, .charts-container {
    width: 100%;
    background: rgba(30, 41, 59, 0.95);
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
    backdrop-filter: blur(6px);
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: center;
    border: 1px solid #334155;
}

th {
    background-color: #2563eb;
    color: white;
}

td {
    background-color: #1e293b;
    color: #d1d5db;
}

.charts {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

canvas {
    width: 500px !important;
    height: 350px !important;
}

.update-button, .back-button {
    display: flex;
    justify-content: center;
    margin-bottom: 15px;
}

.update-button button,
.back-button button {
    padding: 12px 24px;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease-in-out;
}

.update-button button {
    background: linear-gradient(90deg, #2563eb, #1e40af);
    color: white;
    border: none;
}

.back-button button {
    background: linear-gradient(90deg, #ef4444, #b91c1c);
    color: white;
    border: none;
}

.update-button button:hover,
.back-button button:hover {
    transform: scale(1.05);
    opacity: 0.95;
}

.footer {
    margin-top: 30px;
    font-size: 14px;
    color: #60a5fa;
}

/* Optional animation for subheading */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
    </style>
    
        <script>
    function updateClock() {
        const now = new Date();
        const options = { timeZone: 'Asia/Colombo', hour12: true, hour: '2-digit', minute: '2-digit', second: '2-digit' };
        const timeString = now.toLocaleTimeString('en-US', options);
        
        document.getElementById('real-time-clock').innerText = "Time: " + timeString;
    }

    
    setInterval(updateClock, 1000);
    updateClock(); 
</script>

    
    
</head>
<body>

    <h1>Air Quality Dashboard</h1>
    <p style="font-size: 18px; color: #a5f3fc; margin-top: -10px; margin-bottom: 30px; text-shadow: 0 1px 3px rgba(0,0,0,0.6); animation: fadeIn 2s ease-in-out;">
    Real-time insights for a healthier tomorrow ✨🌿
</p>
    

    <div class="update-button">
        <form action="get_aqi_data.php">
            <button type="submit">Update Data</button>
        </form>
    </div>
    
    <div class="container">
        <div class="table-container">
            <h2>Air Quality Data</h2>
            <div id="real-time-clock" style="font-size: 18px; font-weight: bold; color: white;"></div>

            <table id="data-table">
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>AQI</th>
                        <th>PM2.5</th>
                        <th>PM10</th>
                        <th>CO</th>
                        <th>NO2</th>
                        <th>SO2</th>
                        <th>O3</th>
                        <th>Temperature</th>
                        <th>Humidity</th>
                        <th>Last Updated</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="charts-container">
            <h2>Air Quality Graphs</h2>
            <div class="charts">
                <canvas id="aqi-chart"></canvas>
                <canvas id="pm25-chart"></canvas>
                <canvas id="pm10-chart"></canvas>
                <canvas id="co-chart"></canvas>
                <canvas id="no2-chart"></canvas>
                <canvas id="so2-chart"></canvas>
                <canvas id="temperature-chart"></canvas>
            </div>
        </div>
    </div>

    <script>
        function refreshData() {
            $.ajax({
                url: 'fetch_data.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        $("#data-table tbody").empty();
                        data.forEach(sensor => {
                            $("#data-table tbody").append(`
                                <tr>
                                    <td>${sensor.location}</td>
                                    <td>${sensor.aqi}</td>
                                    <td>${sensor.pm25 ?? "--"}</td>
                                    <td>${sensor.pm10 ?? "--"}</td>
                                    <td>${sensor.co ?? "--"}</td>
                                    <td>${sensor.no2 ?? "--"}</td>
                                    <td>${sensor.so2 ?? "--"}</td>
                                    <td>${sensor.o3 ?? "--"}</td>
                                    <td>${sensor.temperature} °C</td>
                                    <td>${sensor.humidity} %</td>
                                    <td>${sensor.last_updated}</td>
                                </tr>
                            `);
                        });
                        updateCharts(data);
                    }
                },
                error: function() { alert("Error fetching data."); }
            });
        }

        function updateCharts(data) {
            let locations = data.map(sensor => sensor.location);
            let datasets = [
                { id: 'aqi-chart', label: 'AQI', data: data.map(s => s.aqi), color: '#ff4757' },
                { id: 'pm25-chart', label: 'PM2.5', data: data.map(s => s.pm25 ?? 0), color: '#3742fa' },
                { id: 'pm10-chart', label: 'PM10', data: data.map(s => s.pm10 ?? 0), color: '#2ed573' },
                { id: 'co-chart', label: 'CO', data: data.map(s => s.co ?? 0), color: '#ffa502' },
                { id: 'no2-chart', label: 'NO2', data: data.map(s => s.no2 ?? 0), color: '#8c7ae6' },
                { id: 'so2-chart', label: 'SO2', data: data.map(s => s.so2 ?? 0), color: '#00cec9' },
                { id: 'temperature-chart', label: 'Temperature (°C)', data: data.map(s => s.temperature ?? 0), color: '#ff6b81' }
            ];

            datasets.forEach(set => {
                new Chart(document.getElementById(set.id), {
                    type: 'bar',
                    data: {
                        labels: locations,
                        datasets: [{ 
                            label: set.label, 
                            data: set.data, 
                            backgroundColor: set.color, 
                            borderColor: set.color, 
                            borderWidth: 1 
                        }]
                    },
                    options: { 
                        responsive: true, 
                        scales: { 
                            y: { 
                                beginAtZero: true,
                                ticks: { color: '#ffffff' } 
                            },   
                            x: {
                                ticks: { color: '#ffffff' } 
                            }
                        }, 
                        plugins: { 
                            legend: { labels: { color: '#ffffff', font: { size: 20 } } }, 
                            tooltip: { titleColor: '#ffffff', bodyColor: '#ffffff' } 
                        } 
                    }
                });
            });
        }

        function goBack() {
            
            window.history.back();
        }

        refreshData();
        setInterval(refreshData, 10000);
    </script><div class="back-button"><form action="Home.html"><button type="submit">Back</button></form>
        
    </div>
    
<div class="footer">
        <p>&copy; 2025 Air Quality Monitoring System</p>
    </div>
</body>
</html>
