<?php
//ajax api
session_start();
require_once '../config/db_connect.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['message' => 'Please log in to add items to cart']);
    exit;
}

$action = $_POST['action'] ?? '';

if ($action === 'add_to_cart') {
    $product_id   = (int)($_POST['product_id']     ?? 0);
    $quantity     = (int)($_POST['quantity']       ?? 1);
    $variation_id = !empty($_POST['variation_id']) ? (int)$_POST['variation_id'] : null;
    $user_id      = $_SESSION['user_id'];

    // Check if cart exists
    $stmt = $pdo->prepare("SELECT cart_id FROM cart WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->execute([$user_id]);
    $cart = $stmt->fetch();
    if (!$cart) {
        $stmt = $pdo->prepare("INSERT INTO cart (user_id) VALUES (?)");
        $stmt->execute([$user_id]);
        $cart_id = $pdo->lastInsertId();
    } else {
        $cart_id = $cart['cart_id'];
    }
    // Check product and variation stock
    if ($variation_id) {
        $stmt      = $pdo->prepare("SELECT stock_quantity FROM product_variations WHERE variation_id = ? AND product_id = ?");
        $stmt->execute([$variation_id, $product_id]);
        $variation = $stmt->fetch();
        if (!$variation || $variation['stock_quantity'] < $quantity) {
            echo json_encode(['message' => 'Variation out of stock']);
            exit;
        }
    } else {
        $stmt    = $pdo->prepare("SELECT stock_quantity FROM products WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
        if (!$product || $product['stock_quantity'] < $quantity) {
            echo json_encode(['message' => 'Product out of stock']);
            exit;
        }
    }
    // Add to cart_items
    $stmt = $pdo->prepare("INSERT INTO cart_items (cart_id, product_id, variation_id, quantity) VALUES (?, ?, ?, ?)");
    $stmt->execute([$cart_id, $product_id, $variation_id, $quantity]);
    echo json_encode(['message' => 'Product added to cart']);
    exit;
} elseif ($action === 'remove_from_cart') {
    $cart_item_id = (int)($_POST['cart_item_id'] ?? 0);
    $stmt         = $pdo->prepare("DELETE FROM cart_items WHERE cart_item_id = ?");
    $stmt->execute([$cart_item_id]);
    echo json_encode(['message' => 'Item removed from cart']);
    exit;

}
?>