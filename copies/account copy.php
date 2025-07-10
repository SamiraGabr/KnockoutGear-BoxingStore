<?php
session_start();
require_once 'config/db_connect.php';
require_once 'includes/account.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - Knockout Gear</title>
    <link rel="stylesheet" href="styles/account_style.css">
    <link rel="stylesheet" href="styles/nav_foot_style.css">
</head>
<body>
    <?php include 'templates/nav.php'; ?>

    <section class="account">
        <h2>Account</h2>
        <?php if (isset($_SESSION['user_id'])): ?>
            <h3>Welcome, <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h3>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <p>Address: <?php echo htmlspecialchars($user['address'] . ', ' . $user['city'] . ', ' . $user['state'] . ' ' . $user['zip_code'] . ', ' . $user['country']); ?></p>
            <p>Phone: <?php echo htmlspecialchars($user['phone']); ?></p>
            <a href="templates/logout.php" class="btn">Logout</a>
        <?php else: ?>
            <div class="account-forms">
                <div class="login-form">
                    <h3>Login</h3>
                    <?php if (isset($login_error)): ?>
                        <p class="error"><?php echo htmlspecialchars($login_error); ?></p>
                    <?php endif; ?>
                    <form action="account.php" method="POST">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="submit" name="login" class="btn">Login</button>
                    </form>
                </div>
                <div class="register-form">
                    <h3>Register</h3>
                    <?php if (isset($register_error)): ?>
                        <p class="error"><?php echo htmlspecialchars($register_error); ?></p>
                    <?php endif; ?>
                    <form action="account.php" method="POST">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <input type="text" name="first_name" placeholder="First Name" required>
                        <input type="text" name="last_name" placeholder="Last Name" required>
                        <input type="text" name="address" placeholder="Address">
                        <input type="text" name="city" placeholder="City">
                        <input type="text" name="state" placeholder="State">
                        <input type="text" name="zip_code" placeholder="Zip Code">
                        <input type="text" name="country" placeholder="Country">
                        <input type="text" name="phone" placeholder="Phone">
                        <button type="submit" name="register" class="btn">Register</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <?php include 'templates/footer.php'; ?>
    <script src="scripts/main.js"></script>
</body>
</html>