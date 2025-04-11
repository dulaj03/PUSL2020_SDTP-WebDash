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
    <title>View Admins</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #0a192f;
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
            color: #60a5fa;
            margin-bottom: 30px;
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
            background-color: #f44336;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            color: white;
        }

        .back-button:hover {
            background-color: #d32f2f;
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
