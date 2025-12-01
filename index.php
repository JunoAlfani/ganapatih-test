<?php
// Check if setup has already been completed
if (file_exists('setup_completed.flag')) {
    echo "Setup has already been completed. The SQL setup won't run again.";
} else {
    // Use environment variables (recommended for Docker)
    $db_host = getenv('DB_HOST') ?: 'db';
    $db_user = getenv('DB_USER') ?: 'root';
    $db_pass = getenv('DB_PASSWORD') ?: 'root';

    // Create Connection
    $link = new mysqli($db_host, $db_user, $db_pass);

    // Check Connection
    if ($link->connect_error) {
        die('Connection Failed: ' . $link->connect_error);
    }

    // Create the 'restaurantdb' database if it doesn't exist
    $sqlCreateDB = "CREATE DATABASE IF NOT EXISTS restaurantdb";
    if ($link->query($sqlCreateDB) === TRUE) {
        echo "Database 'restaurantdb' created successfully.<br>";
    } else {
        echo "Error creating database: " . $link->error . "<br>";
    }

    // Switch to using the 'restaurantdb' database
    $link->select_db('restaurantdb');

    // Execute SQL statements from "restaurantdb.txt"
    function executeSQLFromFile($filename, $link) {
        $sql = file_get_contents($filename);

        if ($link->multi_query($sql) === TRUE) {
            echo "SQL statements executed successfully.";
            file_put_contents('setup_completed.flag', 'Setup completed successfully.');
        } else {
            echo "Error executing SQL statements: " . $link->error;
        }
    }

    executeSQLFromFile('restaurantdb.txt', $link);

    $link->close();
}
?>

<a href="customerSide/home/home.php">Home</a>
