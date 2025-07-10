<?php
session_start();
require_once '../config/db_connect.php';
header('Content-Type: application/json');
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['message' => 'Please log in to add items to cart']);
    exit;
}
$action = $_POST['action'] ?? '';





?>