<?php
session_start();
include 'db.php';

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit;
}

// ... (your order‐insertion logic here) ...

// Clear cart
unset($_SESSION['cart']);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Checkout Successful</title>
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f8f8f8;
    }
    .message {
      text-align: center;
      background: #fff;
      padding: 40px 60px;
      border-radius: 8px;
      box-shadow: 0 0 12px rgba(0,0,0,0.1);
    }
    .message h1 {
      color: #4CAF50;
      margin-bottom: 10px;
    }
    .message p {
      color: #555;
      margin-bottom: 20px;
    }
    .message a {
      display: inline-block;
      text-decoration: none;
      background: #ff704d;
      color: #fff;
      padding: 10px 20px;
      border-radius: 5px;
    }
    .message a:hover {
      background: #e6603a;
    }
  </style>
</head>
<body>
  <div class="message">
    <h1>Checkout Successful</h1>
    <p>Thank you for your order!</p>
    <a href="index.php">Continue Shopping</a>
  </div>
</body>
</html>
