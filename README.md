# Loan App

### Steps to setup application

 - Clone Repository 
    ```
    git clone https://github.com/sjaswinder82/loan-app.git
    ``` 
 - Install dependencies
    ```
    composer install
    ```
 - Update env
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=xxx
    DB_USERNAME=xxx
    DB_PASSWORD=xxx
    ```
 - Run below command/s
    ```
    php artisan migrate
    ```
 - Run feature test with command
    ```
    vendor/bin/phpunit
    ```
