<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['username'])) {
    header('Location: welcome.php');
    exit();
}

// Check for error message from retry page or login failure
$error = '';
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login Page</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container {
            width: 300px; margin: 100px auto; padding: 20px;
            background: white; border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type=text], input[type=password] {
            width: 100%; padding: 10px; margin: 5px 0 15px;
            border: 1px solid #ccc; border-radius: 3px;
        }
        input[type=submit] {
            width: 100%; padding: 10px; background: #28a745; color: white;
            border: none; border-radius: 3px; cursor: pointer;
            font-weight: bold;
        }
        .error {
            color: red; margin-bottom: 15px; font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Login</h2>

    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label for="username">Username</label><br />
        <input type="text" id="username" name="username" required /><br />

        <label for="password">Password</label><br />
        <input type="password" id="password" name="password" required /><br />

        <input type="submit" value="Login" />
    </form>
</div>
</body>
</html>
