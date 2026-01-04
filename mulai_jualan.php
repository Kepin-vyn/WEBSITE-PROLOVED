<?php include 'includes/header_home.php'; ?>

<link rel="stylesheet" href="mulai-jualan-style.css">


<div class="login-wrapper">

    <h1>Buat akun Preloved buat jual</h1>

    <div class="login-box">

        <div class="google-btn">
            <img src="foto/gg.png" width="20">
            Masuk lewat Google
        </div>

        <div class="divider">atau</div>

        <form method="POST" action="add_products.php">

            <div class="input-group">
                <label>Username atau Email</label>
                <input type="text" name="username" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div style="text-align:right;">
                <a href="#">Lupa password?</a>
            </div>

            <button class="login-btn" type="submit">Login</button>
            <a href="add_product.php"></a>

        </form>

    </div>

</div>

<?php include 'includes/footer.php'; ?>


