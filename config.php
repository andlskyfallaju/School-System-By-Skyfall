<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$database = "school_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check if connection works
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
