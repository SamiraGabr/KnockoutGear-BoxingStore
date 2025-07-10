<?php
session_start();
require_once 'config/db_connect.php';
require_once 'includes/user.inc.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: account.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Knockout Gear</title>
    <link rel="stylesheet" href="styles/account_style.css">
    <link rel="stylesheet" href="styles/nav_foot_style.css">
</head>
<body>
    <?php include 'templates/nav.php'; ?>

    <section class="admin">
        <h2>Admin Panel</h2>
        <h3>Add New Product</h3>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form action="admin.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="number" name="price" placeholder="Price" step="0.01" required>
            <input type="number" name="stock_quantity" placeholder="Stock Quantity" required>

            <label>Paste Image Link:</label>
            <input type="url" name="image_url" placeholder="https://example.com/image.jpg" required>

            <label><input type="checkbox" name="is_featured"> Featured Product</label>

            <select name="category_id" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['category_id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" name="add_product" class="btn">Add Product</button>
        </form>
        <h3>Manage Orders</h3>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Change Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?php echo $order['order_id']; ?></td>
                        <td><?php echo htmlspecialchars($order['username']); ?></td>
                        <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                        <td>
                            <form method="POST" action="admin.php">
                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                <select name="status" required>
                                    <?php
                                    $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
                                    foreach ($statuses as $status) {
                                        $selected = ($status === $order['status']) ? 'selected' : '';
                                        echo "<option value=\"$status\" $selected>" . ucfirst($status) . "</option>";
                                    }
                                    ?>
                                </select>
                                <button type="submit" name="update_order_status" class="btn">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Manage Products</h3>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <?php
                        $isArchived = isset($product['is_active']) && $product['is_active'] == 0;
                        $rowStyle = $isArchived ? 'style="background-color: #f0f0f0; color: #888;"' : '';
                    ?>
                    <tr <?php echo $rowStyle; ?>>
                        <td>
                            <?php echo htmlspecialchars($product['name']); ?>
                            <?php if ($isArchived): ?>
                                <span style="font-style: italic; font-size: 0.9em;">(Archived)</span>
                            <?php endif; ?>
                        </td>
                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                        <td><?php echo $product['stock_quantity']; ?></td>
                        <td>
                            <form action="admin.php" method="POST" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                <input type="hidden" name="current_status" value="<?php echo $product['is_active']; ?>">
                                <button type="submit" name="toggle_active" class="btn">
                                    <?php echo $product['is_active'] ? 'Deactivate' : 'Activate'; ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <?php include 'templates/footer.php'; ?>
    <script src="scripts/main.js"></script>
</body>
</html>