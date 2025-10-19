-- Create the database
CREATE DATABASE college_admission;

-- Use the database
USE college_admission;

-- Create the users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the admins table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the admissions table
-- Table to store admission form details
CREATE TABLE admissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    mobile VARCHAR(10) NOT NULL,
    father_name VARCHAR(255) NOT NULL,
    mother_name VARCHAR(255) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    adhaar VARCHAR(12) NOT NULL,
    email VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    address TEXT NOT NULL,
    state VARCHAR(255) NOT NULL,
    district VARCHAR(255) NOT NULL,
    pincode VARCHAR(6) NOT NULL,
    marks_card_1 VARCHAR(255) NOT NULL,
    marks_card_2 VARCHAR(255) NOT NULL,
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin can update the status of the application
-- Use the following query to approve or reject an application:
-- UPDATE admissions SET status = 'Approved' WHERE id = ?;

-- Create the courses table
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    remaining_seats INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample admin
INSERT INTO admins (username, email, password)
VALUES ('admin', 'admin@example.com', '$2y$10$examplehashforpassword');

-- Insert sample courses
INSERT INTO courses (name, remaining_seats)
VALUES 
('Science', 50),
('Arts', 30),
('Commerce', 40);