<?php
$user           = null;
$login_error    = null;
$register_error = null;

if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //here we start with login
    if (isset($_POST['login'])) {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $stmt     = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user     = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']  = $user['user_id'];
            $_SESSION['is_admin'] = $user['is_admin'];
            header('Location: account.php');
            exit;
        } else {
            $login_error = "Invalid username or password.";
        } //registration part
   } elseif (isset($_POST['register'])) {
        $username   = trim($_POST['username']   ?? '');
        $email      = trim($_POST['email']      ?? '');
        $password   = $_POST['password']        ?? '' ;
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name  = trim($_POST['last_name']  ?? '');
        $address    = trim($_POST['address']    ?? '');
        $city       = trim($_POST['city']       ?? '');
        $state      = trim($_POST['state']      ?? '');
        $zip_code   = trim($_POST['zip_code']   ?? '');
        $country    = trim($_POST['country']    ?? '');
        $phone      = trim($_POST['phone']      ?? '');

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetchColumn() > 0) {
            $register_error  = "Username or email already exists.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, first_name, last_name, address, city, state, zip_code, country, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            try {
                $stmt->execute([$username, $email, $hashed_password, $first_name, $last_name, $address, $city, $state, $zip_code, $country, $phone]);
                $user_id              = $pdo->lastInsertId();
                $_SESSION['user_id']  = $user_id;
                $_SESSION['is_admin'] = false;
                header('Location: account.php');
                exit;
            } catch (PDOException $e) {
                $register_error = "Registration failed: " . $e->getMessage();
            }
        }
    }
}
?>