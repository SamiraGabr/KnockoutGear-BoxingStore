<?php
$error = null;

$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();

if 

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
        $image_url = trim($_POST['image_url']);
        if (filter_var($image_url, FILTER_VALIDATE_URL)) {
            $image_path = $image_url;
        } else {
            $error = "Invalid image URL.";
        }
    } else {
        $error = "Image URL is required.";
    }

    // Validate all fields
    if (empty($name) || empty($description) || $price <= 0 || $stock_quantity <= 0 || $category_id <= 0 || !$image_path) {
        $error = "All fields are required and a valid image URL must be provided.";
    }

    // Insert into DB
    if (!$error) {
        try {
            $stmt = $pdo->prepare("INSERT INTO products (name, description, price, stock_quantity, image_path, is_featured) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $description, $price, $stock_quantity, $image_path, $is_featured]);

            $product_id = $pdo->lastInsertId();
            $stmt = $pdo->prepare("INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)");
            $stmt->execute([$product_id, $category_id]);

            header('Location: admin.php');
            exit;
        } catch (PDOException $e) {
            $error = "Failed to add product: " . $e->getMessage();
        }
    }
}

// if admin wants to delete product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $product_id = (int)($_POST['product_id'] ?? 0);
    try {
        $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->execute([$product_id]);
        header('Location: admin.php');
        exit;
    } catch (PDOException $e) {
        $error = "Failed to delete product: " . $e->getMessage();
    }
}
?>
