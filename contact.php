<?php include 'includes/header_home.php'; ?>

<style>
.contact-wrapper{
    max-width:900px;
    margin:50px auto;
}

.contact-wrapper h1{
    font-size:38px;
    font-weight:900;
}

.contact-wrapper p{
    font-size:18px;
    line-height:28px;
}

.support-box{
    display:flex;
    align-items:center;
    gap:15px;
    margin:25px 0;
}

.support-btn{
    background:black;
    color:white;
    padding:12px 25px;
    border-radius:15px;
    text-decoration:none;
    font-size:18px;
    font-weight:700;
}

.support-btn:hover{
    opacity:.8;
}

.social-links a{
    font-weight:700;
    margin-right:10px;
}
</style>

<div class="contact-wrapper">

    <h1>Hubungi kami</h1>

    <p>Punya pertanyaan atau butuh bantuan? Tenang aja, tim kami siap bantu!</p>

    <div class="support-box">
        <img src="foto/waa.png" width="55" style="border-radius:50px;">
        <a class="support-btn" href="mailto:preloved@phase.com">
            💬 Hubungi support
        </a>
    </div>

    <p>
        Kamu juga bisa kontak lewat sosial media seperti
        <span class="social-links">,
            <a href="#">Instagram</a>,
            <a href="#">TikTok</a>,
            <a href="#">facebook</a>.
        </span>
    </p>

</div>

<?php include 'includes/footer.php'; ?>
