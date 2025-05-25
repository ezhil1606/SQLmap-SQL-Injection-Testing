<?php
// Database connection parameters
$host = "db";               // service name from docker-compose
$username = "testuser";     // must match MYSQL_USER in docker-compose
$password = "testpass";     // must match MYSQL_PASSWORD in docker-compose
$database = "testdb";

// Create a new mysqli connection
$mysqli = new mysqli($host, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
