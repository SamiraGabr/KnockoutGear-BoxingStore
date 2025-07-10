<?php
$category_id  = isset($_GET['category_id']) ? (int)$_GET['category_id'] : '';
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "SELECT p.*, pr.average_rating, pr.review_count
        FROM products p
        LEFT JOIN product_ratings pr ON p.product_id = pr.product_id
        WHERE p.is_active = 1 AND 1=1";
$params = [];

if ($category_id) {
    $sql     .= " AND p.product_id IN (SELECT product_id FROM product_categories WHERE category_id = ?)";
    $params[] = $category_id;
}

if ($search_query) {
    $sql     .= " AND (p.name LIKE ? OR p.description LIKE ?)";
    $params[] = "%$search_query%";
    $params[] = "%$search_query%";
}

$stmt       = $pdo->prepare($sql);
$stmt->execute($params);
$products   = $stmt->fetchAll();

$stmt       = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();
?>