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

    /* ---- Smooth parallax on hero visual (throttled via rAF) ---- */
    const heroVisual = document.querySelector('.hero-visual-img');
    if (heroVisual) {
        let heroRafId = null;
        window.addEventListener('scroll', () => {
            if (heroRafId) return;
            heroRafId = requestAnimationFrame(() => {
                heroVisual.style.transform = `translateY(${window.scrollY * 0.08}px)`;
                heroRafId = null;
            });
        }, { passive: true });
    }

    /* ---- Navbar scrolled state via CSS class (no inline style repaint) ---- */
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        let navRafId = null;
        const updateNav = () => {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        };
        updateNav();
        window.addEventListener('scroll', () => {
            if (navRafId) return;
            navRafId = requestAnimationFrame(() => {
                updateNav();
                navRafId = null;
            });
        }, { passive: true });
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

    /* ---- Banner Carousel (Seamless Infinite Clone Loop) ---- */
    const bannerCarousel = document.getElementById('bannerCarousel');
    const bannerTrack = document.getElementById('bannerTrack');
    if (bannerCarousel && bannerTrack) {
        const originalSlides = Array.from(bannerTrack.querySelectorAll('.banner-slide'));
        const bannerDots = Array.from(bannerCarousel.querySelectorAll('.banner-dot'));
        const prevBtn = bannerCarousel.querySelector('.banner-prev');
        const nextBtn = bannerCarousel.querySelector('.banner-next');
        const count = originalSlides.length;

        if (count > 1) {
            // Clone first and last slide for infinite seamless loop
            const firstClone = originalSlides[0].cloneNode(true);
            const lastClone = originalSlides[count - 1].cloneNode(true);
            firstClone.classList.remove('active');
            lastClone.classList.remove('active');

            bannerTrack.appendChild(firstClone);
            bannerTrack.insertBefore(lastClone, originalSlides[0]);

            let domIndex = 1; // Start at first real slide (index 1 in track)
            let isTransitioning = false;
            let bannerInterval = null;
            let touchStartX = 0;
            let touchDeltaX = 0;
            let isSwiping = false;

            const transitionStyle = 'transform .55s cubic-bezier(0.25, 1, 0.5, 1)';

            // Set initial track position to real slide 1
            bannerTrack.style.transition = 'none';
            bannerTrack.style.transform = 'translateX(-100%)';
            bannerTrack.offsetHeight; // Force reflow
            bannerTrack.style.transition = transitionStyle;

            function updateDots(realIndex) {
                bannerDots.forEach((dot, idx) => {
                    dot.classList.toggle('active', idx === realIndex);
                });
            }

            function getRealIndex(dIndex) {
                if (dIndex === 0) return count - 1;
                if (dIndex === count + 1) return 0;
                return dIndex - 1;
            }

            function setTrackTransform(percent) {
                requestAnimationFrame(() => {
                    bannerTrack.style.transform = `translateX(${percent}%)`;
                });
            }

            function goToDomIndex(targetIndex) {
                if (isTransitioning) return;
                isTransitioning = true;
                domIndex = targetIndex;
                bannerTrack.style.transition = transitionStyle;
                setTrackTransform(-domIndex * 100);
                updateDots(getRealIndex(domIndex));
            }

            function nextSlide() {
                goToDomIndex(domIndex + 1);
            }

            function prevSlide() {
                goToDomIndex(domIndex - 1);
            }

            // Handle seamless jump after clone transition ends
            bannerTrack.addEventListener('transitionend', (e) => {
                if (e.target !== bannerTrack) return;
                isTransitioning = false;

                if (domIndex === count + 1) {
                    // Reached end clone -> jump to real first slide instantly
                    bannerTrack.style.transition = 'none';
                    domIndex = 1;
                    bannerTrack.style.transform = 'translateX(-100%)';
                    bannerTrack.offsetHeight; // Force reflow
                } else if (domIndex === 0) {
                    // Reached start clone -> jump to real last slide instantly
                    bannerTrack.style.transition = 'none';
                    domIndex = count;
                    bannerTrack.style.transform = `translateX(-${count * 100}%)`;
                    bannerTrack.offsetHeight; // Force reflow
                }
            });

            function startAutoPlay() {
                stopAutoPlay();
                bannerInterval = setInterval(nextSlide, 5000);
            }

            function stopAutoPlay() {
                if (bannerInterval) clearInterval(bannerInterval);
            }

            // Controls
            if (prevBtn) {
                prevBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    prevSlide();
                    startAutoPlay();
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    nextSlide();
                    startAutoPlay();
                });
            }

            bannerDots.forEach((dot) => {
                dot.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetReal = parseInt(dot.dataset.index, 10);
                    goToDomIndex(targetReal + 1);
                    startAutoPlay();
                });
            });

            // Touch Swipe
            bannerTrack.addEventListener('touchstart', (e) => {
                if (isTransitioning) return;
                touchStartX = e.touches[0].clientX;
                isSwiping = true;
                bannerTrack.style.transition = 'none';
                stopAutoPlay();
            }, { passive: true });

            bannerTrack.addEventListener('touchmove', (e) => {
                if (!isSwiping) return;
                touchDeltaX = e.touches[0].clientX - touchStartX;
                const trackWidth = bannerTrack.offsetWidth || 1;
                const offset = -(domIndex * 100) + (touchDeltaX / trackWidth * 100);
                setTrackTransform(offset);
            }, { passive: true });

            bannerTrack.addEventListener('touchend', () => {
                if (!isSwiping) return;
                isSwiping = false;
                bannerTrack.style.transition = transitionStyle;
                const trackWidth = bannerTrack.offsetWidth || 1;
                const threshold = trackWidth * 0.15;

                if (touchDeltaX < -threshold) {
                    nextSlide();
                } else if (touchDeltaX > threshold) {
                    prevSlide();
                } else {
                    goToDomIndex(domIndex);
                }
                touchDeltaX = 0;
                startAutoPlay();
            });

            // Pause on hover
            bannerCarousel.addEventListener('mouseenter', stopAutoPlay);
            bannerCarousel.addEventListener('mouseleave', startAutoPlay);

            // Start auto play
            startAutoPlay();
        }
    }
});
