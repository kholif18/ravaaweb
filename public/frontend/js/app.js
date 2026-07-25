document.addEventListener('DOMContentLoaded', () => {
    /* ---- Mobile Menu ---- */
    const toggle = document.getElementById('menuToggle');
    const drawer = document.getElementById('mobileDrawer');
    const overlay = document.getElementById('mobileOverlay');
    const closeBtn = document.getElementById('mobileClose');

    if (toggle && drawer && overlay) {
        const open = () => {
            drawer.classList.add('open');
            overlay.classList.add('open');
            document.body.style.overflow = 'hidden';
        };
        const close = () => {
            drawer.classList.remove('open');
            overlay.classList.remove('open');
            document.body.style.overflow = '';
        };
        toggle.addEventListener('click', open);
        if (closeBtn) closeBtn.addEventListener('click', close);
        overlay.addEventListener('click', close);
    }

    /* ---- Intersection Observer: fade-up on scroll ---- */
    const fadeElements = document.querySelectorAll('.fade-up');
    if (fadeElements.length) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
        fadeElements.forEach(el => observer.observe(el));
    }

    /* ---- Smooth parallax on hero visual ---- */
    const heroVisual = document.querySelector('.hero-visual-img');
    if (heroVisual) {
        window.addEventListener('scroll', () => {
            const scrolled = window.scrollY;
            heroVisual.style.transform = `translateY(${scrolled * 0.08}px)`;
        }, { passive: true });
    }

    /* ---- Navbar blur enhancement on scroll ---- */
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        const updateNav = () => {
            if (window.scrollY > 20) {
                navbar.style.background = 'rgba(255, 255, 255, 0.75)';
                navbar.style.backdropFilter = 'blur(60px) saturate(200%)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.55)';
                navbar.style.backdropFilter = 'blur(40px) saturate(180%)';
            }
        };
        updateNav();
        window.addEventListener('scroll', updateNav, { passive: true });
    }

    /* ---- Gallery Thumbnail Switcher ---- */
    const galleryThumbs = document.getElementById('galleryThumbs');
    const mainImg = document.getElementById('detailMainImg');
    if (galleryThumbs && mainImg) {
        const mainImgTag = mainImg.querySelector('img');
        galleryThumbs.addEventListener('click', (e) => {
            const thumb = e.target.closest('.detail-thumb');
            if (!thumb) return;
            const src = thumb.dataset.src;
            if (!src || src === mainImgTag.src) return;
            mainImgTag.src = src;
            document.querySelectorAll('#galleryThumbs .detail-thumb').forEach(t => t.classList.remove('active'));
            thumb.classList.add('active');
        });
    }

    /* ---- Detail Tab Switching ---- */
    document.querySelectorAll('.tabs-header').forEach(header => {
        header.addEventListener('click', (e) => {
            const btn = e.target.closest('.tab-btn');
            if (!btn) return;
            const tab = btn.dataset.tab;
            header.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const container = header.closest('.detail-tabs');
            container.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            document.getElementById('tab-' + tab)?.classList.add('active');
        });
    });

    /* ---- Variant Selector ---- */
    document.querySelectorAll('.variant-group').forEach(group => {
        group.addEventListener('click', (e) => {
            const btn = e.target.closest('.variant-btn');
            if (!btn) return;
            group.querySelectorAll('.variant-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });

    /* ---- Catalog Filter Pills ---- */
    const catalogForm = document.getElementById('catalogForm');
    if (catalogForm) {
        const inputCategory = document.getElementById('inputCategory');
        const inputType = document.getElementById('inputType');

        document.querySelectorAll('.filter-pill').forEach(pill => {
            pill.addEventListener('click', () => {
                const category = pill.dataset.category;
                const type = pill.dataset.type;

                if (category !== undefined) {
                    inputCategory.value = category;
                    document.querySelectorAll('#categoryPills .filter-pill').forEach(p => p.classList.remove('active'));
                    pill.classList.add('active');
                }

                if (type !== undefined) {
                    inputType.value = type;
                    document.querySelectorAll('.type-pills .filter-pill').forEach(p => p.classList.remove('active'));
                    pill.classList.add('active');
                }

                catalogForm.submit();
            });
        });
    }

    /* ---- Hero Slider (legacy) ---- */
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-dot');
    if (slides.length > 0) {
        let currentSlide = 0;
        let slideInterval;

        window.goToSlide = function(index) {
            if (index < 0 || index >= slides.length) return;
            slides[currentSlide].classList.remove('active');
            if (dots.length > currentSlide) dots[currentSlide].classList.remove('active');
            currentSlide = index;
            slides[currentSlide].classList.add('active');
            if (dots.length > currentSlide) dots[currentSlide].classList.add('active');
            resetInterval();
        };

        window.changeSlide = function(dir) {
            let next = currentSlide + dir;
            if (next >= slides.length) next = 0;
            if (next < 0) next = slides.length - 1;
            window.goToSlide(next);
        };

        function resetInterval() {
            clearInterval(slideInterval);
            slideInterval = setInterval(() => window.changeSlide(1), 5000);
        }

        if (slides.length > 1) {
            resetInterval();
        }
    }

    /* ---- Banner Carousel (Refactored & Performance Optimized) ---- */
    const bannerCarousel = document.getElementById('bannerCarousel');
    const bannerTrack = document.getElementById('bannerTrack');
    if (bannerCarousel && bannerTrack) {
        const bannerSlides = bannerTrack.querySelectorAll('.banner-slide');
        const bannerDots = bannerCarousel.querySelectorAll('.banner-dot');
        const prevBtn = bannerCarousel.querySelector('.banner-prev');
        const nextBtn = bannerCarousel.querySelector('.banner-next');
        const totalSlides = bannerSlides.length;
        let currentBanner = 0;
        let bannerInterval = null;
        let touchStartX = 0;
        let touchDeltaX = 0;
        let isSwiping = false;

        function setTrackTransform(percent) {
            requestAnimationFrame(() => {
                bannerTrack.style.transform = `translateX(${percent}%)`;
            });
        }

        function goToBanner(index) {
            if (index < 0 || index >= totalSlides) return;
            bannerSlides[currentBanner].classList.remove('active');
            if (bannerDots[currentBanner]) bannerDots[currentBanner].classList.remove('active');

            currentBanner = index;
            setTrackTransform(-currentBanner * 100);

            bannerSlides[currentBanner].classList.add('active');
            if (bannerDots[currentBanner]) bannerDots[currentBanner].classList.add('active');
        }

        function changeBanner(dir) {
            let next = currentBanner + dir;
            if (next >= totalSlides) next = 0;
            if (next < 0) next = totalSlides - 1;
            goToBanner(next);
        }

        function resetBannerInterval() {
            clearInterval(bannerInterval);
            if (totalSlides > 1) {
                bannerInterval = setInterval(() => changeBanner(1), 5000);
            }
        }

        // Navigation buttons
        if (prevBtn) prevBtn.addEventListener('click', (e) => { e.preventDefault(); changeBanner(-1); resetBannerInterval(); });
        if (nextBtn) nextBtn.addEventListener('click', (e) => { e.preventDefault(); changeBanner(1); resetBannerInterval(); });

        // Dot clicks
        bannerDots.forEach(dot => {
            dot.addEventListener('click', (e) => {
                e.preventDefault();
                goToBanner(parseInt(dot.dataset.index, 10));
                resetBannerInterval();
            });
        });

        // Touch swipe handling
        bannerTrack.addEventListener('touchstart', (e) => {
            if (totalSlides <= 1) return;
            touchStartX = e.touches[0].clientX;
            isSwiping = true;
            bannerTrack.style.transition = 'none';
        }, { passive: true });

        bannerTrack.addEventListener('touchmove', (e) => {
            if (!isSwiping || totalSlides <= 1) return;
            touchDeltaX = e.touches[0].clientX - touchStartX;
            const trackWidth = bannerTrack.offsetWidth || 1;
            const offset = -(currentBanner * 100) + (touchDeltaX / trackWidth * 100);
            setTrackTransform(offset);
        }, { passive: true });

        bannerTrack.addEventListener('touchend', () => {
            if (!isSwiping || totalSlides <= 1) return;
            isSwiping = false;
            bannerTrack.style.transition = 'transform .55s cubic-bezier(0.25, 1, 0.5, 1)';
            const trackWidth = bannerTrack.offsetWidth || 1;
            const threshold = trackWidth * 0.15;
            if (touchDeltaX < -threshold) {
                changeBanner(1);
            } else if (touchDeltaX > threshold) {
                changeBanner(-1);
            } else {
                goToBanner(currentBanner);
            }
            touchDeltaX = 0;
            resetBannerInterval();
        });

        // Pause on hover (desktop)
        bannerCarousel.addEventListener('mouseenter', () => clearInterval(bannerInterval));
        bannerCarousel.addEventListener('mouseleave', resetBannerInterval);

        // Initial setup
        resetBannerInterval();
    }
});
