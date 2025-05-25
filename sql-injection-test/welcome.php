<?php
if (isset($_GET['user'])) {
    $user = htmlspecialchars($_GET['user']);
} else {
    $user = "Guest";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome, <?php echo $user; ?>!</h2>
    <p>You have successfully logged in.</p>
    <a href="index.php">Logout</a>
</body>
</html>
