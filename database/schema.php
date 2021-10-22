<?php
require_once __DIR__."/../config/database.php";

$create_post_table_schema = <<<POST_TABLE
CREATE TABLE IF NOT EXISTS posts (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    title VARCHAR(40) NOT NULL,
    img VARCHAR(40) NULL,
    categories VARCHAR(40) NULL,
    content LONGTEXT NULL,
    date_time DATETIME
)
POST_TABLE;

$users_table_schema = <<<USER_TABLE
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(40) DEFAULT 'editor'
)
USER_TABLE;

try {
    $db->query($create_post_table_schema);
    echo "Created posts table\n";
    $db->query($users_table_schema);
    echo "Created users table\n";
} catch (\Throwable $th) {
    print_r("Tables not created");
}
