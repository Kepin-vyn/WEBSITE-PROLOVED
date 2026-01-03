// Slider dengan fade (lebih smooth)
let slideIndex = 0;
const slides = document.querySelectorAll('.slide');

function showSlides() {
    slides.forEach(slide => slide.classList.remove('active'));
    slideIndex++;
    if (slideIndex >= slides.length) { slideIndex = 0; }
    slides[slideIndex].classList.add('active');
    setTimeout(showSlides, 5000);
}

showSlides();

// Autocomplete tetap sama seperti sebelumnya
const searchInput = document.getElementById('searchInput');
const autocompleteList = document.getElementById('autocomplete-list');

const suggestions = ['Tas Preloved', 'Baju Wanita Thrift', 'Sepatu Branded', 'Aksesoris Anak', 'Barang Hiburan'];

searchInput.addEventListener('input', function() {
    const val = this.value.toLowerCase();
    autocompleteList.innerHTML = '';
    if (!val) return;

    suggestions.forEach(suggest => {
        if (suggest.toLowerCase().startsWith(val)) {
            const item = document.createElement('div');
            item.innerHTML = `<strong>${suggest.substr(0, val.length)}</strong>${suggest.substr(val.length)}`;
            item.addEventListener('click', function() {
                searchInput.value = suggest;
                autocompleteList.innerHTML = '';
            });
            autocompleteList.appendChild(item);
        }
    });
});

document.addEventListener('click', function(e) {
    if (e.target !== searchInput) {
        autocompleteList.innerHTML = '';
    }
});

// Fix klik dropdown agar langsung redirect (tidak terganggu hover CSS)
document.querySelectorAll('.category-menu .dropdown a').forEach(link => {
    link.addEventListener('click', function(e) {
        // Jangan preventDefault, biar link jalan normal
        // Tapi force redirect langsung
        window.location.href = this.href;
    });
});

// Optional: klik menu utama juga langsung redirect (kalau mau)
document.querySelectorAll('.category-menu > ul > li > a').forEach(link => {
    link.addEventListener('click', function(e) {
        if (this.parentElement.querySelector('.dropdown')) {
            // Kalau ada dropdown, biar hover tetap jalan, jangan redirect saat klik menu utama
            e.preventDefault();
        } else {
            // Kalau tidak ada dropdown (misal Add Product), langsung jalan
            window.location.href = this.href;
        }
    });
});

