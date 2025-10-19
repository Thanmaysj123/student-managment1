<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: user_login.php");
    exit();
}

// Assuming a database connection is established
include 'db_connection.php';

// Fetch user details
$user_id = $_SESSION['user_logged_in'];
$query = "SELECT username FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        /* General body styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #f4f4f9;
    min-height: 100vh;
    color: #333;
}

/* Header styling */
h1 {
    font-size: 2rem;
    color: #2c3e50;
    margin-top: 20px;
}

/* Paragraph styling */
p {
    font-size: 1.2rem;
    margin: 10px 0 20px;
}

/* Unordered list styling */
ul {
    list-style-type: none;
    padding: 0;
}

ul li {
    margin-bottom: 30px;
}

ul li a {
    font-size: 1.1rem;
    color: #3498db;
    text-decoration: none;
    padding: 10px 20px;
    border: 1px solid #3498db;
    border-radius: 5px;
    transition: all 0.3s ease;
}

ul li a:hover {
    background-color: #3498db;
    color: white;
    text-decoration: none;
}

/* Logout link styling */
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
    display: inline-block;
}

a[href="logout.php"]:hover {
    background-color: #c0392b;
}
</style>
</head>
<body>
    <h1>Welcome to Bhandarkars' Arts and Science College Admission Website</h1>
    <p>What would you like to do today?</p>
    <ul>
        <li><a href="about_college.php">View About College</a></li>
        <li><a href="admission_form.php">Fill Admission Form</a></li>
        <li><a href="check_status.php">Check Application Status</a></li>
    </ul>
    <a href="logout.php">Logout</a>
</body>
</html>