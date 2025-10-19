<?php
session_start();
include 'db_connection.php'; // Ensure this file contains the database connection

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Handle application status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['application_id']) && isset($_POST['status'])) {
    $application_id = $_POST['application_id'];
    $status = $_POST['status'];

    // Update application status
    $update_query = "UPDATE admissions SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $status, $application_id);

    if ($stmt->execute()) {
        $success_message = "Application status updated successfully.";
    } else {
        $error_message = "Error updating application status.";
    }
}

// Fetch applications based on their status
$pending_query = "SELECT * FROM admissions WHERE status = 'Pending'";
$approved_query = "SELECT * FROM admissions WHERE status = 'Approved'";
$rejected_query = "SELECT * FROM admissions WHERE status = 'Rejected'";

$pending_result = $conn->query($pending_query);
$approved_result = $conn->query($approved_query);
$rejected_result = $conn->query($rejected_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Applications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        h2, h3 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .table-container {
            margin-bottom: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        table th, table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #3498db;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: inline;
        }

        select {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Manage Applications</h2>

    <?php if (isset($success_message)): ?>
        <p class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
    <?php elseif (isset($error_message)): ?>
        <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <div class="table-container">
        <h3>Pending Applications</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Aadhaar</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>SSLC Marks Card</th>
                    <th>PUC Marks Card</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $pending_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                    <td><?php echo htmlspecialchars($row['adhaar']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                    <td>
                        <?php if (!empty($row['marks_card_1'])): ?>
                            <a href="uploads/<?php echo htmlspecialchars($row['marks_card_1']); ?>" target="_blank">View</a>
                        <?php else: ?>
                            Not Uploaded
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($row['marks_card_2'])): ?>
                            <a href="uploads/<?php echo htmlspecialchars($row['marks_card_2']); ?>" target="_blank">View</a>
                        <?php else: ?>
                            Not Uploaded
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <select name="status" required>
                                <option value="Pending" <?php echo $row['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <h3>Approved Applications</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Aadhaar</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>SSLC Marks Card</th>
                    <th>PUC Marks Card</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $approved_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                    <td><?php echo htmlspecialchars($row['adhaar']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                    <td>
                        <?php if (!empty($row['marks_card_1'])): ?>
                            <a href="uploads/<?php echo htmlspecialchars($row['marks_card_1']); ?>" target="_blank">View</a>
                        <?php else: ?>
                            Not Uploaded
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($row['marks_card_2'])): ?>
                            <a href="uploads/<?php echo htmlspecialchars($row['marks_card_2']); ?>" target="_blank">View</a>
                        <?php else: ?>
                            Not Uploaded
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="table-container">
        <h3>Rejected Applications</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Aadhaar</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>SSLC Marks Card</th>
                    <th>PUC Marks Card</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $rejected_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                    <td><?php echo htmlspecialchars($row['adhaar']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                    <td>
                        <?php if (!empty($row['marks_card_1'])): ?>
                            <a href="uploads/<?php echo htmlspecialchars($row['marks_card_1']); ?>" target="_blank">View</a>
                        <?php else: ?>
                            Not Uploaded
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($row['marks_card_2'])): ?>
                            <a href="uploads/<?php echo htmlspecialchars($row['marks_card_2']); ?>" target="_blank">View</a>
                        <?php else: ?>
                            Not Uploaded
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
