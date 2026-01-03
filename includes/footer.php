<!-- includes/footer.php -->
    <footer class="site-footer">
        <div class="container footer-container">
            <div class="footer-columns">
                <div class="footer-column">
                    <h4>Preloved</h4>
                    <ul>
                        <li><a href="#">Download app</a></li>
                        <li><a href="#">Tentang kami</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Discover</h4>
                    <ul>
                        <li><a href="#">Cara kerjanya</a></li>
                        <li><a href="#">Mulai jualan</a></li>
                        <li><a href="#">Thrift shops</a></li>
                        <li><a href="#">Nama olshop</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Help</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="social-icons">
                    <a href="#"><img src="assets/icon-instagram.png" alt="Instagram"></a>
                    <a href="#"><img src="assets/icon-tiktok.png" alt="TikTok"></a>
                    <a href="#"><img src="assets/icon-facebook.png" alt="Facebook"></a>
                    <a href="#"><img src="assets/icon-x.png" alt="X"></a>
                    <a href="#"><img src="assets/icon-linkedin.png" alt="LinkedIn"></a>
                </div>
                <div class="legal-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms & Conditions</a>
                </div>
            </div>
        </div>
    </footer>

    <div id="autocomplete-list" class="autocomplete-items"></div>

    <script>
    // Fix klik dropdown
    document.querySelectorAll('.category-menu a').forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.href && this.href !== '#' && this.href !== window.location.href) {
                e.stopPropagation();
                window.location.href = this.href;
            }
        });
    });
    </script>

    <script src="script.js"></script>
</body>
</html>