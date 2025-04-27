<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username or email already exists!";
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $insert = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $username, $email, $hash);

            if ($insert->execute()) {
                header('Location: login.php');
                exit;
            } else {
                $error = "Database error: " . $conn->error;
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0; padding: 0;
    }
    body {
      font-family: 'Poppins', sans-serif;
      background: url("assets/bunch-bread-loafs-table.jpg") no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #4e342e;
    }
    .form-container {
      background: rgba(255, 248, 240, 0.96);
      padding: 35px 30px;
      border-radius: 15px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.15);
      width: 360px;
      max-width: 90%;
      text-align: center;
    }
    .form-container h2 {
      margin-bottom: 20px;
      color: #6d4c41;
      font-weight: 600;
    }
    .form-container .error {
      margin-bottom: 15px;
      color: #d32f2f;
      font-size: 14px;
    }
    .form-container input {
      width: 100%;
      padding: 12px 15px;
      margin: 10px 0;
      border: 1px solid #bcae9c;
      border-radius: 8px;
      font-size: 15px;
      background: #fff;
      transition: border-color 0.3s;
    }
    .form-container input:focus {
      outline: none;
      border-color: #8d6e63;
    }
    .form-container button {
      width: 100%;
      padding: 12px;
      margin-top: 15px;
      background: #6d4c41;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    .form-container button:hover {
      background: #5d4037;
    }
    .form-container p {
      margin-top: 15px;
      font-size: 14px;
      color: #6d4c41;
    }
    .form-container a {
      color: #6d4c41;
      font-weight: 500;
      text-decoration: none;
    }
    .form-container a:hover {
      text-decoration: underline;
    }
    @media (max-width: 400px) {
      .form-container {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>Create Your Account</h2>

    <?php if (!empty($error)): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" novalidate>
      <input type="text" name="username" placeholder="Username" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Log in here</a></p>
  </div>

</body>
</html>
