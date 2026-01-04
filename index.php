<?php include 'includes/header_home.php'; ?>

<link rel="stylesheet" href="global-style.css?v=<?= time() ?>">
<link rel="stylesheet" href="products-style.css?v=<?= time() ?>">

    <!-- Hero Slider -->
    <div class="hero-slider">
        <div class="slides-container">
            <div class="slide active">
                <img src="homepagesatu.jpg" alt="Hero 1">
            </div>
            <div class="slide">
                <img src="homepage.jpeg" alt="Hero 2">
            </div>
            <div class="slide">
                <img src="banner bawah.jpeg" alt="Hero 3">
            </div>
        </div>
    </div>

    <!-- Section Apa Itu Preloved Market - Layout Baru -->
    <section class="about-preloved">
        <div class="container">
            <!-- Row: Judul + Gambar berdampingan -->
            <div class="about-header">
                <div class="about-title">
                    <h1 id="tentang-kami"></h1>
                    <h2>Apa Sih<br>Preloved Market?</h2>
                </div>
                <div class="about-image">
                    <img src="alasan.png" alt="Preloved Market">
                </div>
            </div>

            <!-- Teks Penjelasan Full Width -->
            <div class="text-section">
                <p>Suka berburu barang unik, murah, dan penuh cerita? Preloved Market adalah tempatnya buat kamu. Disini, kamu nggak cuma belanja barang preloved, kamu nemu harta karun. Dan pastinya interaksi sama penjual yang bener-bener ngerti passion kamu soal secondhand.</p>
                <p>Preloved Market adalah bazaar preloved yang diadakan setiap weekend dan diisi oleh 8-10 seller terkurasi dari komunitas Carousell dimana mereka akan berjualan di toko anak perusahaan Carousell, Maujual Store! Kebanyakan barang yang dijual berasal dari koleksi pribadi para seller, dan sudah dikurasi bareng tim Carousell & Maujual. Jadi kamu nggak perlu khawatir, hanya barang preloved yang berkualitas dan pastinya masih layak pakai yang boleh tampil di sini.</p>
                <p>Setiap minggu beda seller, beda cerita, beda hidden gems yang bisa kamu temukan. Yuk mampir dan temukan barang favorit barumu di Preloved Market!</p>
            </div>
        </div>
    </section>

        <!-- Section Hot Items -->
    <section class="hot-items-section">
        <div class="container">
            <h2 class="section-title">Hot Items</h2>
            <div class="hot-items-grid products-grid-pinterest">  <!-- Pakai class sama dari products-style.css -->
                <!-- Item 1 -->
                <a href="product_detail.php?id=1" class="product-item-pinterest">
                    <div class="product-image-wrapper">
                        <img src="assets/s-l1200 (1).png" alt="Dr. Martens Boots">
                    </div>
                    <div class="product-info">
                        <div class="product-price">Rp 800.000</div>
                        <div class="product-name">Dr. Martens</div>
                        <div class="product-size">42</div>
                    </div>
                </a>

                <!-- Item 2 -->
                <a href="product_detail.php?id=2" class="product-item-pinterest">
                    <div class="product-image-wrapper">
                        <img src="assets/SEPATU.jpg" alt="Nike Vintage Shoes">
                    </div>
                    <div class="product-info">
                        <div class="product-price">Rp 235.000</div>
                        <div class="product-name">Vintage Nike</div>
                        <div class="product-size">40</div>
                    </div>
                </a>

                <!-- Item 3 -->
                <a href="product_detail.php?id=3" class="product-item-pinterest">
                    <div class="product-image-wrapper">
                        <img src="assets/CELANA.jpg" alt="Track Pants Vintage">
                    </div>
                    <div class="product-info">
                        <div class="product-price">Rp 85.000</div>
                        <div class="product-name">Vintage Pants</div>
                        <div class="product-size">L</div>
                    </div>
                </a>

                <!-- Item 4 -->
                <a href="product_detail.php?id=4" class="product-item-pinterest">
                    <div class="product-image-wrapper">
                        <img src="assets/KEMEJA.jpg" alt="Ellesse Polo">
                    </div>
                    <div class="product-info">
                        <div class="product-price">Rp 155.000</div>
                        <div class="product-name">Ellesse Polo</div>
                        <div class="product-size">M</div>
                    </div>
                </a>

                <!-- Item 5 -->
                <a href="product_detail.php?id=5" class="product-item-pinterest">
                    <div class="product-image-wrapper">
                        <img src="assets/DR.JPG" alt="Dr. Martens Brown">
                    </div>
                    <div class="product-info">
                        <div class="product-price">Rp 850.000</div>
                        <div class="product-name">Dr. Martens</div>
                        <div class="product-size">42</div>
                    </div>
                </a>

                <!-- Item 6 -->
                <a href="product_detail.php?id=6" class="product-item-pinterest">
                    <div class="product-image-wrapper">
                        <img src="assets/KAOS.jpg" alt="Vintage Shirt">
                    </div>
                    <div class="product-info">
                        <div class="product-price">Rp 120.000</div>
                        <div class="product-name">Vintage Shirt</div>
                        <div class="product-size">M</div>
                    </div>
                </a>

                <!-- Item 7 -->
                <a href="product_detail.php?id=7" class="product-item-pinterest">
                    <div class="product-image-wrapper">
                        <img src="assets/Nike.jpg" alt="Nike trainers">
                    </div>
                    <div class="product-info">
                        <div class="product-price">Rp 100.000</div>
                        <div class="product-name">Nike Vintage</div>
                        <div class="product-size">41</div>
                    </div>
                </a>

                <!-- Item 8 -->
                <a href="product_detail.php?id=8" class="product-item-pinterest">
                    <div class="product-image-wrapper">
                        <img src="assets/adidas.jpg" alt="Adidas Jacket">
                    </div>
                    <div class="product-info">
                        <div class="product-price">Rp 280.000</div>
                        <div class="product-name">Adidas Jacket</div>
                        <div class="product-size">L</div>
                    </div>
                </a>

                <!-- Item 9 -->
                <a href="product_detail.php?id=9" class="product-item-pinterest">
                    <div class="product-image-wrapper">
                        <img src="assets/converse.jpg" alt="Converse High">
                    </div>
                    <div class="product-info">
                        <div class="product-price">Rp 450.000</div>
                        <div class="product-name">Converse Shoes</div>
                        <div class="product-size">43</div>
                    </div>
                </a>

                <!-- Item 10 -->
                <a href="product_detail.php?id=10" class="product-item-pinterest">
                    <div class="product-image-wrapper">
                        <img src="assets/samba.jpg" alt="Adidas shoes">
                    </div>
                    <div class="product-info">
                        <div class="product-price">Rp 280.000</div>
                        <div class="product-name">Adidas Tracktop</div>
                        <div class="product-size">XL</div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Section Koleksi Pilihan -->
    <section class="featured-collections">
        <div class="container">
            <h2 class="section-title">Koleksi pilihan<span class="arrow">></span></h2>
            <div class="collections-grid">
                <!-- Koleksi 1 -->
                <a href="products.php?category=Fashion&subcategory=Outwear" class="collection-card">
                    <div class="collection-image-wrapper">
                        <img src="workware.jpeg" alt="Workwear">
                    </div>
                    <h3 class="collection-title">Workwear</h3>
                </a>

                <!-- Koleksi 2 -->
                <a href="products.php?category=Fashion" class="collection-card">
                    <div class="collection-image-wrapper">
                        <img src="jersey.jpeg" alt="Baju Jersey">
                    </div>
                    <h3 class="collection-title">Baju Jersey</h3>
                </a>

                <!-- Koleksi 3 -->
                <a href="products.php?category=Fashion" class="collection-card">
                    <div class="collection-image-wrapper">
                        <img src="y2k.jpeg" alt="Y2K 2000s Core">
                    </div>
                    <h3 class="collection-title">Y2K 2000s Core</h3>
                </a>
            </div>
        </div>
    </section>

       <!-- Hero Banner -->
    <section class="app-download-banner">
        <div class="banner-overlay">
            <div class="banner-content">
                <h2>Belanja lebih mudah dan cepat dengan aplikasi Preloved<br>Dapatkan notifikasi eksklusif, penawaran khusus, dan fitur-fitur menarik lainnya!</h2>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
