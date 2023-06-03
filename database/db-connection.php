<?php

// Database configuration
$host = 'localhost';
$dbName = 'customuser';
$username = 'root';
$password = '';

// Create a new database connection
$conn = new mysqli($host, $username, $password, $dbName);

// Check the connection
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

// Set the character set
$conn->set_charset('utf8mb4');
