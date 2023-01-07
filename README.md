ToDo App
=
This code challenge assesses your skills in developing a simple API for a to-do list application. For this code challenge, you must use laravel and expose the API endpoints.

Please note that the code should be clean, commented and well-structured. We will test the endpoints using postman so you provide us with a postman collection with all the endpoints.

Creating the exact models needed for the application to work properly is completely up to you. You can opt to use `MySQL`, `MariaDB`, or `PostgreSQL` as your database.

### INSTALLATION

PHP 8.* is required and laravel 9

* `compmoser install`

* `php artisan migrate --seed`

* [Postman Collection Link](https://github.com/mudassaralichouhan/todo/releases/download/0.1/ToDo.postman_collection.json)

### We Completed Task

#### Register :
* Require email, password, and password confirmation as post body
* The route should create a user that is not verified in the database
* Route should send a verification email to the user's email.
* Return appropriate response

#### Verification :
* Create logic for verifying the user from the verification code sent to the user’s email address

#### Login :
* Require email and password as the post body.
* Authenticate the user through provided credentials.
* If the user is verified and the email/password is correct, respond with a JWT token, otherwise show the appropriate response

#### Logout :
* Invalidate the user's JWT token

#### ToDo List :
* Only accessible for authenticated users
* Users can view only their to-do items in the list.
* Send out a paginated list of ToDos (up to 10 items per page, preferably use Laravel's built-in pagination)
* Implement logic to search items in the list by name.

#### Create ToDo :
* Only accessible for authenticated users
2 fields are required: title and description of the ToDo item
* On success save the item to the database
* Return appropriate response

#### View ToDo :
* Only accessible for authenticated users
* Respond with an object containing the title and description of the requested ToDo


#### Update ToDo :
* Only accessible for authenticated users
* 2 fields are required: title and description of the ToDo item
* On success save an updated item to the database
* Return appropriate response

#### Delete ToDo :
* Only accessible for authenticated users.
* On success delete the item from the database.
* Return appropriate response.
