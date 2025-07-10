<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: account.php');
    exit;
}

$user_id    = $_SESSION['user_id'];
$cart_items = [];
$cart_total = 0;

$stmt = $pdo->prepare("SELECT c.cart_id 
FROM cart c 
WHERE c.user_id = ? 
ORDER BY c.created_at 
DESC LIMIT 1");
$stmt->execute([$user_id]);
$cart = $stmt->fetch();

if ($cart) {
    $stmt = $pdo->prepare("SELECT ci.cart_item_id, ci.quantity, ci.variation_id, p.name, p.price, pv.variation_type, pv.variation_value, pv.additional_price, CONCAT(pv.variation_type, ': ', pv.variation_value) AS variation
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.product_id
        LEFT JOIN product_variations pv ON ci.variation_id = pv.variation_id
        WHERE ci.cart_id = ?");
    $stmt->execute([$cart['cart_id']]);
    $cart_items = $stmt->fetchAll();

    foreach ($cart_items as $item) {
        $item_total = ($item['price'] + ($item['additional_price'] ?? 0)) * $item['quantity'];
        $cart_total += $item_total;
    }
}
?>