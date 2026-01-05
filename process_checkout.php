<?php
// payment.php — Halaman Instruksi Pembayaran

include 'includes/header_home.php';
include 'config/db_connect.php';

session_start();

// Pastikan keranjang ada
if(empty($_SESSION['cart'])){
    die("Keranjang belanja kosong");
}

// Ambil data dari form checkout
$name     = $_POST['full_name'] ?? '';
$phone    = $_POST['phone'] ?? '';
$address  = $_POST['address'] ?? '';
$city     = $_POST['city'] ?? '';
$postcode = $_POST['postal_code'] ?? '';
$payment  = $_POST['payment_method'] ?? '';

if(!$name || !$phone || !$address || !$city || !$postcode){
    die("Semua data wajib diisi");
}

if(!$payment){
    die("Silakan pilih metode pembayaran");
}

// Hitung total dari cart
$total = 0;
foreach($_SESSION['cart'] as $item){
    $total += $item['price'] * ($item['quantity'] ?? 1);
}

// Kode unik untuk transfer
$kode_unik = rand(111,999);
$total_transfer = $total + $kode_unik;
?>

<link rel="stylesheet" href="global-style.css?v=<?= time() ?>">
<link rel="stylesheet" href="checkout-style.css?v=<?= time() ?>">

<div class="checkout-page">
  <div class="container">

    <h1>Instruksi Pembayaran</h1>

    <div class="summary-card" style="max-width:800px;margin:auto">

      <h2>Terima kasih sudah order 🎉</h2>

      <p><strong>Nama:</strong> <?= htmlspecialchars($name) ?></p>
      <p><strong>Alamat:</strong> <?= htmlspecialchars($address) ?>, <?= htmlspecialchars($city) ?> <?= htmlspecialchars($postcode) ?></p>
      <p><strong>No HP:</strong> <?= htmlspecialchars($phone) ?></p>

      <hr>

      <h3>Detail Pembayaran</h3>

      <?php if($payment == "cod"): ?>

          <p class="total-line">
            <span>Total</span>
            <strong>Rp <?= number_format($total) ?></strong>
          </p>

          <p>Metode pembayaran: <strong>Cash on Delivery</strong></p>
          <p>Silakan siapkan uang pas ya 😊</p>

      <?php elseif($payment == "transfer"): ?>

          <p class="total-line">
            <span>Total Transfer</span>
            <strong>Rp <?= number_format($total_transfer) ?></strong>
          </p>

          <p>Kode unik: <strong><?= $kode_unik ?></strong></p>

          <div class="bank" style="margin:20px 0;padding:15px;border-radius:12px;background:#fafafa;border:1px solid #eee;">
            <p><strong>Transfer ke rekening berikut:</strong></p>
            <p>
              BCA — 123456789<br>
              a.n. PHASE
            </p>
          </div>

          <p>Setelah transfer, kirim bukti ke WhatsApp ya 👍</p>

      <?php elseif($payment == "qris"): ?>

          <p class="total-line">
            <span>Total</span>
            <strong>Rp <?= number_format($total) ?></strong>
          </p>

          <p>Metode pembayaran: <strong>QRIS / E-Wallet</strong></p>

          <img src="foto/qris.jpeg" width="260" style="border-radius:16px;margin:10px 0">

          <p>Scan barcode di atas untuk membayar</p>

      <?php endif; ?>

      <hr>

      <p>Status pesanan: <strong>Pending</strong></p>

    </div>

  </div>
</div>

<?php include 'includes/footer.php'; ?>