<?php
$servername = "localhost";
$username = "root";
$password = ""; // Default password for XAMPP is empty
$dbname = "automatic_tt"; // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
