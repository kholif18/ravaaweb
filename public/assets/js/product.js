// Data produk untuk quick view
const productsData = {
    1: {
        name: "Paket Desain Logo Profesional",
        category: "Desain Grafis",
        price: "Rp 499.000",
        description: "Paket lengkap pembuatan logo profesional untuk bisnis Anda. Tim desainer kami akan membuat 3 konsep desain logo yang unik dan sesuai dengan identitas bisnis Anda. Revisi tanpa batas hingga Anda puas dengan hasilnya.",
        features: [
            "3 konsep desain logo yang berbeda",
            "Revisi tanpa batas hingga puas",
            "File final dalam format JPG, PNG, PDF, SVG",
            "File sumber (AI/PSD) untuk kebutuhan editing",
            "Panduan penggunaan warna dan font",
            "Garansi hak cipta 100%"
        ],
        image: "https://images.unsplash.com/photo-1545235617-9465d2a55698?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
    },
    2: {
        name: "Cetak Brosur A4 Full Color",
        category: "Percetakan",
        price: "Rp 1.200/lembar",
        description: "Cetak brosur A4 full color dengan kualitas premium. Cocok untuk promosi produk, layanan, atau event. Kami menggunakan mesin cetak digital terbaru untuk hasil yang tajam dan warna yang akurat.",
        features: [
            "Ukuran A4 (21x29.7 cm)",
            "Full color kedua sisi",
            "Pilihan kertas: Art paper 150gsm atau HVS 100gsm",
            "Finishing: Laminating doff/gloss (opsional)",
            "Minimal order 100 lembar",
            "Waktu pengerjaan 2-3 hari kerja"
        ],
        image: "https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
    },
    3: {
        name: "Notebook Custom Logo Perusahaan",
        category: "ATK & Perlengkapan",
        price: "Rp 25.000/buku",
        description: "Notebook custom dengan cover hardcover yang dicetak logo perusahaan Anda. Cocok untuk kebutuhan internal perusahaan atau sebagai corporate gift untuk klien.",
        features: [
            "Ukuran A5 (14.8x21 cm)",
            "Cover hardcover dengan cetak full color",
            "Isi 100 halaman kertas HVS 70gsm",
            "Garis atau polos (pilihan)",
            "Minimal order 50 pcs",
            "Waktu pengerjaan 7-10 hari kerja"
        ],
        image: "https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
    },
    4: {
        name: "Sablon Kaos Polo Custom",
        category: "Sablon & Merchandise",
        price: "Rp 85.000/pcs",
        description: "Kaos polo berkualitas premium dengan sablon custom menggunakan teknik plastisol yang tahan lama. Cocok untuk seragam perusahaan, event, atau merchandise promosi.",
        features: [
            "Bahan katun pique premium",
            "Teknik sablon plastisol (tahan lama)",
            "Pilihan warna kaos lengkap",
            "Sablon maksimal 3 warna",
            "Minimal order 12 pcs",
            "Ukuran S, M, L, XL, XXL"
        ],
        image: "https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
    }
};

// DOM Elements
const categoryCards = document.querySelectorAll('.category-card');
const productsGrid = document.getElementById('productsGrid');
const productCards = document.querySelectorAll('.product-card');
const viewButtons = document.querySelectorAll('.view-btn');
const quickViewButtons = document.querySelectorAll('.btn-quick-view');
const quickViewModal = document.getElementById('quickViewModal');
const modalClose = document.getElementById('modalClose');
const modalProductContent = document.getElementById('modalProductContent');
const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');
const cartCount = document.querySelector('.cart-count');

// Filter elements
const categoryFilter = document.getElementById('categoryFilter');
const priceFilter = document.getElementById('priceFilter');
const sortFilter = document.getElementById('sortFilter');
const searchInput = document.getElementById('searchInput');
const searchBtn = document.getElementById('searchBtn');
const clearFiltersBtn = document.getElementById('clearFilters');
const filterTags = document.getElementById('filterTags');

// State untuk filter
let activeFilters = {
    category: 'all',
    price: 'all',
    sort: 'default',
    search: ''
};

// Filter produk berdasarkan kategori
categoryCards.forEach(card => {
    card.addEventListener('click', () => {
        // Hapus active class dari semua kategori
        categoryCards.forEach(c => c.classList.remove('active'));
        // Tambah active class ke kategori yang diklik
        card.classList.add('active');

        // Update filter state
        const category = card.getAttribute('data-category');
        activeFilters.category = category;

        // Update dropdown filter
        categoryFilter.value = category === 'all' ? 'all' : category;

        // Terapkan filter
        applyFilters();

        // Update filter tags
        updateFilterTags();
    });
});

