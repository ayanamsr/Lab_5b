<?php

// Database configuration
$host = 'localhost';  // Database host (e.g., localhost)
$username = 'root';   // Database username
$password = '';       // Database password
$database = 'lab_5b'; // Database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set character set to UTF-8
if (!$conn->set_charset("utf8")) {
    die("Error loading character set utf8: " . $conn->error);
}

?>
