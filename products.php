<?php
session_start();
require_once 'config/db_connect.php';
require_once 'includes/products.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Knockout Gear</title>
    <link rel="stylesheet" href="styles/products_style.css">
    <link rel="stylesheet" href="styles/home_style.css">
    <link rel="stylesheet" href="styles/nav_foot_style.css">
</head>
<body>
    <?php include 'templates/nav.php'; ?>

    <section class="products">
        <h2>Our Products</h2>
        <form action="products.php" method="GET" class="filter-form">
            <select name="category_id">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['category_id']; ?>" <?php echo $category_id == $category['category_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Filter</button>
        </form>

        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p>$<?php echo number_format($product['price'], 2); ?></p>
                    <p>Rating: <?php echo number_format($product['average_rating'], 1); ?> (<?php echo $product['review_count']; ?> reviews)</p>
                    <?php
                    $stmt = $pdo->prepare("SELECT * FROM product_variations WHERE product_id = ?");
                    $stmt->execute([$product['product_id']]);
                    $variations = $stmt->fetchAll();
                    ?>
                    <?php if (!empty($variations)): ?>
                        <form class="variation-form">
                            <select name="variation_id" class="variation-select" data-product-id="<?php echo $product['product_id']; ?>">
                                <option value="">Select Variation</option>
                                <?php foreach ($variations as $variation): ?>
                                    <option value="<?php echo $variation['variation_id']; ?>" data-additional-price="<?php echo $variation['additional_price']; ?>">
                                        <?php echo htmlspecialchars($variation['variation_type'] . ': ' . $variation['variation_value']); ?>
                                        <?php if ($variation['additional_price'] > 0): ?>
                                            (+$<?php echo number_format($variation['additional_price'], 2); ?>)
                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="add-to-cart" data-product-id="<?php echo $product['product_id']; ?>">Add to Cart</button>
                        </form>
                    <?php else: ?>
                        <button class="add-to-cart" data-product-id="<?php echo $product['product_id']; ?>">Add to Cart</button>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <button class="add-to-wishlist" data-product-id="<?php echo $product['product_id']; ?>">
                            <?php
                            $stmt = $pdo->prepare("SELECT COUNT(*) FROM wishlist WHERE user_id = ? AND product_id = ?");
                            $stmt->execute([$_SESSION['user_id'], $product['product_id']]);
                            echo $stmt->fetchColumn() > 0 ? 'Remove from Wishlist' : 'Add to Wishlist';
                            ?>
                        </button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php include 'templates/footer.php'; ?>
    <script src="scripts/products_script.js"></script>
    <script src="scripts/main.js"></script>
</body>
</html>