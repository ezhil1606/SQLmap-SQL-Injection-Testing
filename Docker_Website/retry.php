<?php
session_start();
$error = $_SESSION['error'] ?? 'Unknown error.';
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head><title>Login Failed</title></head>
<body>
<h2>Login Failed</h2>
<p><?php echo htmlspecialchars($error); ?></p>
<a href="index.php">Try again</a>
</body>
</html>
