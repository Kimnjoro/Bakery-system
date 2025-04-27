<?php 
session_start();
include 'db.php';

// Handle cart logic
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];
    $_SESSION['cart'][$product_id] = ($_SESSION['cart'][$product_id] ?? 0) + 1;
    header('Location: cart.php');
    exit;
}

if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][(int)$_GET['remove']]);
    header('Location: cart.php');
    exit;
}

// Fetch cart items
$cart_products = [];
$total = 0;
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $query = "SELECT * FROM products WHERE id IN ($ids)";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $quantity = $_SESSION['cart'][$id];
        $subtotal = $row['price'] * $quantity;
        $total += $subtotal;

        $cart_products[] = [
            'id' => $id,
            'name' => $row['name'],
            'price' => $row['price'],
            'quantity' => $quantity,
            'subtotal' => $subtotal
        ];
    }
}

$is_logged_in = isset($_SESSION['user_id']);
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://images.rawpixel.com/image_800/cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDI0LTA2L2hpcHBvdW5pY29ybl9pbGx1c3RyYXRpb25fb2ZfbWluaW1hbF9zaW1wbGVfcGlua19kcmlwX21lbHRlZF9ib184NWRjY2IyYy1kZGZiLTRlZjAtYmE0OS0zYzQ4MGZmZjUwYjFfMS5qcGc.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #4e342e;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #ff6f61;
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header a, .header button {
            color: white;
            background-color: transparent;
            border: 2px solid white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s ease;
            font-weight: 500;
        }

        .header a:hover, .header button:hover {
            background-color: white;
            color: #ff6f61;
        }

        .cart-count {
            background-color: #ffd54f;
            padding: 5px 10px;
            border-radius: 50%;
            color: #4e342e;
            font-weight: bold;
            margin-left: 8px;
        }

        h1 {
            font-family: 'Pacifico', cursive;
            background-color: rgba(255, 223, 186, 0.9);
            color: #4e342e;
            padding: 25px;
            text-align: center;
            margin: 0;
            font-size: 2.8rem;
        }

        .cart-container {
            padding: 40px 15px;
        }

        .cart-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .btn-remove {
            color: #ff4d4d;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-remove:hover {
            text-decoration: underline;
        }

        .btn-checkout {
            background-color: #ff6f61;
            color: white;
            border: none;
        }

        .btn-checkout:hover {
            background-color: #e25a4f;
        }

        .total-text {
            font-weight: bold;
            font-size: 1.2rem;
            text-align: right;
        }

        .empty-message {
            text-align: center;
            font-size: 1.2rem;
            padding: 30px;
        }
    </style>
</head>
<body>

<!-- Updated Header -->
<div class="header">
    <div>
        <?php if ($is_logged_in): ?>
            <button onclick="window.location.href='logout.php';">Logout</button>
        <?php else: ?>
            <a href="login.php">Login</a> | <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
    <div>
        <a href="index.php" class="btn btn-outline-secondary">🏠 Home</a>
    </div>
</div>

<!-- Page Title -->
<h1>🛒 Your Cart</h1>

<!-- Cart Content -->
<div class="container cart-container">
    <div class="cart-box">
        <?php if (empty($cart_products)): ?>
            <p class="empty-message">Your cart is currently empty. Go ahead and <a href="index.php">add some treats!</a> 🧁</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-warning">
                        <tr>
                            <th>Item</th>
                            <th>Price (Ksh)</th>
                            <th>Quantity</th>
                            <th>Subtotal (Ksh)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_products as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo number_format($product['price'], 2); ?></td>
                                <td><?php echo $product['quantity']; ?></td>
                                <td><?php echo number_format($product['subtotal'], 2); ?></td>
                                <td><a href="cart.php?remove=<?php echo $product['id']; ?>" class="btn-remove">Remove</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <p class="total-text">Total: Ksh <?php echo number_format($total, 2); ?></p>
            <div class="d-flex justify-content-between mt-4">
                <a href="index.php" class="btn btn-outline-secondary">← Continue Shopping</a>
                <a href="checkout.php" class="btn btn-checkout">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