// Filter dengan dropdown
categoryFilter.addEventListener('change', () => {
    const category = categoryFilter.value;
    activeFilters.category = category;

    // Update kategori aktif
    categoryCards.forEach(card => {
        const cardCategory = card.getAttribute('data-category');
        card.classList.toggle('active', cardCategory === category || (category === 'all' && cardCategory === 'all'));
    });

    applyFilters();
    updateFilterTags();
});

priceFilter.addEventListener('change', () => {
    activeFilters.price = priceFilter.value;
    applyFilters();
    updateFilterTags();
});

sortFilter.addEventListener('change', () => {
    activeFilters.sort = sortFilter.value;
    applyFilters();
    updateFilterTags();
});

// Search produk
searchBtn.addEventListener('click', () => {
    activeFilters.search = searchInput.value.toLowerCase();
    applyFilters();
    updateFilterTags();
});

searchInput.addEventListener('keyup', (e) => {
    if (e.key === 'Enter') {
        activeFilters.search = searchInput.value.toLowerCase();
        applyFilters();
        updateFilterTags();
    }
});

// Hapus semua filter
clearFiltersBtn.addEventListener('click', () => {
    // Reset filter state
    activeFilters = {
        category: 'all',
        price: 'all',
        sort: 'default',
        search: ''
    };

    // Reset UI
    categoryFilter.value = 'all';
    priceFilter.value = 'all';
    sortFilter.value = 'default';
    searchInput.value = '';

    // Reset kategori aktif
    categoryCards.forEach(card => {
        const cardCategory = card.getAttribute('data-category');
        card.classList.toggle('active', cardCategory === 'all');
    });

    // Terapkan filter
    applyFilters();

    // Hapus filter tags
    filterTags.innerHTML = '';
});

// Fungsi untuk menerapkan filter
function applyFilters() {
    let visibleCount = 0;

    productCards.forEach(card => {
        const category = card.getAttribute('data-category');
        const price = parseInt(card.getAttribute('data-price'));
        const name = card.getAttribute('data-name').toLowerCase();
        const searchTerm = activeFilters.search;

        // Filter kategori
        const categoryMatch = activeFilters.category === 'all' || category === activeFilters.category;

        // Filter harga
        let priceMatch = true;
        if (activeFilters.price !== 'all') {
            const priceRange = activeFilters.price;
            if (priceRange === '0-500') priceMatch = price <= 500000;
            else if (priceRange === '500-1000') priceMatch = price > 500000 && price <= 1000000;
            else if (priceRange === '1000-5000') priceMatch = price > 1000000 && price <= 5000000;
            else if (priceRange === '5000+') priceMatch = price > 5000000;
        }

        // Filter pencarian
        const searchMatch = !searchTerm || name.includes(searchTerm);

        // Tampilkan atau sembunyikan produk
        if (categoryMatch && priceMatch && searchMatch) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Update jumlah produk yang ditampilkan
    const productCountElement = document.querySelector('.product-count');
    if (productCountElement) {
        productCountElement.textContent = `(${visibleCount} produk)`;
    }

    // Urutkan produk jika diperlukan
    sortProducts();
}

// Fungsi untuk mengurutkan produk
function sortProducts() {
    const productsContainer = document.getElementById('productsGrid');
    const products = Array.from(productsContainer.querySelectorAll('.product-card[style*="display: block"]'));

    if (activeFilters.sort !== 'default') {
        products.sort((a, b) => {
            const priceA = parseInt(a.getAttribute('data-price'));
            const priceB = parseInt(b.getAttribute('data-price'));
            const nameA = a.getAttribute('data-name').toLowerCase();
            const nameB = b.getAttribute('data-name').toLowerCase();
            const popularA = a.getAttribute('data-popular') === 'true';
            const popularB = b.getAttribute('data-popular') === 'true';

            switch (activeFilters.sort) {
                case 'price-low':
                    return priceA - priceB;
                case 'price-high':
                    return priceB - priceA;
                case 'name-asc':
                    return nameA.localeCompare(nameB);
                case 'name-desc':
                    return nameB.localeCompare(nameA);
                case 'popular':
                    if (popularA && !popularB) return -1;
                    if (!popularA && popularB) return 1;
                    return 0;
                default:
                    return 0;
            }
        });

        // Reorder products in container
        products.forEach(product => {
            productsContainer.appendChild(product);
        });
    }
}

// Fungsi untuk update filter tags
function updateFilterTags() {
    filterTags.innerHTML = '';

    // Kategori tag
    if (activeFilters.category !== 'all') {
        const categoryText = categoryFilter.options[categoryFilter.selectedIndex].text;
        addFilterTag(`Kategori: ${categoryText}`, 'category');
    }

    // Harga tag
    if (activeFilters.price !== 'all') {
        const priceText = priceFilter.options[priceFilter.selectedIndex].text;
        addFilterTag(`Harga: ${priceText}`, 'price');
    }

    // Sort tag
    if (activeFilters.sort !== 'default') {
        const sortText = sortFilter.options[sortFilter.selectedIndex].text;
        addFilterTag(`Urutkan: ${sortText}`, 'sort');
    }

    // Search tag
    if (activeFilters.search) {
        addFilterTag(`Pencarian: "${activeFilters.search}"`, 'search');
    }
}

// Fungsi untuk menambahkan filter tag
function addFilterTag(text, type) {
    const tag = document.createElement('div');
    tag.className = 'filter-tag';
    tag.innerHTML = `
                ${text}
                <i class="fas fa-times" data-filter-type="${type}"></i>
            `;

    // Tambah event listener untuk menghapus tag
    const removeBtn = tag.querySelector('i');
    removeBtn.addEventListener('click', () => {
        removeFilter(type);
    });

    filterTags.appendChild(tag);
}

// Fungsi untuk menghapus filter tertentu
function removeFilter(type) {
    switch (type) {
        case 'category':
            activeFilters.category = 'all';
            categoryFilter.value = 'all';
            categoryCards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');
                card.classList.toggle('active', cardCategory === 'all');
            });
            break;
        case 'price':
            activeFilters.price = 'all';
            priceFilter.value = 'all';
            break;
        case 'sort':
            activeFilters.sort = 'default';
            sortFilter.value = 'default';
            break;
        case 'search':
            activeFilters.search = '';
            searchInput.value = '';
            break;
    }

    applyFilters();
    updateFilterTags();
}

