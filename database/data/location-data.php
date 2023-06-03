<?php

// Include the file to establish the database connection
require_once '../../database/db-connection.php';

// Insert sample data into the locations table
$insertLocations = "INSERT INTO locations (location_name)
                    VALUES
                        ('Chicago'),
                        ('Miami'),
                        ('Manama')";

// Execute the query
mysqli_query($conn, $insertLocations);

echo 'Location data has been inserted successfully!';

