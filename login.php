<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded credentials
    if ($username === 'hkministry' && $password === 'Jesusteama') {
        $_SESSION['loggedin'] = true;
        header('Location: admin.php');
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
    <!-- Disable right-click -->
    <script>
        document.addEventListener('contextmenu', function (event) {
            event.preventDefault();
        });
    </script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Dashboard</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #33334d, #555575);
            font-family: Arial, sans-serif;
            color: #fff;
        }

        .login-box {
            background: #252849;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            width: 300px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 4px;
            border: 1px solid #444;
            background-color: #333;
            color: #fff;
        }

        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #25D366;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            color: #fff;
        }

        input[type="submit"]:hover {
            background-color: #20b357;
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Admin Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
    <?php if (!empty($error)) { echo '<div class="error">' . htmlspecialchars($error) . '</div>'; } ?>
</div>

</body>
</html>
