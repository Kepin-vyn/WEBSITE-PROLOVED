<?php if (isset($_GET['deleted'])): ?>
    <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin: 20px auto; max-width: 1315px; text-align: center;">
        Produk berhasil dihapus!
    </div>
<?php endif; ?>

<?php
// products.php - Versi FINAL & AMAN dengan SEARCH

include 'config/db_connect.php';

// Parameter
$category = $_GET['category'] ?? 'Fashion';
$subcategory = $_GET['sub'] ?? null;

// Search
$search = trim($_GET['search'] ?? '');

// Sorting
$sort_options = [
    'newest' => 'created_at DESC',
    'price_low' => 'price ASC',
    'price_high' => 'price DESC'
];
$sort = $_GET['sort'] ?? 'newest';
$order_by = $sort_options[$sort] ?? 'created_at DESC';

// Filter
$sizes = isset($_GET['size']) && is_array($_GET['size']) ? $_GET['size'] : [];
$conditions = isset($_GET['condition']) && is_array($_GET['condition']) ? $_GET['condition'] : [];
$min_price = $_GET['min_price'] ?? null;
$max_price = $_GET['max_price'] ?? null;

// Fixed data per kategori
$filters_per_category = [
    'Fashion' => [
        'subcategories' => ['Footwear', 'Top', 'Bottom', 'Outwear', 'Other'],
        'sub_map' => [
            'Footwear' => 'Footwear',
            'Top' => 'Top',
            'Bottom' => 'Bottom',
            'Outwear' => 'Outwear',
            'Other' => 'Other_Fashion'
        ],
        'sizes' => ['XXS / 32', 'XS / 34', 'S / 36', 'M / 38', 'L / 40', 'XL / 42', 'XXL / 44'],
        'has_size' => true
    ],
    'Electronics' => [
        'subcategories' => ['Handphone', 'Computer', 'Video Game', 'Other'],
        'sub_map' => ['Handphone'=>'Handphone', 'Computer'=>'Computer', 'Video Game'=>'Video Game', 'Other'=>'Other_Electronics'],
        'has_size' => false
    ],
    'Entertaiment' => [
        'subcategories' => ['Books', 'Video', 'Audio', 'Other'],
        'sub_map' => ['Books'=>'Books', 'Video'=>'Video', 'Audio'=>'Audio', 'Other'=>'Other_Entertaiment'],
        'has_size' => false
    ],
    'Personal Care' => [
        'subcategories' => ['Skincare', 'Parfume', 'Other'],
        'sub_map' => ['Skincare'=>'Skincare', 'Parfume'=>'Parfume', 'Other'=>'Other_PersonalCare'],
        'has_size' => false
    ],
    'Branded' => [
        'subcategories' => ['Nike', 'Ralph Laurent', 'Adidas', 'Converse', 'New Balance', 'Other'],
        'sub_map' => ['Nike'=>'Nike', 'Ralph Laurent'=>'Ralph Laurent', 'Adidas'=>'Adidas', 'Converse'=>'Converse', 'New Balance'=>'New Balance', 'Other'=>'Other_Branded'],
        'has_size' => false
    ]
];

$current_filters = $filters_per_category[$category] ?? $filters_per_category['Fashion'];
$subcategories = $current_filters['subcategories'] ?? [];

// Query produk - TAMBAH SEARCH
$sql = "SELECT id, name, price, size, `condition`, image1 FROM products WHERE category = :category";
$params = [':category' => $category];

// Tambah search
if (!empty($search)) {
    $sql .= " AND name LIKE :search";
    $params[':search'] = '%' . $search . '%';
}

if ($subcategory) {
    $sql .= " AND subcategory = :subcategory";
    $params[':subcategory'] = $subcategory;
}

if ($current_filters['has_size'] && !empty($sizes)) {
    $placeholders = [];
    foreach ($sizes as $i => $size) {
        $key = ":size$i";
        $placeholders[] = $key;
        $params[$key] = $size;
    }
    $sql .= " AND size IN (" . implode(',', $placeholders) . ")";
}

if (!empty($conditions)) {
    $placeholders = [];
    foreach ($conditions as $i => $cond) {
        $key = ":cond$i";
        $placeholders[] = $key;
        $params[$key] = $cond;
    }
    $sql .= " AND `condition` IN (" . implode(',', $placeholders) . ")";
}

if ($min_price !== null && $min_price !== '') {
    $sql .= " AND price >= :min_price";
    $params[':min_price'] = $min_price;
}

if ($max_price !== null && $max_price !== '') {
    $sql .= " AND price <= :max_price";
    $params[':max_price'] = $max_price;
}

$sql .= " ORDER BY $order_by LIMIT 100";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>

<?php include 'includes/header_home.php'; ?>

<link rel="stylesheet" href="products-style.css?v=<?= time() ?>">

