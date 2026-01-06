<?php
// product_detail.php - Rekomendasi mirip products.php (minimalis)

include 'config/db_connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: products.php');
    exit;
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: products.php');
    exit;
}

// Ambil gambar
$images = [];
for ($i = 1; $i <= 5; $i++) {
    if (!empty($product["image$i"])) {
        $images[] = $product["image$i"];
    }
}

$main_image = $images[0] ?? 'assets/placeholder.jpg';

// Rekomendasi - Random dari kategori sama
$recom_stmt = $pdo->prepare("SELECT id, name, price, size, image1 FROM products WHERE category = ? AND id != ? ORDER BY RAND() LIMIT 10");
$recom_stmt->execute([$product['category'], $id]);
$recommendations = $recom_stmt->fetchAll();
?>

<?php include 'includes/header_home.php'; ?>

<link rel="stylesheet" href="detail-style.css?v=<?= time() ?>">
<link rel="stylesheet" href="products-style.css?v=<?= time() ?>">  <!-- Pakai products-style untuk rekomendasi -->

<div class="detail-container">
    <div class="detail-grid">
        <!-- Gallery Kiri -->
        <div>
            <div class="main-image-wrapper">
                <img id="mainImage" src="<?= htmlspecialchars($main_image) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="main-image">
            </div>

            <?php if (count($images) > 1): ?>
            <div class="thumbnail-gallery">
                <?php foreach ($images as $index => $img): ?>
                    <img src="<?= htmlspecialchars($img) ?>" 
                         onclick="document.getElementById('mainImage').src = this.src"
                         class="<?= $index === 0 ? 'active' : '' ?>">
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Info Kanan -->
        <div class="product-info">
            <h1><?= htmlspecialchars($product['name']) ?></h1>
            <p class="product-meta">
                <?= $product['size'] ?: 'One size' ?>
            </p>
            <p class="product-price">Rp <?= number_format($product['price']) ?></p>

           <div class="action-buttons">
                <button class="btn-buy">Beli Langsung</button>
                <button class="btn-cart" onclick="addToCart(<?= $product['id'] ?>)">+ Keranjang</button>

            </div>

            <div class="description-section">
                <h3>Detail</h3>
                <p><?= nl2br(htmlspecialchars($product['description'] ?: 'Tidak ada deskripsi tambahan.')) ?></p>
            </div>

            <!-- Tombol Edit & Hapus (opsional, bisa disembunyikan kalau belum login) -->
            <div style="margin-top: 60px; padding-top: 30px; border-top: 1px solid #eee; text-align: right;">
                <a href="edit_product.php?id=<?= $product['id'] ?>" 
                   style="color: #000; font-weight: 600; text-decoration: underline; font-size: 16px; margin-right: 30px;">
                    Edit Produk
                </a>
                <a href="delete_product.php?id=<?= $product['id'] ?>" 
                   onclick="return confirm('Yakin ingin menghapus produk ini?')"
                   style="color: #d00; font-weight: 600; text-decoration: underline; font-size: 16px;">
                    Hapus Produk
                </a>
            </div>
        </div>
    </div>

    <!-- Rekomendasi - Mirip products.php -->
    <?php if (!empty($recommendations)): ?>
    <div class="recommendations">
        <h2>Kamu mungkin suka</h2>
        <div class="recommendations-grid products-grid-pinterest">  <!-- Pakai class sama dari products-style.css -->
            <?php foreach ($recommendations as $rec): ?>
                <a href="product_detail.php?id=<?= $rec['id'] ?>" class="product-item-pinterest">
                    <div class="product-image-wrapper">
                        <img src="<?= htmlspecialchars($rec['image1'] ?: 'assets/placeholder.jpg') ?>" alt="<?= htmlspecialchars($rec['name']) ?>">
                    </div>
                    <div class="product-info">
                        <div class="product-price">Rp <?= number_format($rec['price']) ?></div>
                        <div class="product-name"><?= htmlspecialchars($rec['name']) ?></div>
                        <div class="product-size"><?= $rec['size'] ?: 'One size' ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
document.querySelectorAll('.thumbnail-gallery img').forEach(img => {
    img.addEventListener('click', function() {
        document.querySelectorAll('.thumbnail-gallery img').forEach(i => i.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>

<script>
function addToCart(productId) {
    fetch('add_to_cart.php?id=' + productId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Produk berhasil ditambahkan ke keranjang!');
                // Update badge di header (kalau ada)
                location.reload(); // Sementara reload biar badge update
            } else {
                alert('Gagal menambah ke keranjang.');
            }
        });
}
</script>

<?php include 'includes/footer.php'; ?>