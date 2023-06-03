<?php

/**
 * Creates a new user in the database.
 *
 * @param string $username The username of the user.
 * @param string $email The email address of the user.
 * @param string $password The password of the user.
 *
 * @return int The ID of the newly created user.
 */
function createUser($username, $email, $password)
{
    global $conn;

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Perform the database query to insert a new user
    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);
    $stmt->execute();

    // Return the ID of the newly created user
    return $stmt->insert_id;
}

/**
 * Retrieves a user from the database by their ID.
 *
 * @param int $userId The ID of the user.
 *
 * @return array|null The user data as an associative array, or null if the user is not found.
 */
function getUserById($userId)
{
    global $conn;

    // Perform the database query to fetch a user by their ID
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Fetch the user data as an associative array
    $user = $result->fetch_assoc();

    return $user;
}

/**
 * Updates a user in the database.
 *
 * @param int $userId The ID of the user.
 * @param string $username The new username.
 * @param string $email The new email address.
 *
 * @return int The number of affected rows (1 if successful, 0 if not).
 */
function updateUser($userId, $username, $email)
{
    global $conn;

    // Perform the database query to update the user data
    $query = "UPDATE users SET username = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $username, $email, $userId);
    $stmt->execute();

    // Return the number of affected rows (1 if successful, 0 if not)
    return $stmt->affected_rows;
}

/**
 * Deletes a user from the database.
 *
 * @param int $userId The ID of the user to delete.
 *
 * @return int The number of affected rows (1 if successful, 0 if not).
 */
function deleteUser($userId)
{
    global $conn;

    // Perform the database query to delete the user
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    // Return the number of affected rows (1 if successful, 0 if not)
    return $stmt->affected_rows;
}

/**
 * Retrieves all users from the database.
 *
 * @return array An array of user data, each item containing the user's ID, username, and email.
 */
function getAllUsers()
{
    global $conn;

    $query = "SELECT id, username, email FROM users";
    $result = mysqli_query($conn, $query);

    $users = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    return $users;
}

/**
 * Retrieves the total number of transactions for a given user, date, and location.
 *
 * @param int $userId The ID of the user.
 * @param string $transactionDate The date of the transactions.
 * @param int $locationId The ID of the location.
 *
 * @return string|int If successful, a JSON-encoded string with the response data, otherwise an error message.
 */
function getTotalTransactions($userId, $transactionDate, $locationId)
{
    global $conn;

    // Prepare the SQL statement
    $query = "SELECT COUNT(*) AS total_transactions
              FROM transactions
              WHERE user_id = ? AND transaction_date = ? AND location_id = ?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        return "Error: " . mysqli_error($conn);
    }

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "iss", $userId, $transactionDate, $locationId);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Fetch the result
        mysqli_stmt_bind_result($stmt, $totalTransactions);
        mysqli_stmt_fetch($stmt);

        // Close the statement
        mysqli_stmt_close($stmt);

        // Prepare the response data
        $response = array(
            "user_id" => $userId,
            "transaction_date" => $transactionDate,
            "location_id" => $locationId,
            "total_transactions" => $totalTransactions
        );

        // Return the response data as a JSON-encoded string
        return json_encode($response);
    } else {
        // Handle the error
        return "Error: " . mysqli_error($conn);
    }
}
