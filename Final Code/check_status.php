<?php
session_start();
include 'db_connection.php'; // Ensure this file contains the database connection

$status_message = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adhaar = $_POST['adhaar'];

    // Check if the Aadhaar number exists in the database
    $check_query = "SELECT status FROM admissions WHERE adhaar = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $adhaar);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the application status
        $row = $result->fetch_assoc();
        $status_message = "Your application status is: " . htmlspecialchars($row['status']);
    } else {
        $error_message = "No application found with the provided Aadhaar number.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Application Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"] {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1rem;
            width: 100%;
        }

        button:hover {
            background-color: #2980b9;
        }

        .message {
            font-size: 1.1rem;
            color: #2c3e50;
        }

        .message.not-found {
            color: red;
        }

        .message.success {
            color: green;
        }
        .dashboard-btn {
            background-color: #2ecc71;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            display: inline-block;
            font-size: 1rem;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .dashboard-btn:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Check Application Status</h2>
        <?php if (isset($status_message)): ?>
            <p class="message success">
                <?php echo htmlspecialchars($status_message); ?>
            </p>
        <?php else: ?>
            <form method="POST">
                <?php if (isset($error_message)): ?>
                    <p class="message not-found"><?php echo htmlspecialchars($error_message); ?></p>
                <?php endif; ?>
                <label for="adhaar">Enter Aadhaar Number:</label>
                <input type="text" id="adhaar" name="adhaar" pattern="[0-9]{12}" title="Must be a 12-digit number" required>
                <button type="submit">Check Status</button>
            </form>
        <?php endif; ?>
        <a href="user_dashboard.php" class="dashboard-btn">Return to Dashboard</a>
    </div>
</body>
</html>
