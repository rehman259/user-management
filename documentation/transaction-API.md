
# Transaction API Documentation

## Overview
This API provides a method to retrieve the total transactions for a given user, transaction date, and location ID. It calculates the total number of transactions based on the provided parameters.

##### Request
- Method: GET

**Request Parameters:**
- `user_id` (required): The ID of the user.
- `transaction_date` (required): The date of the transactions.
- `location_id` (required): The ID of the location.

**Request Example:**
- URL: `api/transaction-api.php??user_id=123&transaction_date=2023-05-01&location_id=456`


##### Response
- Status: 200 OK
- Body:
  ```json
    {
      "user_id": 123,
      "transaction_date": "2023-05-01",
      "location_id": 456,
      "total_transactions": 10
    }
  ```

- Error Response (Internal Server Error):
  - Status Code: 500 (Internal Server Error)
  - Body:
    ```json
    {
      "message": "Error: Database connection failed."
    }
    ```
- Error Response (Bad Request - Missing Parameters):
  - Status Code: 400 (Bad Request)
  - Body:
    ```json
    {
      "message": "Missing required parameters."
    }
    ```
