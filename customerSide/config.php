<?php
$host = getenv("DB_HOST") ?: "db";
$user = getenv("DB_USER") ?: "root";
$pass = getenv("DB_PASSWORD") ?: "root";
$db   = getenv("DB_NAME") ?: "restaurantdb";

$link = new mysqli($host, $user, $pass, $db);

if ($link->connect_error) {
    die("Connection Failed: " . $link->connect_error);
}
?>
