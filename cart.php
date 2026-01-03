<?php
// cart.php - UI satu card besar (produk + total di bawah)

include 'includes/header_home.php';
include 'config/db_connect.php';

session_start();

// Hapus item
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $index = (int)$_GET['remove'];
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    header('Location: cart.php');
    exit;
}

// Hitung total & jumlah item
$total = 0;
$item_count = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * ($item['quantity'] ?? 1);
        $item_count += ($item['quantity'] ?? 1);
    }
}
?>

<link rel="stylesheet" href="global-style.css?v=<?= time() ?>">
<link rel="stylesheet" href="cart-style.css?v=<?= time() ?>">

<div class="cart-page">
    <div class="container">
        <h1>Keranjang</h1>

        <?php if (empty($_SESSION['cart'])): ?>
            <div class="empty-cart">
                <p>Keranjangmu masih kosong</p>
                <a href="products.php" class="btn-shop">Belanja Sekarang</a>
            </div>
        <?php else: ?>
            <div class="cart-main-card">
                <!-- Daftar Item -->
                <div class="cart-items">
                    <?php foreach ($_SESSION['cart'] as $index => $item): 
                        $quantity = $item['quantity'] ?? 1;
                    ?>
                        <div class="cart-item">
                            <img src="<?= htmlspecialchars($item['image1'] ?? 'assets/placeholder.jpg') ?>" alt="<?= htmlspecialchars($item['name']) ?>">

                            <div class="item-info">
                                <h3><?= htmlspecialchars($item['name']) ?></h3>
                                <p class="price">Rp <?= number_format($item['price']) ?></p>
                                <p class="size"><?= $item['size'] ?: 'One size' ?></p>
                                <a href="cart.php?remove=<?= $index ?>" class="remove-item">
                                    🗑 Hapus
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Total & Checkout di Bawah -->
                <!-- Total & Checkout di Bawah -->
                <div class="cart-summary">
                    <div class="total">
                        <span>Total</span>
                        <strong>Rp <?= number_format($total) ?></strong>
                    </div>
                    <p class="shipping-note">Ongkir dihitung pas checkout</p>
                    <a href="checkout.php" class="btn-checkout">
                        Checkout <?= $item_count ?> item<?= $item_count > 1 ? 's' : '' ?>
                    </a>
                </div>  
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>