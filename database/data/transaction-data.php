<?php
// Include the file to establish the database connection
require_once '../../database/db-connection.php';

// Get users
$usersQuery = "SELECT * FROM users";
$usersResult = mysqli_query($conn, $usersQuery);
$users = mysqli_fetch_all($usersResult, MYSQLI_ASSOC);

// Get locations
$locationsQuery = "SELECT * FROM locations";
$locationsResult = mysqli_query($conn, $locationsQuery);
$locations = mysqli_fetch_all($locationsResult, MYSQLI_ASSOC);

// Generate sample transactions
$transactionsPerUser = 10000; // Number of transactions to generate for each user and location
$batchSize = 1000; // Number of transactions to insert in each batch

// Prepare the insert statement
$insertTransaction = "INSERT INTO transactions (user_id, transaction_date, location_id, amount)
                      VALUES (?, ?, ?, ?)";

// Prepare the statement
$stmt = mysqli_prepare($conn, $insertTransaction);

// Bind parameters
mysqli_stmt_bind_param($stmt, 'isid', $userId, $transactionDate, $locationId, $amount);

// Insert sample transactions for each user and location in batches
foreach ($users as $user) {
    foreach ($locations as $location) {
        $batchCount = ceil($transactionsPerUser / $batchSize);

        for ($batch = 0; $batch < $batchCount; $batch++) {
            // Start and end index of the current batch
            $startIndex = $batch * $batchSize;
            $endIndex = min(($batch + 1) * $batchSize, $transactionsPerUser);

            // Begin the transaction
            mysqli_begin_transaction($conn);

            try {
                // Insert transactions in the current batch
                for ($i = $startIndex; $i < $endIndex; $i++) {
                    $userId = $user['id'];
                    $transactionDate = date('Y-m-d', strtotime("-$i days"));
                    $locationId = $location['id'];
                    $amount = mt_rand(10, 1000);

                    // Execute the prepared statement
                    mysqli_stmt_execute($stmt);
                }

                // Commit the transaction
                mysqli_commit($conn);
            } catch (Exception $e) {
                // Rollback the transaction in case of an error
                mysqli_rollback($conn);
                throw $e;
            }
        }
    }
}

// Close the statement
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($conn);

echo 'Sample transactions data has been inserted successfully!';

?>
