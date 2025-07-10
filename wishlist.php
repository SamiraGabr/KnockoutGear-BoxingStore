<?php
session_start();
require_once 'config/db_connect.php';
//require_once 'includes/wishlist.inc.php';

$wishlist_items = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt    = $pdo->prepare("SELECT p.product_id, p.name, p.price, p.image_path FROM wishlist w
    JOIN products p ON w.product_id = p.product_id
    WHERE w.user_id = ? ");
    $stmt->execute([$user_id]);
    $wishlist_items = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist - Knockout Gear</title>
    <link rel="stylesheet" href="styles/products_style.css">
    <link rel="stylesheet" href="styles/nav_foot_style.css">
</head>
<body>
    <?php include 'templates/nav.php'; ?>

    <section class="wishlist">
        <h2>Your Wishlist</h2>
        <?php if (empty($wishlist_items)): ?>
            <p>Your wishlist is empty.</p>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($wishlist_items as $item): ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p>$<?php echo number_format($item['price'], 2); ?></p>
                        <button class="add-to-cart" data-product-id="<?php echo $item['product_id']; ?>">Add to Cart</button>
                        <button class="remove-from-wishlist" data-product-id="<?php echo $item['product_id']; ?>">Remove</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <?php include 'templates/footer.php'; ?>
    <script src="scripts/products_script.js"></script>
    <script src="scripts/main.js"></script>
</body>
</html>