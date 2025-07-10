<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: account.php');
    exit;
}
$user_id       = $_SESSION['user_id'];
$order_details = null;
$order_items   = [];

$stmt   = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();

if (isset($_GET['order_id'])) {
    $order_id      = (int)$_GET['order_id'];
    $stmt          = $pdo->prepare("SELECT * FROM orders WHERE order_id = ? AND user_id = ?");
    $stmt->execute([$order_id, $user_id]);
    $order_details = $stmt->fetch();

    if ($order_details) {
        $stmt      = $pdo->prepare("SELECT oi.quantity, oi.price, p.name FROM order_items oi JOIN products p ON oi.product_id = p.product_id WHERE oi.order_id = ? ");
        $stmt->execute([$order_id]);
        $order_items = $stmt->fetchAll();
    }
}
?>