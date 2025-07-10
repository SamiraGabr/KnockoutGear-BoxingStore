<?php
//ajax api
session_start();
require_once __DIR__ . '/../config/db_connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['message' => 'Please log in to manage wishlist']);
        exit;
    }

    $action     = $_POST['action']           ?? '';
    $product_id = (int)($_POST['product_id'] ?? 0);
    $user_id    = $_SESSION['user_id'];

    if ($action === 'toggle_wishlist') {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM wishlist WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        $exists = $stmt->fetchColumn() > 0; //first column from firts row which equal to the count result of product existence

        if ($exists) {
            $stmt = $pdo->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$user_id, $product_id]);
            echo json_encode(['message' => 'Removed from wishlist', 'in_wishlist' => false]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $product_id]);
            echo json_encode(['message' => 'Added to wishlist', 'in_wishlist' => true]);
        }
        exit;
    }
}
?>