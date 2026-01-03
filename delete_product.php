

<?php
// delete_product.php - Hapus produk + file gambar

include 'config/db_connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: products.php');
    exit;
}

$id = (int)$_GET['id'];

// Load produk untuk ambil path gambar
$stmt = $pdo->prepare("SELECT image1, image2, image3, image4, image5 FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: products.php');
    exit;
}

// Hapus file gambar dari folder uploads (jika ada)
for ($i = 1; $i <= 5; $i++) {
    $img = $product["image$i"] ?? '';
    if ($img !== '' && file_exists($img)) {
        unlink($img); // Hapus file
    }
}

// Hapus dari database
$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$id]);

// Redirect dengan pesan sukses (opsional)
header('Location: products.php?deleted=1');
exit;
?>