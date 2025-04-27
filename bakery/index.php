<?php   
session_start();
include 'db.php';

// Get products from the database
$result = $conn->query("SELECT * FROM products");

// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);

// Cart count
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery Home</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://images.rawpixel.com/image_800/cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDI0LTA2L2hpcHBvdW5pY29ybl9pbGx1c3RyYXRpb25fb2ZfbWluaW1hbF9zaW1wbGVfcGlua19kcmlwX21lbHRlZF9ib184NWRjY2IyYy1kZGZiLTRlZjAtYmE0OS0zYzQ4MGZmZjUwYjFfMS5qcGc.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: #4e342e;
        }
        .header {
            font-family: 'Poppins', sans-serif;
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
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .header button:hover, .header a:hover {
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
        .product {
            background: rgba(255, 255, 255, 0.95);
            margin: 15px auto;
            padding: 25px 20px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        .product:hover {
            transform: translateY(-5px);
        }
        .product h3 {
            margin-top: 15px;
            font-weight: 600;
        }
        .product p {
            font-weight: 500;
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color: #ff6f61;
            border: none;
        }
        .btn-primary:hover {
            background-color: #e25a4f;
        }
        .container {
            padding-top: 30px;
            padding-bottom: 50px;
        }
        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div>
            <?php if ($is_logged_in): ?>
                <button onclick="window.location.href='logout.php';">Logout</button>
            <?php else: ?>
                <a href="login.php">Login</a> | <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
        <?php if ($is_logged_in): ?>
            <div>
                <a href="cart.php">Cart <span class="cart-count"><?php echo $cart_count; ?></span></a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Welcome Heading -->
    <h1>🍰 Welcome to Sweet Bites Bakery</h1>

    <!-- Product Grid -->
    <div class="container">
    <div class="row justify-content-center">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                <div class="product w-100 text-center">
                    <!-- Resized Bootstrap placeholder image -->
                    <img src="assets/cake_14810050.png?text=<?php echo urlencode($row['name']); ?>" class="img-fluid mb-2" alt="Product Image" style="width: 120px; height: auto;">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p>Ksh <?php echo number_format($row['price'], 2); ?></p>
                    <form method="post" action="cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
