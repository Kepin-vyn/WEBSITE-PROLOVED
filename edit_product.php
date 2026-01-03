

<?php
// edit_product.php - Edit produk lengkap (semua field bisa diubah)

include 'config/db_connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: products.php');
    exit;
}

$id = (int)$_GET['id'];

// Load produk
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: products.php');
    exit;
}

// Fixed data (sama seperti add)
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
        'sizes' => ['XXS / 32', 'XS / 34', 'S / 36', 'M / 38', 'L / 40', 'XL / 42', 'XXL / 44']
    ],
    'Electronics' => [
        'subcategories' => ['Handphone', 'Computer', 'Video Game', 'Other'],
        'sub_map' => ['Handphone'=>'Handphone', 'Computer'=>'Computer', 'Video Game'=>'Video Game', 'Other'=>'Other_Electronics']
    ],
    'Entertaiment' => [
        'subcategories' => ['Books', 'Video', 'Audio', 'Other'],
        'sub_map' => ['Books'=>'Books', 'Video'=>'Video', 'Audio'=>'Audio', 'Other'=>'Other_Entertaiment']
    ],
    'Personal Care' => [
        'subcategories' => ['Skincare', 'Parfume', 'Other'],
        'sub_map' => ['Skincare'=>'Skincare', 'Parfume'=>'Parfume', 'Other'=>'Other_PersonalCare']
    ],
    'Branded' => [
        'subcategories' => ['Nike', 'Ralph Laurent', 'Adidas', 'Converse', 'New Balance', 'Other'],
        'sub_map' => ['Nike'=>'Nike', 'Ralph Laurent'=>'Ralph Laurent', 'Adidas'=>'Adidas', 'Converse'=>'Converse', 'New Balance'=>'New Balance', 'Other'=>'Other_Branded']
    ]
];

$categories = array_keys($filters_per_category);

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = (int)($_POST['price'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $category = $_POST['category'] ?? $product['category'];
    $subcategory_display = $_POST['subcategory'] ?? '';
    $condition = $_POST['condition'] ?? $product['condition'];
    $size = null;
    if ($category === 'Fashion') {
        $size = !empty($_POST['size']) ? $_POST['size'] : null;
    }

    $current_filters = $filters_per_category[$category] ?? $filters_per_category['Fashion'];
    $subcategory_db = $current_filters['sub_map'][$subcategory_display] ?? $subcategory_display;

    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $images = [$product['image1'], $product['image2'], $product['image3'], $product['image4'], $product['image5']];
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if ($tmp_name && $_FILES['images']['error'][$key] === 0) {
                $ext = pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);
                $filename = 'prod_edit_' . time() . '_' . $key . '.' . strtolower($ext);
                $target = $upload_dir . $filename;
                move_uploaded_file($tmp_name, $target);
                $images[$key] = $target;
            }
        }
    }

    $sql = "UPDATE products SET 
            name = :name, price = :price, size = :size, `condition` = :condition,
            category = :category, subcategory = :subcategory,
            image1 = :image1, image2 = :image2, image3 = :image3, image4 = :image4, image5 = :image5,
            description = :description
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':price' => $price,
        ':size' => $size,
        ':condition' => $condition,
        ':category' => $category,
        ':subcategory' => $subcategory_db,
        ':image1' => $images[0],
        ':image2' => $images[1],
        ':image3' => $images[2],
        ':image4' => $images[3],
        ':image5' => $images[4],
        ':description' => $description,
        ':id' => $id
    ]);

    header("Location: product_detail.php?id=$id");
    exit;
}
?>

<?php include 'includes/header_home.php'; ?>

<link rel="stylesheet" href="edit-product-style.css?v=<?= time() ?>">

