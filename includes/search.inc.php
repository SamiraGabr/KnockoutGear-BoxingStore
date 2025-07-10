<?php
$search_query = isset($_GET['query']) ? trim($_GET['query']) : '';
$products = [];

if ($search_query) {
    $sql = "SELECT p.*, pr.average_rating, pr.review_count FROM products p LEFT JOIN product_ratings pr ON p.product_id = pr.product_id WHERE p.name LIKE ? OR p.description LIKE ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%$search_query%", "%$search_query%"]);
    $products = $stmt->fetchAll();
}
?>