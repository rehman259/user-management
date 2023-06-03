<?php

// Include the database connection
require_once '../database/db-connection.php';

// Create an empty array to store the users and locations data
$response = array(
    "users" => array(),
    "locations" => array()
);

// Fetch the users data from the database
$usersQuery = "SELECT id, username FROM users";
$usersResult = mysqli_query($conn, $usersQuery);
if ($usersResult) {
    while ($userRow = mysqli_fetch_assoc($usersResult)) {
        $response["users"][] = $userRow;
    }
}

// Fetch the locations data from the database
$locationsQuery = "SELECT id, location_name FROM locations";
$locationsResult = mysqli_query($conn, $locationsQuery);
if ($locationsResult) {
    while ($locationRow = mysqli_fetch_assoc($locationsResult)) {
        $response["locations"][] = $locationRow;
    }
}

// Close the database connection
mysqli_close($conn);

// Set the appropriate content type and echo the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>


