<?php

// Include the file to establish the database connection
require_once '../../database/db-connection.php';

// Insert sample data into the users table
$insertUsers = "INSERT INTO users (username, email, password)
                VALUES
                    ('rehman', 'rehman@example.com', 'rehman123'),
                    ('John Doe', 'john.doe@example.com', 'password123'),
                    ('Jane Smith', 'jane.smith@example.com', 'password456'),
                    ('David Johnson', 'david.johnson@example.com', 'password789')";

// Execute the query
mysqli_query($conn, $insertUsers);

echo 'User data has been inserted successfully!';