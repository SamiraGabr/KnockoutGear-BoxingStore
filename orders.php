<?php
session_start();
require_once 'config/db_connect.php';
require_once 'includes/orders.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Knockout Gear</title>
    <link rel="stylesheet" href="styles/order_style.css">
    <link rel="stylesheet" href="styles/home_style.css">
    <link rel="stylesheet" href="styles/nav_foot_style.css">
</head>
<body>
    <?php include 'templates/nav.php'; ?>

    <section class="orders">
        <h2>Your Orders</h2>
        <?php if (empty($orders)): ?>
            <p>No orders found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_number']); ?></td>
                            <td><?php echo $order['created_at']; ?></td>
                            <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <td><a href="orders.php?order_id=<?php echo $order['order_id']; ?>" class="btn">View Details</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <?php if (isset($order_details)): ?>
            <h3>Order Details: <?php echo htmlspecialchars($order_details['order_number']); ?></h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo htmlspecialchars($item['variation'] ?? 'None'); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>Shipping Address: <?php echo htmlspecialchars($order_details['shipping_address']); ?></p>
            <p>Payment Method: <?php echo htmlspecialchars($order_details['payment_method']); ?></p>
        <?php endif; ?>
    </section>

    <?php include 'templates/footer.php'; ?>
    <script src="scripts/products_script.js"></script>
    <script src="scripts/main.js"></script>
</body>
</html>