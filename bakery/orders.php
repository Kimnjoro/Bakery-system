<?php
include 'db.php';

$result = $conn->query("
    SELECT o.id, o.total, o.created_at, p.name, oi.quantity, oi.subtotal
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    ORDER BY o.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff8f0;
        }
        h1 {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .orders {
            width: 90%;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <h1>🧾 All Orders</h1>
    <div class="orders">
        <table>
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Subtotal (Ksh)</th>
                <th>Total (Ksh)</th>
                <th>Date</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo number_format($row['subtotal'], 2); ?></td>
                <td><?php echo number_format($row['total'], 2); ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
