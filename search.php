<?php
session_start();
require_once 'config/db_connect.php';
require_once 'includes/search.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - Knockout Gear</title>
    <link rel="stylesheet" href="styles/products_style.css">
    <link rel="stylesheet" href="styles/nav_foot_style.css">
</head>
<body>
    <?php include 'templates/nav.php'; ?>

    <section class="search">
        <h2>Search Results</h2>
        <form action="search.php" method="GET" class="search-form">
            <input type="text" name="query" placeholder="Search products..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
        </form>

        <?php if ($search_query): ?>
            <?php if (empty($products)): ?>
                <p>No products found for "<?php echo htmlspecialchars($search_query); ?>".</p>
            <?php else: ?>
                <div class="product-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p>$<?php echo number_format($product['price'], 2); ?></p>
                            <p>Rating: <?php echo number_format($product['average_rating'], 1); ?> (<?php echo $product['review_count']; ?> reviews)</p>
                            <button class="add-to-cart" data-id="<?php echo $product['product_id']; ?>">Add to Cart</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </section>

    <?php include 'templates/footer.php'; ?>
    <script src="scripts/products_script.js"></script>
</body>
</html>