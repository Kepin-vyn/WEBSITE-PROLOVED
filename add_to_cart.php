<?php
session_start();
include 'config/db_connect.php';

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false]);
    exit;
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT id, name, price, image1, size FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo json_encode(['success' => false]);
    exit;
}

// Tambah ke cart
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

$found = false;
foreach ($_SESSION['cart'] as &$item) {
    if ($item['id'] == $id) {
        $item['quantity'] = ($item['quantity'] ?? 1) + 1;
        $found = true;
        break;
    }
}

if (!$found) {
    $_SESSION['cart'][] = [
        'id' => $product['id'],
        'name' => $product['name'],
        'price' => $product['price'],
        'image1' => $product['image1'],
        'size' => $product['size'],
        'quantity' => 1
    ];
}

$cart_count = 0;
foreach ($_SESSION['cart'] as $item) {
    $cart_count += $item['quantity'];
}

echo json_encode(['success' => true, 'cart_count' => $cart_count]);
?>