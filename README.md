# Air Quality Monitoring System

The application is designed to facilitate air quality monitoring by integrating real-time data collection and display features. 
The system retrieves live Air Quality Index (AQI) data from an external API, stores it in a local database (air_quality_db), and provides JSON endpoints for frontend applications (such as maps and dashboards).
Testing ensures data accuracy, API reliability, database integrity, and system responsiveness.

## Functions :- 
- Fetching and displaying air quality index (AQI) data.
- Graphical Data Visualization.
- Viewing Air Quality via the Map.
- Viewing Alerts.
- Logging and Logout.
- Managing Admin Users.

## Objectives :- 
- To validate that AQI data is correctly fetched, processed, stored, and retrieved.
- To ensure the database and API endpoints operate without errors.
- To confirm that server-side scripts (get_aqi_data.php, fetch_aqi.php, fetch_data.php) function according to specifications.
- To verify system robustness under typical and edge-case scenarios.
- To design a user-friendly and functional web dashboard for air quality monitoring.
- To enable administrative control features like login/logout and user management.
- To use server-side scripting and database connectivity for real-time data operations.

## Database Implementation
The “air_quality_db” represents the system database. The system contains three essential tables. :-  
- aqi_data :- Stores historical AQI readings.
- sensors :- Sensors table contains AQI readings together with detailed pollutant information about 
PM2.5 along with PM10, CO, NO2, SO2, O3, Temperature and Humidity.
- users :- Every secure part of the system requires admin login credentials which are handled by this 
table. 

## Techs and Tools :- 
- html / css / js
- PHP
- phpMyAdmin
- Postman
- Server :- Localhost (XAMPP)
- API Source :- World Air Quality Index Project API
- VS Code
