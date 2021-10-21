<?php
require_once __DIR__."/../config/database.php";

try {
    $statement = $db->prepare("INSERT INTO users (username, email, password, role) VALUES(:username, :email, :password, :role)");
    $statement->execute([
        "username" => "Admin1",
        "email" => "admin1@gmail.com",
        "password" => password_hash('catsanddogs', PASSWORD_DEFAULT),
        "role" => "super-admin"
    ]);
    $statement->execute([
        "username" => "John Doe",
        "email" => "john@gmail.com",
        "password" => password_hash('doejohn', PASSWORD_DEFAULT),
        "role" => "admin"
    ]);
    $statement->execute([
        "username" => "admin2",
        "email" => "admin2@gmail.com",
        "password" => password_hash('admin123', PASSWORD_DEFAULT),
        "role" => "editor"
    ]);
    echo "Created users\n";
} catch(\Exception $err) {
    print_r($err);
}

