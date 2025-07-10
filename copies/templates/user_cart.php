<?php
//session_start();
//require_once '../config/db_connect.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/KnockoutGear/config/db_connect.php');
$cart_count = 0;
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT COUNT(*) as item_count FROM cart c JOIN cart_items ci ON c.cart_id = ci.cart_id WHERE c.user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $cart_count = $stmt->fetch()['item_count'];
}
?>
<div class="cart-summary">
    <a href="cart.php">Cart (<?php echo $cart_count; ?>)</a>
</div>