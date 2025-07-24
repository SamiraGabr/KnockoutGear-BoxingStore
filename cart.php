<?php
session_start();
require_once 'config/db_connect.php';
require_once 'includes/cart_page.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Knockout Gear</title>
    <link rel="stylesheet" href="styles/cart_style.css">
    <link rel="stylesheet" href="styles/home_style.css">
    <link rel="stylesheet" href="styles/nav_foot_style.css">
</head>
<body>
    <?php include 'templates/nav.php'; ?>

    <section class="cart">
        <h2>Your Cart</h2>
        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Variation</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo htmlspecialchars($item['variation'] ?? 'None'); ?></td>
                            <td>$<?php echo number_format($item['price'] /*+ ($item['additional_price'] ?? 0)*/, 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format(($item['price'] + ($item['additional_price'] ?? 0)) * $item['quantity'], 2); ?></td>
                            <td><button class="remove-item" data-id="<?php echo $item['cart_item_id']; ?>">Remove</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>Total: $<?php echo number_format($cart_total, 2); ?></p>
            <a href="checkout.php" class="btn">Proceed to Checkout</a>
        <?php endif; ?>
    </section>

    <?php include 'templates/footer.php'; ?>
    <script src="scripts/main.js"></script>
    <script src="scripts/products_script.js"></script>
</body>
</html>