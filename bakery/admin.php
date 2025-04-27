<?php
include 'db.php';

// Add product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $price = (float)$_POST['price'];
    $image = $conn->real_escape_string($_POST['image']);

    $conn->query("INSERT INTO products (name, price, image) VALUES ('$name', $price, '$image')");
    header("Location: admin.php");
    exit;
}

// Delete product
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM products WHERE id = $id");
    header("Location: admin.php");
    exit;
}

// Fetch all products
$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fdf5e6;
            margin: 0;
        }
        h1 {
            background: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            width: 85%;
            margin: 30px auto;
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        input, button {
            padding: 8px;
            margin: 5px;
            border: 1px solid #aaa;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
        }
        table {
            margin-top: 25px;
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        a.delete-btn {
            background-color: #e74c3c;
            padding: 5px 10px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a.delete-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <h1>🛠️ Admin Panel – Manage Products</h1>
    <div class="container">
        <h3>Add New Product</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="number" name="price" step="0.01" placeholder="Price" required>
            <input type="text" name="image" placeholder="Image URL" required>
            <button type="submit">Add Product</button>
        </form>

        <h3>Current Products</h3>
        <table>
            <tr>
                <th>ID</th><th>Name</th><th>Price</th><th>Image</th><th>Action</th>
            </tr>
            <?php while($row = $products->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td>Ksh <?= number_format($row['price'], 2); ?></td>
                <td><img src="<?= $row['image']; ?>" width="60"></td>
                <td><a href="?delete=<?= $row['id']; ?>" class="delete-btn">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
