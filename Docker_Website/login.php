<?php
session_start();

// Database connection
$host = "db";
$username = "testuser";
$password = "testpass";
$database = "testdb";

$mysqli = new mysqli($host, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Prepare and execute the query
$sql = "SELECT * FROM users WHERE username = ? AND password = MD5(?)";
$stmt = $mysqli->prepare($sql);

// Check if prepare() failed
if (!$stmt) {
    die("Prepare failed: " . $mysqli->error);
}

$stmt->bind_param("ss", $_POST['username'], $_POST['password']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $_SESSION['username'] = $_POST['username'];
    header('Location: welcome.php');
} else {
    $_SESSION['error'] = "Invalid username or password.";
    header('Location: retry.php');
}
$stmt->close();
$mysqli->close();
?>
