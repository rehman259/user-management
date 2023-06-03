
## User API Documentation

### User API Overview
The API allows you to perform CRUD operations (Create, Read, Update, Delete) on user data in a database. You can create new users, retrieve user data, update existing users, and delete users.


### Retrieves all users.

##### Request
- Method: GET
- URL: `/api/user-api.php`
- Headers:
  - Content-Type: application/json

##### Response
- Status: 200 OK
- Body:
  ```json
  [
    {
      "id": 1,
      "username": "john_doe",
      "email": "john.doe@example.com"
    },
    {
      "id": 2,
      "username": "jane_smith",
      "email": "jane.smith@example.com"
    },
    ...
  ]
  ```


### Retrieves a specific user by ID.

##### Request
- Method: GET
- URL: `/api/user-api.php/{id}`
  - Replace `{id}` with the ID of the user.
- Headers:
  - Content-Type: application/json

##### Response
- Status: 200 OK
- Body:
  ```json
  {
    "id": 1,
    "username": "john_doe",
    "email": "john.doe@example.com"
  }
  ```

### Creates a new user.

##### Request
- Method: POST
- URL: `/api/user-api.php`
- Headers:
  - Content-Type: application/json
- Body:
  ```json
  {
    "username": "new_user",
    "email": "new.user@example.com",
    "password": "password123"
  }
  ```

##### Response
- Status: 201 Created
- Body:
  ```json
  {
    "id": 3
  }
  ```


### Updates an existing user.

##### Request
- Method: PUT
- URL: `/api/user-api.php/{id}`
  - Replace `{id}` with the ID of the user.
- Headers:
  - Content-Type: application/json
- Body:
  ```json
  {
    "username": "updated_user",
    "email": "updated.user@example.com"
  }
  ```

##### Response
- Status: 200 OK
- Body:
  ```json
  {
    "message": "User updated successfully"
  }
  ```


### Deletes a user.

##### Request
- Method: DELETE
- URL: `/api/user-api.php/{id}`
  - Replace `{id}` with the ID of the user.

##### Response
- Status: 200 OK
- Body:
  ```json
  {
    "message": "User deleted successfully"
  }
  ```