// Toggle view mode (grid/list)
viewButtons.forEach(button => {
    button.addEventListener('click', () => {
        const view = button.getAttribute('data-view');

        // Update active button
        viewButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        // Update products grid class
        productsGrid.classList.toggle('list-view', view === 'list');

        // Update product cards
        productCards.forEach(card => {
            card.classList.toggle('list-view', view === 'list');
        });
    });
});

// Quick View Modal
quickViewButtons.forEach(button => {
    button.addEventListener('click', () => {
        const productId = button.getAttribute('data-product');
        const product = productsData[productId];

        if (product) {
            modalProductContent.innerHTML = `
                        <div class="modal-product-image">
                            <img src="${product.image}" alt="${product.name}">
                        </div>
                        <div class="modal-product-info">
                            <h2>${product.name}</h2>
                            <div class="modal-product-category">${product.category}</div>
                            <div class="modal-product-price">${product.price}</div>
                            <p class="modal-product-description">${product.description}</p>
                            <div class="modal-product-features">
                                <h4>Fitur Produk:</h4>
                                <ul>
                                    ${product.features.map(feature => `<li>${feature}</li>`).join('')}
                                </ul>
                            </div>
                            <div class="modal-actions">
                                <button class="btn btn-modal" id="modalAddToCart">
                                    <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                </button>
                                <button class="btn btn-modal-outline" id="modalContact">
                                    <i class="fas fa-envelope"></i> Konsultasi Produk
                                </button>
                            </div>
                        </div>
                    `;

            // Tambah event listener untuk tombol dalam modal
            const modalAddToCart = document.getElementById('modalAddToCart');
            if (modalAddToCart) {
                modalAddToCart.addEventListener('click', () => {
                    let currentCount = parseInt(cartCount.textContent);
                    cartCount.textContent = currentCount + 1;

                    // Animasi sederhana
                    cartCount.style.transform = 'scale(1.3)';
                    setTimeout(() => {
                        cartCount.style.transform = 'scale(1)';
                    }, 300);

                    // Tutup modal
                    quickViewModal.classList.remove('active');

                    alert(`"${product.name}" telah ditambahkan ke keranjang!`);
                });
            }

            // Buka modal
            quickViewModal.classList.add('active');
        }
    });
});

// Tutup modal
modalClose.addEventListener('click', () => {
    quickViewModal.classList.remove('active');
});

// Tutup modal dengan klik di luar konten
quickViewModal.addEventListener('click', (e) => {
    if (e.target === quickViewModal) {
        quickViewModal.classList.remove('active');
    }
});

// Tambah ke keranjang
addToCartButtons.forEach(btn => {
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

// Mobile menu toggle
const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
const nav = document.querySelector('nav ul');

mobileMenuBtn.addEventListener('click', () => {
    if (nav.style.display === 'flex') {
        nav.style.display = 'none';
    } else {
        nav.style.display = 'flex';
        nav.style.flexDirection = 'column';
        nav.style.position = 'absolute';
        nav.style.top = '70px';
        nav.style.right = '20px';
        nav.style.background = 'white';
        nav.style.padding = '20px';
        nav.style.borderRadius = '10px';
        nav.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
        nav.style.width = '200px';
        nav.style.zIndex = '1000';
    }
});

// Inisialisasi filter tags
updateFilterTags();