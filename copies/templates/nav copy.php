<nav class="navbar">
    <?php include 'logo.php'; ?>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="cart.php">Cart</a></li>
        <li><a href="wishlist.php">Wishlist</a></li>
        <li><a href="orders.php">Orders</a></li>
        <li><a href="account.php">Account</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="templates/logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="account.php">Login</a></li>
        <?php endif; ?>
    </ul>
    <?php include 'user_cart.php'; ?>
</nav>
---------------------------------------------------------------------------------------------------------
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
-------------------------------------------------------------------------------------------------------------
<nav class="navbar">
    <?php include 'logo.php'; ?>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="cart.php">Cart</a></li>
        <li><a href="wishlist.php">Wishlist</a></li>
        <li><a href="orders.php">Orders</a></li>
        <li><a href="account.php">Account</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="templates/logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="account.php">Login</a></li>
        <?php endif; ?>
    </ul>
    <?php include 'user_cart.php'; ?>
</nav>
---------------------------------------------------------------------------------------------------------
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
