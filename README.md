 # API REST in PHP Laravel
 Small app to implement API Rest in php laravel

# Requirements
- PHP 7.4
    - Install modules
        - mysqli
        - pdo_mysql
- MariaDB ver. 10
- Composer ver. 2

# To remember
All **php** and **composer** commands must be executed from a terminal (bash,zsh, powershell, cmd) and we should be in project's directory or we will get errors when we will try to run the application.


 # Set up
After accomplishing all requirements, clone repository.

Inside repository's folder:
- Execute command (and wait until dependencies are installed)
    ```
        composer install
    ```
    
- Change or copy .env.example to .env
    - Change db configuration, use credentials(host, port, username, password) of your database, in the .env file
        ```
            DB_CONNECTION=mysql
            DB_HOST=127.0.0.1
            DB_PORT=3306
            DB_DATABASE=api_assignment
            DB_USERNAME=root
            DB_PASSWORD=
        ```
    - Create a new database in your database
        ```
            CREATE DATABASE `api_assignment` /*!40100 DEFAULT CHARACTER SET utf8mb4 */
        ```
- After creating database, execute migrations and seeder with the next command(inside folder's project):
```
    php artisan migrate --seed
```


# Laravel Job execution
There is Laravel Job to fetch information of an external API every minute, to call it in development environment:
```
    php artisan schedule:work
```
It will keep running until external command (ex, ctrl + c)

Other way to call it is through:
```
    php artisan schedule:run
```
It will call it once, it is used on production environment and with help of a cron.

This job will populate users table in db.

# Starting server locally
To start sending request to API we need to start a server, we can do that through:
```
    php artisan serve
```
It will start a server on port 8000 in our local machine

# API documentation
After starting Laravel server, it will be possible to see API documentation on next URL:
```
    http://localhost:8000/api/documentation
```
In it we will find API's documentation

If any change is made, API would re generate documentation due to L5_SWAGGER_GENERATE_ALWAYS variable
but if for any reason that doesn't happen, we can re generate documentation through:
```
    php artisan l5-swagger:generate
```

# User a password for request
There is a endpoint that needs authentication (to see information of a user by its id)
Credentials are:
```
    username = e9a39381-9bb0-37c1-aba5-117a13fd5d68
    password = password
```
These credentials should be send to the API in request's headers as **basic auth**

# Run test
To run API tests:
```
    php artisan test
```
After it finish it will show a resume of test in console
