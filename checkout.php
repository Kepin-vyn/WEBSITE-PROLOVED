<?php
// checkout.php - Halaman Checkout Sederhana

include 'includes/header_home.php';
include 'config/db_connect.php';

session_start();

// Redirect kalau keranjang kosong
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

// Hitung total
$total = 0;
$item_count = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * ($item['quantity'] ?? 1);
    $item_count += ($item['quantity'] ?? 1);
}
?>

<link rel="stylesheet" href="global-style.css?v=<?= time() ?>">
<link rel="stylesheet" href="checkout-style.css?v=<?= time() ?>">

<div class="checkout-page">
    <div class="container">
        <h1>Checkout</h1>

        <div class="checkout-layout">
            <!-- Form Alamat Kiri -->
            <div class="checkout-form">
                <h2>Alamat Pengiriman</h2>
                <form method="POST" action="process_checkout.php">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="full_name" required>
                    </div>

                    <div class="form-group">
                        <label>No. Handphone</label>
                        <input type="text" name="phone" required placeholder="Contoh: 081234567890">
                    </div>

                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <textarea name="address" rows="4" required placeholder="Jalan, nomor rumah, RT/RW, dll"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Kota / Kabupaten</label>
                            <input type="text" name="city" required>
                        </div>
                        <div class="form-group">
                            <label>Kode Pos</label>
                            <input type="text" name="postal_code" required>
                        </div>
                    </div>

                    <div class="form-note">
                        <p>Ongkir akan dihitung otomatis setelah alamat lengkap.</p>
                    </div>

                    <!-- Tombol Checkout dipindah ke dalam form -->
                    <div class="checkout-action">
                        <button type="submit" class="btn-pay">
                            Bayar Sekarang
                        </button>
                    </div>
                </form>
            </div>

            <!-- Ringkasan Pesanan Kanan -->
            <div class="checkout-summary">
                <div class="summary-card">
                    <h2>Ringkasan Pesanan (<?= $item_count ?> item)</h2>

                    <div class="summary-items">
                        <?php foreach ($_SESSION['cart'] as $item): 
                            $quantity = $item['quantity'] ?? 1;
                            $subtotal = $item['price'] * $quantity;
                        ?>
                            <div class="summary-item">
                                <img src="<?= htmlspecialchars($item['image1'] ?? 'assets/placeholder.jpg') ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                <div class="summary-info">
                                    <h4><?= htmlspecialchars($item['name']) ?></h4>
                                    <p>Jumlah: <?= $quantity ?> × Rp <?= number_format($item['price']) ?></p>
                                    <p class="subtotal">Rp <?= number_format($subtotal) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="summary-total">
                        <div class="total-line">
                            <span>Total Pesanan</span>
                            <strong>Rp <?= number_format($total) ?></strong>
                        </div>
                        <p class="shipping-note">+ Ongkir (dihitung setelah konfirmasi)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>