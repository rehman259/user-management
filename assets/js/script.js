// Function to create a new user
function createUser(username, email, password) {
    var requestData = {
        username: username,
        email: email,
        password: password
    };

    $.ajax({
        url: 'api/user-api.php',
        type: 'POST',
        dataType: 'json',
        data: JSON.stringify(requestData),
        contentType: 'application/json',
        success: function (response) {
            // Clear the form inputs
            $('#username').val('');
            $('#email').val('');
            $('#password').val('');

            // Refresh the user list
            loadUserList();
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

// Function to retrieve the user list
function loadUserList() {
    $.ajax({
        url: 'api/user-api.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            // Clear the table body
            $('#userTable tbody').empty();

            // Populate the table with user data
            response.forEach(function (user) {
                var row = '<tr>';
                row += '<td>' + user.id + '</td>';
                row += '<td>' + user.username + '</td>';
                row += '<td>' + user.email + '</td>';
                row += '<td>';
                row += '<input type="button" value="Edit" onclick="editUser(' + user.id + ')">';
                row += '<input type="button" value="Delete" onclick="deleteUser(' + user.id + ')">';
                row += '</td>';
                row += '</tr>';

                $('#userTable tbody').append(row);
            });
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

// Function to delete a user
function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        $.ajax({
            url: 'api/user-api.php?id=' + userId,
            type: 'DELETE',
            dataType: 'json',
            success: function (response) {
                // Refresh the user list
                loadUserList();
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
}

// Function to edit a user
function editUser(userId) {
    // Fetch the user data
    $.ajax({
        url: 'api/user-api.php?id=' + userId,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            // Populate the form with the user data
            $('#username').val(response.username);
            $('#email').val(response.email);
            $('#password').val('');

            // Create a hidden field to store the user ID
            var userIdField = '<input type="hidden" id="userId" value="' + userId + '">';
            $('#userForm').append(userIdField);

            // Change the submit button value to "Update User"
            $('input[type="submit"]').val('Update User');
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

// Event handler for the user form submission
$('#userForm').on('submit', function (event) {
    event.preventDefault();

    var username = $('#username').val();
    var email = $('#email').val();
    var password = $('#password').val();

    // Check if a hidden field for user ID exists
    if ($('#userId').length > 0) {
        // Update user
        var userId = $('#userId').val();
        updateUser(userId, username, email);
    } else {
        // Create user
        createUser(username, email, password);
    }
});

// Function to update a user
function updateUser(userId, username, email) {
    var requestData = {
        username: username,
        email: email
    };

    $.ajax({
        url: 'api/user-api.php?id=' + userId,
        type: 'PUT',
        dataType: 'json',
        data: JSON.stringify(requestData),
        contentType: 'application/json',
        success: function (response) {
            // Clear the form inputs
            $('#username').val('');
            $('#email').val('');
            $('#password').val('');

            // Remove the hidden user ID field
            $('#userId').remove();

            // Change the submit button value back to "Create User"
            $('input[type="submit"]').val('Create User');

            // Refresh the user list
            loadUserList();
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

$(document).ready(function() {
    $('#transactionForm').submit(function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        var user = $('#user').val();
        var location = $('#location').val();
        var date = $('#date').val();

        // Make AJAX call to the transaction API
        $.ajax({
            url: 'api/transaction-api.php',
            type: 'GET',
            data: {
                user_id: user,
                transaction_date: date,
                location_id: location
            },
            dataType: 'json',
            success: function(response) {
                // Display the result
                $('#resultContainer').html('Total Transactions: ' + response.total_transactions);
            },
            error: function(xhr, status, error) {
                // Display the error message
                var errorMessage = xhr.responseJSON.message;
                $('#resultContainer').html('Error: ' + errorMessage);
            }
        });
    });
});

 // Function to populate the Users select menu
 function populateUsers() {
    $.ajax({
        url: 'api/users-locations-api.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var usersSelect = $('#user');
            usersSelect.empty();
            var result = response.users;

            result.forEach(function(user) {
                usersSelect.append('<option value="' + user.id + '">' + user.username + '</option>');
            });
        },
        error: function(xhr, status, error) {
        }
    });
}

// Function to populate the Locations select menu
function populateLocations() {
    $.ajax({
        url: 'api/users-locations-api.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var locationsSelect = $('#location');
            locationsSelect.empty();
            var response = response.locations;

            response.forEach(function(location) {
                locationsSelect.append('<option value="' + location.id + '">' + location.location_name + '</option>');
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}