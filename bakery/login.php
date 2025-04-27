<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit;
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url("assets/bunch-bread-loafs-table.jpg") no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: #4e342e;
        }
        .form-container {
            width: 340px;
            margin: 80px auto;
            background: rgba(255, 248, 240, 0.96);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #6d4c41;
            font-weight: 600;
        }
        .form-container input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #bcae9c;
            border-radius: 8px;
            font-size: 14px;
        }
        .form-container .error {
            color: #d32f2f;
            font-size: 14px;
            text-align: center;
        }
        .form-container button {
            width: 100%;
            padding: 12px;
            background: #6d4c41;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            transition: background 0.3s ease;
        }
        .form-container button:hover {
            background: #5d4037;
        }
        .form-container p {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }
        .form-container a {
            color: #6d4c41;
            font-weight: 500;
            text-decoration: none;
        }
        .form-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Login</h2>

    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>

</body>
</html>
