<?php
session_start();
require_once 'config/db_connect.php';
require_once 'includes/index.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knockout Gear - Boxing Store</title>
    <link rel="stylesheet" href="styles/home_style.css">
    <link rel="stylesheet" href="styles/nav_foot_style.css">
</head>
<body>
    <?php include 'templates/nav.php'; ?>
    
    <header class="hero">
        <video autoplay muted loop class="hero-video">
            <source src="images/hero_video.mp4" type="video/mp4">
        </video>
        <div class="hero-text">
            <h1>Knockout Gear</h1>
            <p>Your one-stop shop for premium boxing equipment</p>
            <a href="products.php" class="btn">Shop Now</a>
        </div>
    </header>

    <section class="featured-products">
        <h2>Featured Products</h2>
        <div class="product-grid">
            <?php foreach ($featured_products as $product): ?>
                <div class="product-card">
                    <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p>$<?php echo number_format($product['price'], 2); ?></p>
                    <p>Rating: <?php echo number_format($product['average_rating'], 1); ?> (<?php echo $product['review_count']; ?> reviews)</p>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <button class="add-to-cart" data-product-id="<?php echo $product['product_id']; ?>">Add to Cart</button>
                    <?php else: ?>
                        <p><a href="account.php">Log in</a> to add to cart.</p>
                    <?php endif; ?>
                    <a href="products.php?id=<?php echo $product['product_id']; ?>" class="btn">View Details</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php include 'templates/footer.php'; ?>
    <script src="scripts/products_script.js"></script>
    <script src="scripts/main.js"></script>
</body>
</html>