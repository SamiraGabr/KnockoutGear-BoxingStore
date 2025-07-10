<?php
//$stmt              = $pdo->query("SELECT * FROM products WHERE is_featured = TRUE LIMIT 4");
//$featured_products = $stmt->fetchAll();
?>

<?php
$stmt = $pdo->query("SELECT 
        p.*, 
        COALESCE(AVG(r.rating), 0) AS average_rating, 
        COUNT(r.review_id) AS review_count
    FROM products p
    LEFT JOIN reviews r ON p.product_id = r.product_id
    WHERE p.is_featured = TRUE
    GROUP BY p.product_id
    LIMIT 4
");

$featured_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
