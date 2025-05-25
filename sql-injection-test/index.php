<?php
$host = 'localhost';
$dbname = 'sql_injection_demo';
$username = 'admin';  // New username
$password = 'admin_password';  // New password


try {
    // Connect to MySQL database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        // Vulnerable SQL query
        $sql = "SELECT * FROM username WHERE username = '$user' AND password = '$pass'";

        $result = $pdo->query($sql);
        if ($result->rowCount() > 0) {
            // Login successful, redirect to welcome page
            header("Location: welcome.php?user=" . urlencode($user));
            exit();
        } else {
            // Login failed, redirect to failed login page
            header("Location: failed.php");
            exit();
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SQL Injection</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
