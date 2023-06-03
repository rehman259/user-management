<?php

// Include the necessary files and establish the database connection
require_once '../database/db-connection.php';
require_once '../utils/user-functions.php';

// Set the response content type to JSON
header('Content-Type: application/json');

// Check the HTTP request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle the API request based on the method
switch ($method) {
    case 'GET':
        // Handle GET request to retrieve user data
        handleGetRequest();
        break;
    case 'POST':
        // Handle POST request to create a new user
        handlePostRequest();
        break;
    case 'PUT':
        // Handle PUT request to update a user
        handlePutRequest();
        break;
    case 'DELETE':
        // Handle DELETE request to delete a user
        handleDeleteRequest();
        break;
    default:
        // Invalid method
        http_response_code(405); // Method Not Allowed
        echo json_encode(array('error' => 'Invalid method'));
        break;
}

// Handle GET request to retrieve user data
function handleGetRequest()
{
    // Check if a specific user ID is provided in the request URL
    if (isset($_GET['id'])) {
        $userId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        // Call the getUserById() function from the user-functions.php file
        $user = getUserById($userId);

        if ($user) {
            // User found
            http_response_code(200); // OK
            echo json_encode($user);
        } else {
            // User not found
            http_response_code(404); // Not Found
            echo json_encode(array('error' => 'User not found'));
        }
    } else {
        // Retrieve all users
        // Call the getAllUsers() function from the user-functions.php file
        $users = getAllUsers();

        // Return the users as JSON
        http_response_code(200); // OK
        echo json_encode($users);
    }
}

// Handle POST request to create a new user
function handlePostRequest()
{
    // Retrieve the request payload
    $requestData = json_decode(file_get_contents('php://input'), true);

    // Extract the user data from the request payload and sanitize
    $username = filter_var($requestData['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($requestData['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($requestData['password'], FILTER_SANITIZE_STRING);

    // Call the createUser() function from the user-functions.php file
    $userId = createUser($username, $email, $password);

    // Return the ID of the newly created user as JSON
    http_response_code(201); // Created
    echo json_encode(array('id' => $userId));
}

// Handle PUT request to update a user
function handlePutRequest()
{
    // Check if a specific user ID is provided in the request URL
    if (isset($_GET['id'])) {
        $userId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        // Retrieve the request payload
        $requestData = json_decode(file_get_contents('php://input'), true);

        // Extract the user data from the request payload and sanitize
        $username = filter_var($requestData['username'], FILTER_SANITIZE_STRING);
        $email = filter_var($requestData['email'], FILTER_SANITIZE_EMAIL);

        // Call the updateUser() function from the user-functions.php file
        $affectedRows = updateUser($userId, $username, $email);

        if ($affectedRows > 0) {
            // User updated successfully
            http_response_code(200); // OK
            echo json_encode(array('message' => 'User updated successfully'));
        } else {
            // User not found
            http_response_code(404); // Not Found
            echo json_encode(array('error' => 'User not found'));
        }
    } else {
        // User ID not provided
        http_response_code(400); // Bad Request
        echo json_encode(array('error' => 'User ID not provided'));
    }
}

// Handle DELETE request to delete a user
function handleDeleteRequest()
{
    // Check if a specific user ID is provided in the request URL
    if (isset($_GET['id'])) {
        $userId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        // Call the deleteUser() function from the user-functions.php file
        $affectedRows = deleteUser($userId);

        if ($affectedRows > 0) {
            // User deleted successfully
            http_response_code(200); // OK
            echo json_encode(array('message' => 'User deleted successfully'));
        } else {
            // User not found
            http_response_code(404); // Not Found
            echo json_encode(array('error' => 'User not found'));
        }
    } else {
        // User ID not provided
        http_response_code(400); // Bad Request
        echo json_encode(array('error' => 'User ID not provided'));
    }
}
