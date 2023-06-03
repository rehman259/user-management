Project: User Management
========================

The User Management project is a RESTful API-based application built using Core PHP version 8, MySQL, and jQuery for the frontend. This project aims to provide a user management system with features for user creation, retrieval, update, deletion, and transaction queries.

Setup Instructions
------------------

1. Clone the repository to your local machine.

2. Create a new database and configure the database connection in the `database/db-connection.php` file.

3. Import the SQL schema from the `database/migrations/schema.sql` file into your database.

4. Run the following scripts located in the `database/data` directory:
   - `user-data.php`: Generates sample user data for testing purposes.
   - `location-data.php`: Generates sample location data for user transactions.
   - `transaction-data.php`: Generates more than 100,000 sample transaction records.

5. Start a web server and open `index.html` to access the User Management screen.

API Documentation
-----------------

The API documentation for this project is located in the `documentation/` folder. It consists of separate documentation files for the User API and Transaction API.

User API
--------
The User API allows you to manage user data using RESTful APIs. It provides the following endpoints:

- `GET /user-api.php`: Retrieves a list of all users.
- `GET /user-api.php?id={user_id}`: Retrieves details of a specific user.
- `POST /user-api.php`: Creates a new user.
- `PUT /user-api.php?id={user_id}`: Updates an existing user.
- `DELETE /user-api.php?id={user_id}`: Deletes a user.

Transaction API
---------------
The Transaction API allows you to query user-related data for total transactions based on date and location. It provides the following endpoint:

- `GET /transaction-api.php?user_id={user_id}&transaction_date={date}&location_id={location_id}`: Retrieves the total transactions for a user on a specific date and at a given location.

API Usage Guidelines
--------------------

- Ensure that you have set up the database connection correctly before using the APIs.
- Send HTTP requests to the appropriate endpoints mentioned above.
- Include any required parameters in the request URL or request body, as specified.
- Use proper HTTP methods (GET, POST, PUT, DELETE) for the desired action.
- Handle the API responses according to the HTTP status codes returned.
- Refer to the API documentation for detailed information on each endpoint, request formats, and response formats.


































