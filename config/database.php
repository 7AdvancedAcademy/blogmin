<?php

require __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$db_name = $_ENV['DB_NAME'];
$db_username = $_ENV['DB_USERNAME'];
$db_password = $_ENV['DB_PASSWORD'];

try {
    $db = new PDO("mysql:host=localhost;dbname=$db_name", $db_username, $db_password);
} catch (\Exception $err) {
    die("Could not connnect due to $err");
}
