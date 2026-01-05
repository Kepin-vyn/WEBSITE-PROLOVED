<?php include 'includes/header_home.php'; ?>

<style>

.faq-wrapper{
    max-width:900px;
    margin:40px auto;
    text-align:center;
}

.faq-wrapper h1{
    font-size:42px;
    font-weight:900;
}

.search-box{
    max-width:650px;
    margin:25px auto;
    padding:12px 18px;
    border-radius:30px;
    border:1px solid #ddd;
    display:flex;
    align-items:center;
    gap:10px;
}

.search-box input{
    width:100%;
    border:none;
    outline:none;
}

.faq-list{
    margin-top:30px;
    text-align:left;
}

.faq-item{
    padding:18px;
    border-bottom:1px solid #eee;
    display:flex;
    justify-content:space-between;
    align-items:center;
    cursor:pointer;
}

.faq-item:hover{
    background:#fafafa;
}

</style>

<div class="faq-wrapper">

    <h1>Frequently asked questions</h1>
    <p>Ada pertanyaan? kita siap membantu</p>

    <div class="search-box">
        🔍
        <input type="text" placeholder="Search question...">
    </div>

    <div class="faq-list">

        <div class="faq-item">
            <span>Cara nego harga</span>
            <span>›</span>
        </div>

        <div class="faq-item">
            <span>Panduan menjual</span>
            <span>›</span>
        </div>

        <div class="faq-item">
            <span>Cara upload produk</span>
            <span>›</span>
        </div>

        <div class="faq-item">
            <span>Metode pembayaran</span>
            <span>›</span>
        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>
