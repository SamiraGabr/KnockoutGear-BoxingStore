<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: account.php');
    exit;
}
if (isset($_POST['place_order'])) {
    $user_id = $_SESSION['user_id'];
    $shipping_address = $_POST['shipping_address'] ?? '';
    $billing_address  = $_POST['billing_address'] ?? '';
    $payment_method   = $_POST['payment_method'] ?? '';
// Here I am using stored procedures, The query logic is already configured in the database,
// so there's no need to write the full SQL query in the PHP code
// The variable @order_id is a user-defined variable representing the ID of the most recently processed order
    if (empty($shipping_address) || empty($billing_address) || empty($payment_method)) {
        $error = "All fields are required.";
    } else {
        try {
            $stmt = $pdo->prepare("CALL place_order(?, ?, ?, ?, @order_id)");
            $stmt->execute([$user_id, $shipping_address, $billing_address, $payment_method]);
            $stmt = $pdo->query("SELECT @order_id AS order_id");
            $result = $stmt->fetch();
            header('Location: orders.php?order_id=' . $result['order_id']);
            exit;
        } catch (PDOException $e) {
            $error = "Error placing order: " . $e->getMessage();
        }
    }
}
/* في ف DB ال query دا 
DELIMITER 
CREATE PROCEDURE place_order(
    IN p_user_id INT,
    IN p_shipping_address TEXT,
    IN p_billing_address TEXT,
    IN p_payment_method VARCHAR(50),
    OUT p_order_id INT
)
BEGIN
    --  كود Stored Procedure
END //
DELIMITER ;*/
?>
