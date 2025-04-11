<?php

include "db_connect.php";


if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param('i', $admin_id);

    if ($stmt->execute()) {
        
        header('Location: viewAdmin.php');
        exit();
    } else {
        echo "Error deleting admin: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    
    header('Location: viewAdmin.php');
    exit();
}
