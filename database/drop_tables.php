<?php
require_once __DIR__."/../config/database.php";

$drop_post_table = <<<POST_TABLE
DROP TABLE posts
POST_TABLE;

$drop_users_table = "";

try {
    $db->query($drop_post_table);
    echo "All tables dropped\n";
} catch (\Throwable $th) {
    print_r("Tables not dropped");
}
