<!-- includes/header_home.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved - Homepage</title>
    <link rel="stylesheet" href="global-style.css?v=<?= time() ?>">
</head>
<body>
    <header class="header">
        <!-- Logo + Search Bar -->
            <div class="top-bar">
                <div class="logo">
                    <a href="index.php">
                    <img src="assets/download (5).jpg" alt="Preloved Logo">
                    </a>
                </div>
                <div class="search-container">
                    <!-- SEARCH BAR JADI FORM -->
                    <form action="products.php" method="GET" class="search-bar">
                        <span class="search-icon"></span>
                        <input type="text" name="search" id="searchInput" placeholder="Cari produk..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        <button type="submit" style="display:none;"></button> <!-- Hidden submit untuk Enter -->
                    </form>
                </div>

                <!-- Icon Keranjang di dalam top-bar -->
                <div class="cart-header-icon">
                    <a href="cart.php">
                        <img src="assets/cart-icon.svg" alt="Keranjang">
                        <?php 
                        session_start();
                        $cart_count = 0;
                        if (isset($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $item) {
                                $cart_count += $item['quantity'] ?? 1;
                            }
                        }
                        if ($cart_count > 0): ?>
                            <span class="cart-badge"><?= $cart_count ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>

        <!-- Menu Kategori -->
        <nav class="category-menu">
            <ul>
                <!-- Fashion -->
                <li class="dropdown-parent">
                    <a href="products.php?category=Fashion">Fashion</a> <!-- Menu utama bisa diklik -->
                    <ul class="dropdown">
                        <li><a href="products.php?category=Fashion&subcategory=Women Fashion">Women Fashion</a></li>
                        <li><a href="products.php?category=Fashion&subcategory=Men Fashion">Men Fashion</a></li>
                    </ul>
                </li>

                <!-- Electronics -->
                <li class="dropdown-parent">
                    <a href="products.php?category=Electronics">Electronics</a>
                    <ul class="dropdown">
                        <li><a href="products.php?category=Electronics&subcategory=Handphone">Handphone</a></li>
                        <li><a href="products.php?category=Electronics&subcategory=Computers">Computers</a></li>
                        <li><a href="products.php?category=Electronics&subcategory=Video Game">Video Game</a></li>
                    </ul>
                </li>

                <!-- Entertaiment -->
                <li class="dropdown-parent">
                    <a href="products.php?category=Entertaiment">Entertaiment</a>
                    <ul class="dropdown">
                        <li><a href="products.php?category=Entertaiment&subcategory=Books">Books</a></li>
                        <li><a href="products.php?category=Entertaiment&subcategory=Video">Video</a></li>
                        <li><a href="products.php?category=Entertaiment&subcategory=Audio">Audio</a></li>
                    </ul>
                </li>

                <!-- Personal Care -->
                <li class="dropdown-parent">
                    <a href="products.php?category=Personal Care">Personal Care</a>
                    <ul class="dropdown">
                        <li><a href="products.php?category=Personal Care&subcategory=Skincare">Skincare</a></li>
                        <li><a href="products.php?category=Personal Care&subcategory=Perfume">Perfume</a></li>
                        <li><a href="products.php?category=Personal Care&subcategory=Makeup">Makeup</a></li>
                    </ul>
                </li>

                <!-- Branded -->
                <li class="dropdown-parent">
                    <a href="products.php?category=Branded">Branded</a>
                    <ul class="dropdown">
                        <li><a href="products.php?category=Branded&subcategory=Nike">Nike</a></li>
                        <li><a href="products.php?category=Branded&subcategory=Adidas">Adidas</a></li>
                        <li><a href="products.php?category=Branded&subcategory=Converse">Converse</a></li>
                        <li><a href="products.php?category=Branded&subcategory=New Balance">New Balance</a></li>
                    </ul>
                </li>

                <!-- Add Product -->
                <li><a href="add_products.php" class="add-product">Add Product</a></li>
            </ul>
        </nav>
    </header>