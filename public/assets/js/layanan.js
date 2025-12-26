// Tab layanan
const categoryTabs = document.querySelectorAll('.category-tab');
const serviceContents = document.querySelectorAll('.service-content');

categoryTabs.forEach(tab => {
    tab.addEventListener('click', () => {
        // Hapus class active dari semua tab
        categoryTabs.forEach(t => t.classList.remove('active'));
        // Tambah class active ke tab yang diklik
        tab.classList.add('active');

        // Sembunyikan semua konten layanan
        serviceContents.forEach(content => {
            content.classList.remove('active');
        });

        // Tampilkan konten sesuai tab
        const serviceId = tab.getAttribute('data-service');
        const targetContent = document.getElementById(`${serviceId}-content`);
        if (targetContent) {
            targetContent.classList.add('active');
        }
    });
});

// FAQ accordion
const faqItems = document.querySelectorAll('.faq-item');

faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');

    question.addEventListener('click', () => {
        // Tutup semua FAQ lainnya
        faqItems.forEach(otherItem => {
            if (otherItem !== item) {
                otherItem.classList.remove('active');
            }
        });

        // Buka/tutup FAQ yang diklik
        item.classList.toggle('active');
    });
});

// Tambah ke keranjang
const addToCartBtns = document.querySelectorAll('.btn-add-to-cart');
const cartCount = document.querySelector('.cart-count');

addToCartBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        let currentCount = parseInt(cartCount.textContent);
        cartCount.textContent = currentCount + 1;

        // Animasi sederhana
        cartCount.style.transform = 'scale(1.3)';
        setTimeout(() => {
            cartCount.style.transform = 'scale(1)';
        }, 300);

        alert('Produk telah ditambahkan ke keranjang!');
    });
});