<div class="products-page-container">
    <div class="container">
        <h1 style="font-size: 36px; margin: 0px 0 20px;">
            <?php if (!empty($search)): ?>
                Hasil pencarian "<?= htmlspecialchars($search) ?>"
            <?php else: ?>
                <?= htmlspecialchars($category) ?>
            <?php endif; ?>
        </h1>

        <!-- Filter Pills -->
        <div class="filter-pills-bar">
            <!-- Kategori -->
            <div class="filter-pill">Kategori
                <div class="dropdown-options">
                    <?php foreach ($subcategories as $sub): ?>
                        <?php $sub_value = $current_filters['sub_map'][$sub] ?? $sub; ?>
                        <a href="?category=<?= urlencode($category) ?>&sub=<?= urlencode($sub_value) ?>&sort=<?= $sort ?>&search=<?= urlencode($search ?? '') ?>">
                            <?= htmlspecialchars($sub) ?>
                        </a><br>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Size (hanya Fashion) -->
            <?php if ($current_filters['has_size']): ?>
            <div class="filter-pill <?= !empty($sizes) ? 'active' : '' ?>">Size
                <div class="dropdown-options">
                    <?php foreach ($current_filters['sizes'] as $s): ?>
                        <?php
                        $new_sizes = $sizes;
                        if (in_array($s, $sizes)) {
                            $new_sizes = array_diff($sizes, [$s]);
                        } else {
                            $new_sizes[] = $s;
                        }
                        $new_sizes = array_values($new_sizes);
                        $size_query = !empty($new_sizes) ? '&' . http_build_query(['size[]' => $new_sizes]) : '';
                        ?>
                        <label>
                            <input type="checkbox" <?= in_array($s, $sizes) ? 'checked' : '' ?>
                                   onchange="window.location='?category=<?= urlencode($category) ?>&sub=<?= urlencode($subcategory ?? '') ?><?= $size_query ?>&sort=<?= $sort ?>&search=<?= urlencode($search ?? '') ?>'">
                            <?= htmlspecialchars($s) ?>
                        </label><br>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Harga -->
            <div class="filter-pill <?= ($min_price || $max_price) ? 'active' : '' ?>">Harga
                <div class="dropdown-options">
                    <form method="GET" action="">
                        <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
                        <input type="hidden" name="search" value="<?= htmlspecialchars($search ?? '') ?>">
                        <?php if ($subcategory): ?>
                            <input type="hidden" name="sub" value="<?= htmlspecialchars($subcategory) ?>">
                        <?php endif; ?>
                        <input type="hidden" name="sort" value="<?= $sort ?>">
                        <?php foreach ($sizes as $s): ?><input type="hidden" name="size[]" value="<?= htmlspecialchars($s) ?>"><?php endforeach; ?>
                        <?php foreach ($conditions as $c): ?><input type="hidden" name="condition[]" value="<?= htmlspecialchars($c) ?>"><?php endforeach; ?>
                        <label>Dari Rp</label>
                        <input type="number" name="min_price" value="<?= $min_price ?: 10000 ?>" min="10000" step="1000">
                        <label>Sampai Rp</label>
                        <input type="number" name="max_price" value="<?= $max_price ?: '' ?>" min="10000" step="1000">
                        <button type="submit">Apply</button>
                    </form>
                </div>
            </div>

            <!-- Kondisi -->
            <div class="filter-pill <?= !empty($conditions) ? 'active' : '' ?>">Kondisi
                <div class="dropdown-options">
                    <?php $kondisi_opts = ['Like New', 'Lightly Used', 'Well Used']; ?>
                    <?php foreach ($kondisi_opts as $c): ?>
                        <?php
                        $new_conds = $conditions;
                        if (in_array($c, $conditions)) {
                            $new_conds = array_diff($conditions, [$c]);
                        } else {
                            $new_conds[] = $c;
                        }
                        $new_conds = array_values($new_conds);
                        $cond_query = !empty($new_conds) ? '&' . http_build_query(['condition[]' => $new_conds]) : '';
                        ?>
                        <label>
                            <input type="checkbox" <?= in_array($c, $conditions) ? 'checked' : '' ?>
                                   onchange="window.location='?category=<?= urlencode($category) ?>&sub=<?= urlencode($subcategory ?? '') ?><?= $cond_query ?>&sort=<?= $sort ?>&search=<?= urlencode($search ?? '') ?>'">
                            <?= $c ?>
                        </label><br>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Sort by -->
            <div class="filter-pill <?= $sort !== 'newest' ? 'active' : '' ?>">Sort by
                <div class="dropdown-options">
                    <a href="?category=<?= urlencode($category) ?>&sub=<?= urlencode($subcategory ?? '') ?>&sort=newest&search=<?= urlencode($search ?? '') ?>">Terbaru</a><br>
                    <a href="?category=<?= urlencode($category) ?>&sub=<?= urlencode($subcategory ?? '') ?>&sort=price_low&search=<?= urlencode($search ?? '') ?>">Harga: Termurah</a><br>
                    <a href="?category=<?= urlencode($category) ?>&sub=<?= urlencode($subcategory ?? '') ?>&sort=price_high&search=<?= urlencode($search ?? '') ?>">Harga: Tertinggi</a>
                </div>
            </div>
        </div>

        <!-- Selected Tags -->
        <div class="selected-tags">
            <?php if ($subcategory): ?>
                <?php 
                $display_sub = array_search($subcategory, $current_filters['sub_map'] ?? []) ?: $subcategory;
                ?>
                <span class="filter-tag"><?= htmlspecialchars($display_sub) ?> <span class="close-tag" onclick="window.location='?category=<?= urlencode($category) ?>&search=<?= urlencode($search ?? '') ?>'">✕</span></span>
            <?php endif; ?>

            <?php foreach ($sizes as $s): ?>
                <?php 
                $new_sizes = array_diff($sizes, [$s]);
                $new_sizes = array_values($new_sizes);
                $query = $_GET; $query['size'] = $new_sizes; 
                $query['search'] = $search ?? '';
                ?>
                <span class="filter-tag"><?= htmlspecialchars($s) ?> <span class="close-tag" onclick="window.location='?<?= http_build_query($query) ?>'">✕</span></span>
            <?php endforeach; ?>

            <?php if ($min_price || $max_price): ?>
                <?php $query = $_GET; unset($query['min_price'], $query['max_price']); $query['search'] = $search ?? ''; ?>
                <span class="filter-tag">Harga: Rp <?= number_format($min_price ?: 10000) ?> - <?= $max_price ? number_format($max_price) : 'Max' ?> 
                    <span class="close-tag" onclick="window.location='?<?= http_build_query($query) ?>'">✕</span>
                </span>
            <?php endif; ?>

            <?php foreach ($conditions as $c): ?>
                <?php 
                $new_conds = array_diff($conditions, [$c]);
                $new_conds = array_values($new_conds);
                $query = $_GET; $query['condition'] = $new_conds; $query['search'] = $search ?? '';
                ?>
                <span class="filter-tag"><?= htmlspecialchars($c) ?> <span class="close-tag" onclick="window.location='?<?= http_build_query($query) ?>'">✕</span></span>
            <?php endforeach; ?>

            <?php if ($sort !== 'newest'): ?>
                <?php $query = $_GET; unset($query['sort']); $query['search'] = $search ?? ''; ?>
                <span class="filter-tag"><?= $sort === 'price_low' ? 'Harga: Termurah' : 'Harga: Tertinggi' ?> 
                    <span class="close-tag" onclick="window.location='?<?= http_build_query($query) ?>'">✕</span>
                </span>
            <?php endif; ?>
        </div>

        <!-- Subkategori Horizontal -->
        <div class="subcategories-horizontal">
            <a href="?category=<?= urlencode($category) ?>&search=<?= urlencode($search ?? '') ?>" class="<?= !$subcategory ? 'active' : '' ?>">Semua</a>
            <?php foreach ($subcategories as $sub): ?>
                <?php $sub_value = $current_filters['sub_map'][$sub] ?? $sub; ?>
                <a href="?category=<?= urlencode($category) ?>&sub=<?= urlencode($sub_value) ?>&search=<?= urlencode($search ?? '') ?>" 
                   class="<?= ($subcategory === $sub_value) ? 'active' : '' ?>">
                    <?= htmlspecialchars($sub) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Grid Produk -->
        <div class="products-grid-pinterest">
            <?php if (empty($products)): ?>
                <p style="grid-column: 1/-1; text-align:center; padding:100px 0; font-size:18px; color:#888;">
                    Belum ada produk yang sesuai dengan pencarian "<?= htmlspecialchars($search) ?>".
                </p>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-item-pinterest">
                        <a href="product_detail.php?id=<?= $product['id'] ?>">
                            <div class="product-image-wrapper">
                                <img src="<?= htmlspecialchars($product['image1'] ?: 'assets/placeholder.jpg') ?>" 
                                    alt="<?= htmlspecialchars($product['name']) ?>">
                            </div>
                        </a>

                        <div class="product-info">
                            <div class="product-price">
                                Rp <?= number_format($product['price']) ?>
                            </div>
                            <div class="product-name">
                                <?= htmlspecialchars($product['name']) ?>
                            </div>
                            <div class="product-size">
                                <?= $product['size'] ?: 'One size' ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.filter-pill').forEach(pill => {
    pill.addEventListener('click', e => {
        e.stopPropagation();
        const dd = pill.querySelector('.dropdown-options');
        if (dd) {
            document.querySelectorAll('.dropdown-options').forEach(d => d.style.display = 'none');
            dd.style.display = dd.style.display === 'block' ? 'none' : 'block';
        }
    });
});
document.addEventListener('click', () => {
    document.querySelectorAll('.dropdown-options').forEach(dd => dd.style.display = 'none');
});
</script>

<?php include 'includes/footer.php'; ?>