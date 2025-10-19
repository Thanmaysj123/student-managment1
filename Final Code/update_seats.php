<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Assuming a database connection is established
include 'db_connection.php';

// Handle seat update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course = $_POST['course'];
    $remaining_seats = $_POST['remaining_seats'];
    
    $query = "UPDATE courses SET remaining_seats = ? WHERE name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $remaining_seats, $course);

    if ($stmt->execute()) {
        echo "<p>Seats updated successfully for course: " . htmlspecialchars($course) . "</p>";
    } else {
        echo "<p>Error updating seats.</p>";
    }
}

// Fetch all courses and remaining seats
$query = "SELECT name, remaining_seats FROM courses";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Seats</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        input[type="number"] {
            width: 60px;
            padding: 5px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            color: white;
            background-color: #e74c3c;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #c0392b;
        }

        p {
            font-size: 1rem;
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Update Available Seats</h1>
    <table>
        <tr>
            <th>Course</th>
            <th>Remaining Seats</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['remaining_seats']); ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="course" value="<?php echo $row['name']; ?>">
                    <input type="number" name="remaining_seats" min="0" value="<?php echo $row['remaining_seats']; ?>" required>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>