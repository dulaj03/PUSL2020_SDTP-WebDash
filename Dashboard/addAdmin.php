<?php

include "db_connect.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

   
    $check_sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        
        
        echo "<script>alert('Username already exists. Please choose a different username.'); window.location.href='addAdmin.html';</script>";
    } else {
        $insert_sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param('ss', $username, $password);

        if ($stmt->execute()) {
            
            echo "<script>alert('Admin added successfully!'); window.location.href='viewAdmin.php';</script>";
        } else {
            
            echo "<script>alert('Error adding admin: " . $conn->error . "');</script>";
        }

        $stmt->close();
    }

    $conn->close();
}
?>
