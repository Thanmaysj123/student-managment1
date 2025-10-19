<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Assuming a database connection is established
include 'db_connection.php';

// Fetch admin details
$admin_id = $_SESSION['admin_logged_in'];
$query = "SELECT username FROM admins WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin-bottom: 20px;
        }

        ul li {
            margin-bottom: 15px;
        }

        ul li a {
            font-size: 1.1rem;
            color: #3498db;
            text-decoration: none;
            padding: 10px 20px;
            border: 1px solid #3498db;
            border-radius: 5px;
            transition: all 0.3s ease;
            display: inline-block;
        }

        ul li a:hover {
            background-color: #3498db;
            color: white;
        }

        a[href="logout.php"] {
            font-size: 1rem;
            color: white;
            background-color: #e74c3c;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        a[href="logout.php"]:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($admin['username']); ?>!</h1>
    <p>Here are your administrative options:</p>
    <ul>
        <li><a href="manage_applications.php">Manage Applications</a></li>
        <li><a href="update_seats.php">Update Available Seats</a></li>
        <li><a href="about_college.php">View About College Page</a></li>
    </ul>
    <a href="logout.php">Logout</a>
</body>
</html>