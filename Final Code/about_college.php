<?php
session_start();
$is_logged_in = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About College</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: url('college.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            text-align: center;
        }

        header h1 {
            color: #f39c12;
        }

        section {
            flex: 1;
            padding: 20px;
        }

        article {
            margin-bottom: 40px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        article h2 {
            color: #f39c12;
            margin-bottom: 10px;
        }

        article p {
            line-height: 1.6;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        .gallery img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .seats-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            color: #000;
            border-radius: 8px;
            overflow: hidden;
        }

        .seats-table th, .seats-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .seats-table th {
            background-color: #f39c12;
            color: #fff;
            font-weight: bold;
        }

        .seats-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .seats-table tr:hover {
            background-color: #f1f1f1;
        }

        .admission-link {
            display: block;
            text-align: center;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            font-size: 1.2rem;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .admission-link:hover {
            background-color: #2980b9;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 10px;
            text-align: center;
            color: #f39c12;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to BHANDARKARS' ARTS AND SCIENCE COLLEGE KUNDAPURA</h1>
    </header>

    <section>
        <article>
            <h2>About Us</h2>
            <p>BHANDARKARS' ARTS & SCIENCE COLLEGE, Kundapura is a first grade college of Arts, Science and Commerce.
                 This College came into existence mainly as a result of the munificent donation of Rs.2,00,000 by 
                 Dr.A.S. Bhandarkar who was then practicing as a doctor at Bahrain, Persian Gulf. Many leading citizens 
                 of Kundapura and Rotary Club of Kundapura strove hard for the opening of this college which was a long 
                 felt need of the taluk. With the co-operation of the public of Kundapura (managed by BASC Trust),Academy
                  of General Education, Manipal took up the responsibility of rearing this institution. The College is
                   re-accredited 'A' by NAAC in the year 2017. The College, sponsored by the Academy of General Education, Manipal
                    started functioning from June, 1963 and today is one of the progressive institutions affiliated to 
                    the Mangalore University.</p>
        </article>

        <article>
            <h2>Courses Offered</h2>
            <h4>Bachelor of Commerce</h4>
            <p>The Bachelor of Commerce degree is designed to provide students with a wide range 
            of managerial skills, while building competence in a particular area of business.</p>
            <h4>Bachelor of Arts</h4>
            <p>Earning your Bachelor of Arts degree is one of the most effective ways to
			open doors to a wide variety of career options and advancement and even the fine arts, writing, or 
			journalism.</p>
            <h4>Bachelor of Science</h4>
            <p>Bachelor of Science degree is usually more focused on that particular 
			discipline and is targeted toward students intending
			to pursue graduate school or a profession in that discipline.</p>
        </article>

        <article>
            <h2>Gallery</h2>
            <div class="gallery">
                <img src="/clg1.jpg" alt="College Image 1">
                <img src="/clg2.jpg" alt="College Image 2">
                <img src="/clg3.jpg" alt="College Image 3">
                <!-- Add more images as required -->
            </div>
        </article>

        <article>
            <h2>Seats Available</h2>
            <table class="seats-table">
                <tr>
                    <th>Course</th>
                    <th>Available Seats</th>
                </tr>
                <?php
                // Include the database connection
                include 'db_connection.php';

                // Fetch the courses and available seats
                $query = "SELECT name, remaining_seats FROM courses";
                $result = $conn->query($query);

                // Display each course and its available seats
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['remaining_seats']) . "</td>";
                    echo "</tr>";
                }

                // Close the database connection
                $conn->close();
                ?>
            </table>
        </article>

        <article>
            <h2>Contact Us</h2>
            <p> Bhandarkars' Arts And Science College Kundapura</p>
            <p> Mobile: +918254230369,08254-230469 ,PUC Office-08254-235056</p>
            <p> Mail: principal@basck.in</p>
            <p> Fax: +91 8254 235043</p>
            <p> Website: www.basck.in</p>
            <p> Address: Bhandarkars' Arts and Science College, Kundapura, Udupi, Karnataka, India</p>
        </article>
        <?php if ($is_logged_in): ?>
            <a href="admission_form.php" class="admission-link">Apply for Admission</a>
        <?php endif; ?>
    </section>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> [Your College Name]. All rights reserved.</p>
    </footer>
</body>
</html>