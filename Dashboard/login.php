<?php 
session_start();

include("db_connect.php");

$username = $_POST['username'];
$password = $_POST['password'];


$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

$found = false; 

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    
    if (password_verify($password, $row['password'])) {
        $found = true;
        $_SESSION['username'] = $username; 
        header("Location: Home.html"); 
        exit();
    }
}

if (!$found) {
    header("Location: LogError.html");
}

$conn->close();
?>
