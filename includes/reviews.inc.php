<?php
$error      = null;
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$selected_product = null;
$reviews    = [];

$stmt       = $pdo->query("SELECT product_id, name FROM products");
$products   = $stmt->fetchAll();

if ($product_id) {
    $stmt = $pdo->prepare("SELECT p.name FROM products p WHERE p.product_id = ?");
    $stmt->execute([$product_id]);
    $selected_product = $stmt->fetch();

    if ($selected_product) {
        $stmt    = $pdo->prepare("SELECT r.*, u.username FROM reviews r JOIN users u ON r.user_id = u.user_id WHERE r.product_id = ? ORDER BY r.created_at DESC");
        $stmt->execute([$product_id]);
        $reviews = $stmt->fetchAll();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    if (!isset($_SESSION['user_id'])) {
        $error        = "Please log in to submit a review.";
    } else {
        $user_id      = $_SESSION['user_id'];
        $rating       = (int)($_POST['rating'] ?? 0);
        $comment      = trim($_POST['comment'] ?? '');
        $product_id   = (int)($_POST['product_id'] ?? 0);

        if ($rating < 1 || $rating > 5 || empty($comment) || !$product_id) {
            $error    = "Invalid review data.";
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?) ");
                $stmt->execute([$user_id, $product_id, $rating, $comment]);
                header("Location: reviews.php?product_id=$product_id");
                exit;
            } catch (PDOException $e) {
                $error = "Failed to submit review: " . $e->getMessage();
            }
        }
    }
}
?>