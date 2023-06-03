<?php

// Include the necessary files and establish the database connection
require_once '../database/db-connection.php';
require_once '../utils/user-functions.php';

// Set the response content type to JSON
header('Content-Type: application/json');

// Check if the required parameters are provided
if (isset($_GET['user_id'], $_GET['transaction_date'], $_GET['location_id'])) {
    $userId = filter_var($_GET['user_id'], FILTER_SANITIZE_NUMBER_INT);
    $transactionDate = filter_var($_GET['transaction_date'], FILTER_SANITIZE_STRING);
    $locationId = filter_var($_GET['location_id'], FILTER_SANITIZE_NUMBER_INT);

    // Call the function and get the result
    $result = getTotalTransactions($userId, $transactionDate, $locationId);

    // Check for errors or valid result
    if (strpos($result, "Error") !== false) {
        // Handle the error response
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => $result));
    } else {
        // Return the success response
        http_response_code(200); // OK

        // Set the response content type to JSON
        header('Content-Type: application/json');

        // Return the JSON response
        echo $result;
    }
} else {
    // Handle the missing parameter error
    http_response_code(400); // Bad Request
    echo json_encode(array("message" => "Missing required parameters."));
}

// Close the database connection
mysqli_close($conn);
