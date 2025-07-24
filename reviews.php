<?php
session_start();
require_once 'config/db_connect.php';
require_once 'includes/reviews.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - Knockout Gear</title>
    <link rel="stylesheet" href="styles/reviews_style.css">
    <link rel="stylesheet" href="styles/home_style.css">
    <link rel="stylesheet" href="styles/nav_foot_style.css">
</head>
<body>
    <?php include 'templates/nav.php'; ?>

    <section class="reviews">
        <h2>Product Reviews</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="reviews.php" method="GET">
            <select name="product_id" onchange="this.form.submit()">
                <option value="">Select a Product</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?php echo $product['product_id']; ?>" <?php echo $product_id == $product['product_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($product['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <?php if ($product_id && !empty($reviews)): ?>
            <h3>Reviews for <?php echo htmlspecialchars($selected_product['name']); ?></h3>
            <div class="review-list">
                <?php foreach ($reviews as $review): ?>
                    <div class="review">
                        <p><strong><?php echo htmlspecialchars($review['username']); ?></strong> (Rating: <?php echo $review['rating']; ?>/5)</p>
                        <p><?php echo htmlspecialchars($review['comment']); ?></p>
                        <p><small><?php echo $review['created_at']; ?></small></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif ($product_id): ?>
            <p>No reviews yet for this product.</p>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id']) && $product_id): ?>
            <h3>Submit a Review</h3>
            <form action="reviews.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <label>Rating:</label>
                <select name="rating" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <textarea name="comment" placeholder="Your review..." required></textarea>
                <button type="submit" name="submit_review" class="btn">Submit Review</button>
            </form>
        <?php endif; ?>
    </section>

    <?php include 'templates/footer.php'; ?>
    <script src="scripts/main.js"></script>
</body>
</html>