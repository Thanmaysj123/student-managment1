<?php
session_start();
include 'db_connection.php'; // Ensure this file contains the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $gender = $_POST['gender'];
    $adhaar = $_POST['adhaar'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $district = $_POST['district'];
    $pincode = $_POST['pincode'];
    $course = $_POST['course']; // New field for course selection

    // File uploads
    $marks_card_1 = $_FILES['marks_card_1']['name'];
    $marks_card_2 = $_FILES['marks_card_2']['name'];

    // Move uploaded files to the server
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    move_uploaded_file($_FILES['marks_card_1']['tmp_name'], $uploadDir . $marks_card_1);
    move_uploaded_file($_FILES['marks_card_2']['tmp_name'], $uploadDir . $marks_card_2);

    // Check if the Aadhaar number already exists
    $check_query = "SELECT * FROM admissions WHERE adhaar = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $adhaar);
    $stmt->execute();
    $result = $stmt->get_result();
 
    if ($result->num_rows > 0) {
        // Aadhaar number already exists
        $error_message = "An application with the provided Aadhaar number already exists.";
    } else {

        // Insert data into the database
        $query = "INSERT INTO admissions (name, mobile, father_name, mother_name, gender, adhaar, email, dob, address, state, district, pincode, course, marks_card_1, marks_card_2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssssssssss", $name, $mobile, $father_name, $mother_name, $gender, $adhaar, $email, $dob, $address, $state, $district, $pincode, $course, $marks_card_1, $marks_card_2);
        if ($stmt->execute()) {
           $success_message = "Application submitted successfully!You can now check your status.";
           $redirectURL = "check_status.php";
            echo "<script>
                alert('$success_message');
                window.location.href ='$redirectURL';
                </script>";
        } else {
           echo "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admission Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        h2 {
            color: #2c3e50;
            margin-top: 20px;
        }

        form {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"], input[type="email"], input[type="date"], textarea, select, input[type="file"] {
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

        textarea {
            resize: vertical;
            height: 100px;
        }

        input[type="file"] {
            border: none;
        }
        .message.error {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Admission Form</h2>
    <?php if (isset($error_message)): ?>
            <p class="message error"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="mobile">Mobile Number:</label>
        <input type="text" id="mobile" name="mobile" pattern="[6-9][0-9]{9}" title="Must be a 10-digit number starting with 6-9" required><br>

        <label for="father_name">Father's Name:</label>
        <input type="text" id="father_name" name="father_name" required><br>

        <label for="mother_name">Mother's Name:</label>
        <input type="text" id="mother_name" name="mother_name" required><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select><br>

        <label for="adhaar">Adhaar Number:</label>
        <input type="text" id="adhaar" name="adhaar" pattern="[0-9]{12}" title="Must be a 12-digit number" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea><br>

        <label for="state">State:</label>
        <input type="text" id="state" name="state" required><br>

        <label for="district">District:</label>
        <input type="text" id="district" name="district" required><br>

        <label for="pincode">Area Pincode:</label>
        <input type="text" id="pincode" name="pincode" pattern="[0-9]{6}" title="Must be a 6-digit number" required><br>

        <label for="course">Course:</label>
        <select id="course" name="course" required>
            <option value="Science">Science</option>
            <option value="Commerce">Commerce</option>
            <option value="Arts">Arts</option>
        </select><br>

        <label for="marks_card_1">SSLC Marks Card :</label>
        <input type="file" id="marks_card_1" name="marks_card_1" accept=".pdf" required><br>

        <label for="marks_card_2">PUC Marks Card :</label>
        <input type="file" id="marks_card_2" name="marks_card_2" accept=".pdf" required><br>

        <button type="submit">Apply</button>
    </form>
</body>
</html>
