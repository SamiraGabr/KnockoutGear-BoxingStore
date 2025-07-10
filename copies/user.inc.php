<?php
$error      = null;
$stmt       = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();
$stmt       = $pdo->query("SELECT * FROM products");
$products   = $stmt->fetchAll();
$stmt       = $pdo->query("SELECT o.*, u.username FROM orders o JOIN users u ON o.user_id = u.user_id ORDER BY o.created_at DESC");
$orders     = $stmt->fetchAll();

// if admin wants to add product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name           = trim($_POST['name'] ?? '');
    $description    = trim($_POST['description'] ?? '');
    $price          = (float)($_POST['price'] ?? 0);
    $stock_quantity = (int)($_POST['stock_quantity'] ?? 0);
    $category_id    = (int)($_POST['category_id'] ?? 0);
    $is_featured    = isset($_POST['is_featured']) ? 1 : 0;
    $image_path     = null;

    // Handle image URL only
    if (!empty($_POST['image_url'])) {
        $image_url      = trim($_POST['image_url']);
        if (filter_var($image_url, FILTER_VALIDATE_URL)) {
            $image_path = $image_url;
        } else {
            $error      = "Invalid image URL.";
        }
    } else {
        $error          = "Image URL is required.";
    }

    // Validate all fields
    if (empty($name) || empty($description) || $price <= 0 || $stock_quantity <= 0 || $category_id <= 0 || !$image_path) {
        $error = "All fields are required and a valid image URL must be provided.";
    }
    // Insert into DB
    if (!$error) {
        try {
            $stmt       = $pdo->prepare("INSERT INTO products (name, description, price, stock_quantity, image_path, is_featured) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $description, $price, $stock_quantity, $image_path, $is_featured]);

            $product_id = $pdo->lastInsertId();
            $stmt       = $pdo->prepare("INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)");
            $stmt->execute([$product_id, $category_id]);
            header('Location: admin.php');
            exit;
        } catch (PDOException $e) {
            $error      = "Failed to add product: " . $e->getMessage();
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order_status'])) {
    $order_id = (int)($_POST['order_id'] ?? 0);
    $new_status = $_POST['status'] ?? 'pending';
    if (!in_array($new_status, ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])) {
        $error = "Invalid order status.";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
            $stmt->execute([$new_status, $order_id]);
            header("Location: admin.php");
            exit;
        } catch (PDOException $e) {
            $error = "Failed to update order status: " . $e->getMessage();
        }
    }
}
// if admin wants to activate/deactivate product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $product_id = (int)($_POST['product_id'] ?? 0);

    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $exists = $stmt->fetchColumn();

        if (!$exists) {
            $error = "Product not found.";
        } else {
            $stmt = $pdo->prepare("UPDATE products SET is_active = 0 WHERE product_id = ?");
            $stmt->execute([$product_id]);
            header('Location: admin.php');
            exit;
        }
    } catch (PDOException $e) {
        $error = "Failed to archive product: " . $e->getMessage();
    }
}
?>
