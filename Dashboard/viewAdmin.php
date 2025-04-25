<?php

include "db_connect.php";


$sql = "SELECT * FROM users";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    $admins = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $admins = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AQ Monitor - View Admins</title>
    <link rel="icon" type="image/png" href="Img/IMG_9098.PNG">
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        flex-direction: column;
        background-color: #0a192f;
        color: #d1d5db;
    }

    h1 {
        color: #60a5fa;
        margin-bottom: 30px;
        font-size: 2.2rem;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }

    .admin-table {
        width: 80%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #2d3748;
    }

    .back-button {
        padding: 10px 20px;
        background: linear-gradient(90deg, #f44336, #d32f2f);
        text-decoration: none;
        border-radius: 10px;
        color: white;
        font-size: 17px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .back-button:hover {
        background: linear-gradient(90deg, #d32f2f, #f44336);
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .back-button:focus {
        outline: none;
    }
</style>

</head>
<body>

    <h1>View Admins</h1>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?php echo $admin['id']; ?></td>
                    <td><?php echo $admin['username']; ?></td>
                    <td>
                        
                        <button onclick="deleteAdmin(<?php echo $admin['id']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="back-button">
        <a href="admin.html">Back</a>
    </div>

    <script>
        function deleteAdmin(adminId) {
            if (confirm("Are you sure you want to delete this admin?")) {
                window.location.href = 'deleteAdmin.php?id=' + adminId;
            }
        }
    </script>

</body>
</html>
