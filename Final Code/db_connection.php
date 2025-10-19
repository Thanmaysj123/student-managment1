<?php
// Database connection details
$servername = "localhost"; // Typically "localhost" for local servers
$username = "root";        // Default username for local servers
$password = "";            // Default password for local servers (leave empty for XAMPP/WAMP)
$dbname = "college_admission"; // Name of your database

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>