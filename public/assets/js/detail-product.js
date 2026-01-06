// Product Gallery
const mainImage = document.getElementById('mainImage');
const thumbnails = document.querySelectorAll('.thumbnail');

thumbnails.forEach(thumbnail => {
    thumbnail.addEventListener('click', () => {
        // Hapus class active dari semua thumbnail
        thumbnails.forEach(thumb => thumb.classList.remove('active'));

        // Tambah class active ke thumbnail yang diklik
        thumbnail.classList.add('active');

        // Update gambar utama
        const newImageSrc = thumbnail.getAttribute('data-image');
        mainImage.src = newImageSrc;
        mainImage.alt = thumbnail.querySelector('img').alt;
    });
});

// Product Variants
const variantOptions = document.querySelectorAll('.variant-option');
const currentPrice = document.querySelector('.current-price');
const originalPrice = document.querySelector('.original-price');
const discountPercentage = document.querySelector('.discount-percentage');

// Data harga untuk setiap varian
const variantPrices = {
    basic: {
        current: 'Rp 499.000',
        original: 'Rp 624.000',
        discount: 'Hemat 20%'
    },
    professional: {
        current: 'Rp 899.000',
        original: 'Rp 1.124.000',
        discount: 'Hemat 20%'
    },
    enterprise: {
        current: 'Rp 1.499.000',
        original: 'Rp 1.874.000',
        discount: 'Hemat 20%'
    }
};

variantOptions.forEach(option => {
    option.addEventListener('click', () => {
        // Skip jika disabled
        if (option.classList.contains('disabled')) return;

        // Hapus class selected dari semua option
        variantOptions.forEach(opt => opt.classList.remove('selected'));

        // Tambah class selected ke option yang diklik
        option.classList.add('selected');

        // Update harga berdasarkan varian
        const variant = option.getAttribute('data-variant');
        if (variantPrices[variant]) {
            currentPrice.textContent = variantPrices[variant].current;
            originalPrice.textContent = variantPrices[variant].original;
            discountPercentage.textContent = variantPrices[variant].discount;
        }
    });
});

// Product Tabs
const tabHeaders = document.querySelectorAll('.tab-header');
const tabContents = document.querySelectorAll('.tab-content');

tabHeaders.forEach(header => {
    header.addEventListener('click', () => {
        const tabId = header.getAttribute('data-tab');

        // Hapus class active dari semua tab header
        tabHeaders.forEach(h => h.classList.remove('active'));

        // Tambah class active ke tab header yang diklik
        header.classList.add('active');

        // Sembunyikan semua tab content
        tabContents.forEach(content => {
            content.classList.remove('active');
        });

        // Tampilkan tab content yang sesuai
        document.getElementById(tabId).classList.add('active');
    });
});

// Add to Cart
const addToCartBtn = document.getElementById('addToCartBtn');
const cartCounts = document.querySelectorAll('.cart-count');

addToCartBtn.addEventListener('click', () => {
    // Update cart count
    cartCounts.forEach(countElement => {
        let currentCount = parseInt(countElement.textContent);
        countElement.textContent = currentCount + 1;

        // Animasi sederhana
        countElement.style.transform = 'scale(1.3)';
        setTimeout(() => {
            countElement.style.transform = 'scale(1)';
        }, 300);
    });

    // Notifikasi
    alert('Produk telah ditambahkan ke keranjang!');

    // Update juga teks keranjang di mobile menu
    const mobileCartText = document.querySelector('.mobile-cart-text p');
    if (mobileCartText) {
        // Simulasi update total harga (dalam contoh ini menambah Rp 499.000)
        const currentText = mobileCartText.textContent;
        const match = currentText.match(/Rp ([\d.,]+)/);
        if (match) {
            const currentTotal = parseInt(match[1].replace(/\./g, ''));
            const newTotal = currentTotal + 499000;
            const formattedTotal = new Intl.NumberFormat('id-ID').format(newTotal);
            mobileCartText.textContent = `4 item - Rp ${formattedTotal}`;
        }
    }
});

// WhatsApp link dengan pesan otomatis
const whatsappBtn = document.querySelector('.btn-whatsapp');
const telegramBtn = document.querySelector('.btn-telegram');

// Update WhatsApp link dengan varian yang dipilih
function updateWhatsAppLink() {
    const selectedVariant = document.querySelector('.variant-option.selected').getAttribute('data-variant');
    const variantNames = {
        basic: 'Paket Dasar',
        professional: 'Paket Profesional',
        enterprise: 'Paket Enterprise'
    };

    const message = `Halo Ravaa Creative, saya tertarik dengan ${variantNames[selectedVariant]} - Paket Desain Logo Profesional. Bisa info lebih detail?`;
    const encodedMessage = encodeURIComponent(message);
    whatsappBtn.href = `https://wa.me/6281234567890?text=${encodedMessage}`;
}

// Update link saat varian berubah
variantOptions.forEach(option => {
    option.addEventListener('click', () => {
        if (!option.classList.contains('disabled')) {
            updateWhatsAppLink();
        }
    });
});

// Inisialisasi link WhatsApp
updateWhatsAppLink();