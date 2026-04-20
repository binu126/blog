<?php
// Database connection file
$host = "localhost";
$username = "root";
$password = "";
$dbname = "blog_app";

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define Base URL for the project
define('BASE_URL', '/blog/'); // Adjust this if the folder name is different
?>
