<nav class="navbar">
    <?php include 'logo.php'; ?>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="products.php">Products</a></li>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="wishlist.php">Wishlist</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="account.php">Account</a></li>
            <li><a href="templates/logout.php">Logout</a></li>
            <?php include 'user_cart.php'; ?>
        <?php else: ?>
            <li><a href="account.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
-------------------------------------------------------------------

<nav class="navbar">
    <?php include 'logo.php'; ?>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="products.php">Products</a></li>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="wishlist.php">Wishlist</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="account.php">Account</a></li>

            <?php if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                <!-- Admin Icon or Link -->
                <li>
                    <a href="admin_dashboard.php" title="Admin Panel">
                        <span style="color: red;">👑 Admin</span>
                    </a>
                </li>
            <?php endif; ?>

            <li><a href="templates/logout.php">Logout</a></li>
            <?php include 'user_cart.php'; ?>
        <?php else: ?>
            <li><a href="account.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