<div class="edit-product-page">
    <div class="edit-product-form">
        <h1>Edit Produk</h1>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-left">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Business Description</label>
                        <textarea name="description" rows="6"><?= htmlspecialchars($product['description']) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" id="category" required>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat ?>" <?= $product['category'] == $cat ? 'selected' : '' ?>><?= $cat ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Product Category</label>
                        <select name="subcategory" id="subcategory" required>
                            <!-- Diisi JS -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kondisi</label>
                        <select name="condition" required>
                            <option value="Like New" <?= $product['condition'] == 'Like New' ? 'selected' : '' ?>>Like New</option>
                            <option value="Lightly Used" <?= $product['condition'] == 'Lightly Used' ? 'selected' : '' ?>>Lightly Used</option>
                            <option value="Well Used" <?= $product['condition'] == 'Well Used' ? 'selected' : '' ?>>Well Used</option>
                        </select>
                    </div>

                    <div class="form-group" id="size-field" style="display: <?= $product['category'] == 'Fashion' ? 'block' : 'none' ?>;">
                        <label>Select Size</label>
                        <select name="size">
                            <option value="">Pilih Size (Opsional)</option>
                            <option value="XXS / 32" <?= $product['size'] == 'XXS / 32' ? 'selected' : '' ?>>XXS / 32</option>
                            <option value="XS / 34" <?= $product['size'] == 'XS / 34' ? 'selected' : '' ?>>XS / 34</option>
                            <option value="S / 36" <?= $product['size'] == 'S / 36' ? 'selected' : '' ?>>S / 36</option>
                            <option value="M / 38" <?= $product['size'] == 'M / 38' ? 'selected' : '' ?>>M / 38</option>
                            <option value="L / 40" <?= $product['size'] == 'L / 40' ? 'selected' : '' ?>>L / 40</option>
                            <option value="XL / 42" <?= $product['size'] == 'XL / 42' ? 'selected' : '' ?>>XL / 42</option>
                            <option value="XXL / 44" <?= $product['size'] == 'XXL / 44' ? 'selected' : '' ?>>XXL / 44</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Harga (Rp)</label>
                        <input type="number" name="price" value="<?= $product['price'] ?>" required min="10000" step="1000">
                    </div>
                </div>

                <div class="form-right">
                    <div class="form-group">
                        <label>Gambar Saat Ini</label>
                        <div class="current-images">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if (!empty($product["image$i"])): ?>
                                    <div class="image-preview">
                                        <img src="<?= htmlspecialchars($product["image$i"]) ?>">
                                    </div>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Ganti Gambar (kosongkan jika tidak ingin ganti)</label>
                        <div class="upload-area" id="uploadArea">
                            <p>Drag & drop gambar baru di sini</p>
                            <div class="upload-grid">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <div class="upload-slot">
                                        <div class="upload-preview" id="preview<?= $i ?>"></div>
                                        <input type="file" name="images[]" accept="image/*" 
                                            <?= $i === 1 ? 'required' : '' ?> 
                                            onchange="previewImage(this, <?= $i ?>)">
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Simpan Perubahan</button>
                <a href="product_detail.php?id=<?= $product['id'] ?>" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
const subOptions = <?= json_encode($filters_per_category) ?>;

function loadSubcategory() {
    const cat = document.getElementById('category').value;
    const subSelect = document.getElementById('subcategory');
    subSelect.innerHTML = '<option value="">Pilih Subkategori</option>';
    
    if (subOptions[cat] && subOptions[cat].subcategories) {
        subOptions[cat].subcategories.forEach(sub => {
            const opt = document.createElement('option');
            opt.value = subOptions[cat].sub_map[sub];
            opt.textContent = sub;
            // Selected kalau cocok dengan data produk
            if (opt.value === '<?= $product['subcategory'] ?>') {
                opt.selected = true;
            }
            subSelect.appendChild(opt);
        });
    }

    document.getElementById('size-field').style.display = (cat === 'Fashion') ? 'block' : 'none';
}

document.getElementById('category').addEventListener('change', loadSubcategory);
loadSubcategory(); // Jalankan saat load
</script>

<script>
function previewImage(input, index) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview' + index);
            preview.style.backgroundImage = `url(${e.target.result})`;
            preview.style.border = 'none'; // Hilangkan dashed border setelah upload
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Drag & drop untuk seluruh area upload
const uploadArea = document.querySelector('.upload-area') || document.querySelector('.upload-grid');

if (uploadArea) {
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.style.borderColor = '#000';
        uploadArea.style.background = '#f0f0f0';
    });

    uploadArea.addEventListener('dragleave', (e) => {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.style.borderColor = '#ccc';
        uploadArea.style.background = '#fafafa';
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.style.borderColor = '#ccc';
        uploadArea.style.background = '#fafafa';

        const files = e.dataTransfer.files;
        const inputs = uploadArea.querySelectorAll('input[type="file"]');

        for (let i = 0; i < Math.min(files.length, inputs.length); i++) {
            if (files[i].type.match('image.*')) {
                inputs[i].files = files;
                previewImage(inputs[i], i + 1);
            }
        }
    });
}
</script>

<?php include 'includes/footer.php'; ?>