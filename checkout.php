<?php
session_start();
require_once 'config/db_connect.php';
require_once 'includes/checkout.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Knockout Gear</title>
    <link rel="stylesheet" href="styles/order_style.css">
    <link rel="stylesheet" href="styles/home_style.css">
    <link rel="stylesheet" href="styles/nav_foot_style.css">
</head>
<body>
    <?php include 'templates/nav.php'; ?>

    <section class="checkout">
        <h2>Checkout</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="checkout.php" method="POST">
            <h3>Shipping Address</h3>
            <input type="text" name="shipping_address" placeholder="Shipping Address" required>
            <h3>Billing Address</h3>
            <input type="text" name="billing_address" placeholder="Billing Address" required>
            <h3>Payment Method</h3>
            <select name="payment_method" required>
                <option value="cash">Cash</option>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
            </select>
            <button type="submit" name="place_order" class="btn">Place Order</button>
        </form>
    </section>

    <?php include 'templates/footer.php'; ?>
    <script src="scripts/main.js"></script> 
    <script src="scripts/products_script.js"></script>
</body>
</html>