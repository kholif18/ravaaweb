// Mobile Navigation
const mobileMenuToggle = document.getElementById('mobileMenuToggle');
const mobileNavOverlay = document.getElementById('mobileNavOverlay');
const mobileNav = document.getElementById('mobileNav');
const mobileCloseBtn = document.getElementById('mobileCloseBtn');
const body = document.body;

// Buka mobile menu
mobileMenuToggle.addEventListener('click', () => {
    mobileNav.classList.add('active');
    mobileNavOverlay.classList.add('active');
    body.style.overflow = 'hidden';
});

// Tutup mobile menu
function closeMobileMenu() {
    mobileNav.classList.remove('active');
    mobileNavOverlay.classList.remove('active');
    body.style.overflow = '';
}

mobileCloseBtn.addEventListener('click', closeMobileMenu);
mobileNavOverlay.addEventListener('click', closeMobileMenu);