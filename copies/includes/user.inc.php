<?php
$error = null;

$stmt       = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();

$stmt       = $pdo->query("SELECT * FROM products");
$products   = $stmt->fetchAll();
//if admin want to add product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name           = trim($_POST['name']            ?? '');
    $description    = trim($_POST['description']     ?? '');
    $price          = (float)($_POST['price']        ?? 0);
    $stock_quantity = (int)($_POST['stock_quantity'] ?? 0);
    $category_id    = (int)($_POST['category_id']    ?? 0);
    $is_featured    = isset($_POST['is_featured'])   ? 1 : 0;

    if (empty($name) || empty($description) || $price <= 0 || $stock_quantity <= 0 || $category_id <= 0 || !isset($_FILES['image'])) {
        $error      = "All fields are required.";
    } else {
        $image_path = 'images/products/' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            try {
                $stmt       = $pdo->prepare("INSERT INTO products (name, description, price, stock_quantity, image_path, is_featured) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $description, $price, $stock_quantity, $image_path, $is_featured]);
                $product_id = $pdo->lastInsertId();
                $stmt       = $pdo->prepare("INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)");
                $stmt->execute([$product_id, $category_id]);
                header('Location: admin.php');
                exit;
            } catch (PDOException $e) {
                $error = "Failed to add product: " . $e->getMessage();
            }
        } else {
            $error     = "Failed to upload image.";
        }
    }
}
//if the admin want to delete product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $product_id = (int)($_POST['product_id'] ?? 0);
    try {
        $stmt   = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->execute([$product_id]);
        header('Location: admin.php');
        exit;
    } catch (PDOException $e) {
        $error = "Failed to delete product: " . $e->getMessage();
    }
}
?>