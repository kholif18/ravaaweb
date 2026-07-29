/**
 * Admin JS – RavaaWeb
 * Light Glassmorphism Theme
 * Handles: Sidebar, Modals, Dropdowns (portal-based), Tooltips, Toasts, Header scroll, Search slide
 */
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    // ===== HEADER SCROLL EFFECT =====
    var header = document.querySelector('.admin-header');
    if (header) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 10) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }

    // ===== SIDEBAR =====
    var sidebarToggle = document.getElementById('sidebarToggle');
    var sidebar = document.getElementById('adminSidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var sidebarNav = sidebar ? sidebar.querySelector('.sidebar-nav') : null;
    var isMobile = function () { return window.innerWidth <= 768; };

    // --- LocalStorage: scroll position & collapsed state ---
    var SIDEBAR_SCROLL_KEY = 'ravaa_sidebar_scroll';
    var SIDEBAR_COLLAPSED_KEY = 'ravaa_sidebar_collapsed';

    // Restore collapsed state on desktop
    if (sidebar && !isMobile()) {
        var savedCollapsed = localStorage.getItem(SIDEBAR_COLLAPSED_KEY);
        if (savedCollapsed === 'true') {
            sidebar.classList.add('collapsed');
        }
    }

    // Restore scroll position
    if (sidebarNav) {
        var savedScroll = localStorage.getItem(SIDEBAR_SCROLL_KEY);
        if (savedScroll) {
            sidebarNav.scrollTop = parseInt(savedScroll, 10);
        }

        // Save scroll position on scroll
        sidebarNav.addEventListener('scroll', function () {
            localStorage.setItem(SIDEBAR_SCROLL_KEY, sidebarNav.scrollTop);
        });
    }

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function (e) {
            e.preventDefault();
            if (isMobile()) {
                sidebar._shown = !sidebar._shown;
                sidebar.style.left = sidebar._shown ? '0' : '';
                if (overlay) overlay.classList.toggle('active');
            } else {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem(SIDEBAR_COLLAPSED_KEY, sidebar.classList.contains('collapsed'));
            }
        });
    }

    if (overlay) {
        overlay.addEventListener('click', function () {
            sidebar.style.left = '';
            sidebar._shown = false;
            overlay.classList.remove('active');
        });
    }

    window.addEventListener('resize', function () {
        if (!isMobile() && sidebar) {
            sidebar.style.left = '';
            sidebar.style.transform = '';
            sidebar._shown = false;
            if (overlay) overlay.classList.remove('active');
        }
        closeAllDropdowns();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sidebar && sidebar._shown) {
            sidebar.style.left = '';
            sidebar._shown = false;
            if (overlay) overlay.classList.remove('active');
        }
    });

    // Helper: safely get Element target from event
    function _target(el) {
        return el && el.nodeType === 1 ? el : null;
    }

    // ===== MODALS (data-bs-toggle="modal") =====
    document.addEventListener('click', function (e) {
        var t = _target(e.target);
        if (!t) return;
        var trigger = t.closest('[data-bs-toggle="modal"]');
        if (!trigger) return;

        var targetId = trigger.getAttribute('data-bs-target');
        if (!targetId) return;

        var modal = document.querySelector(targetId);
        if (!modal) return;

        // Ensure any open dropdowns are closed before showing the modal
        closeAllDropdowns();
        showModal(modal);
    });

    // Dismiss modal (data-bs-dismiss="modal")
    document.addEventListener('click', function (e) {
        var t = _target(e.target);
        if (!t) return;
        var dismiss = t.closest('[data-bs-dismiss="modal"]');
        if (!dismiss) return;

        var modal = dismiss.closest('.modal');
        if (modal) hideModal(modal);
    });

    // Close modal on backdrop click
    document.addEventListener('click', function (e) {
        var t = _target(e.target);
        if (!t) return;
        var modal = t.closest('.modal.show');
        if (!modal) return;
        if (t === modal) hideModal(modal);
    });

    // Close modal on Escape
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        document.querySelectorAll('.modal.show').forEach(function (m) {
            hideModal(m);
        });
    });

    window.showModal = function (modal) {
        if (!modal || modal.classList.contains('show')) return;
        modal.classList.add('fade');
        modal.offsetHeight;
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        var event = new CustomEvent('shown.bs.modal', { bubbles: true });
        modal.dispatchEvent(event);
    };

    window.hideModal = function (modal) {
        if (!modal || !modal.classList.contains('show')) return;
        modal.classList.remove('show');
        setTimeout(function() {
            modal.classList.remove('fade');
        }, 200);
        document.body.style.overflow = '';
        var event = new CustomEvent('hidden.bs.modal', { bubbles: true });
        modal.dispatchEvent(event);
    };

    // Bootstrap.Modal compat
if (!window.bootstrap) window.bootstrap = {};
// Provide a fallback only if the native Bootstrap Modal class is not available
if (typeof window.bootstrap.Modal !== 'function') {
    // Simple wrapper that mimics the Bootstrap Modal constructor API
    window.bootstrap.Modal = function (el) {
        this._el = el;
    };
    window.bootstrap.Modal.prototype.show = function () { showModal(this._el); };
    window.bootstrap.Modal.prototype.hide = function () { hideModal(this._el); };
    // Also keep the getInstance helper used elsewhere in the code
    window.bootstrap.Modal.getInstance = function (el) {
        return {
            hide: function () { hideModal(el); },
            show: function () { showModal(el); }
        };
    };
}

    // ===== DROPDOWNS – PORTAL APPROACH (escape table overflow) =====
    function closeAllDropdowns() {
        document.querySelectorAll('.dropdown-portal.show').forEach(function (m) {
            m.classList.remove('show');
            // Remove after transition
            setTimeout(function() { if (m.parentNode) m.remove(); }, 150);
        });
        var backdrop = document.querySelector('.dropdown-backdrop');
        if (backdrop) backdrop.remove();
    }

    // Open a dropdown portal for a given toggle button
    function openDropdown(toggle) {
        // Find the original dropdown-menu sibling
        var dropdown = toggle.nextElementSibling;
        while (dropdown && !dropdown.classList.contains('dropdown-menu')) {
            dropdown = dropdown.nextElementSibling;
        }
        if (!dropdown) return;

        // Clone the menu content into a portal element (start hidden, no 'show')
        var portal = document.createElement('div');
        portal.className = 'dropdown-portal action-dropdown';
        portal.innerHTML = dropdown.innerHTML;

        // Make portal items interactive (close dropdown and handle modal clicks)
        portal.addEventListener('click', function (ev) {
            ev.stopPropagation();
            closeAllDropdowns();

            var item = ev.target.closest('.dropdown-item');
            if (item) {
                var modalTarget = item.getAttribute('data-bs-target');
                if (modalTarget) {
                    var modal = document.querySelector(modalTarget);
                    if (modal) showModal(modal);
                }
            }
        });

        document.body.appendChild(portal);

        // Transparent backdrop for click-outside detection
        var backdrop = document.createElement('div');
        backdrop.className = 'dropdown-backdrop';
        document.body.appendChild(backdrop);

        // Position the portal relative to the toggle button
        var rect = toggle.getBoundingClientRect();
        var menuWidth = portal.offsetWidth || 155;
        var menuHeight = portal.offsetHeight || 160;
        var winW = window.innerWidth;
        var winH = window.innerHeight;

        var top = rect.bottom + 4;
        var left = rect.left;

        // Prevent right overflow
        if (left + menuWidth > winW - 8) {
            left = Math.max(8, rect.right - menuWidth);
        }
        // Prevent bottom overflow → show above
        if (top + menuHeight > winH - 8) {
            top = Math.max(8, rect.top - menuHeight - 4);
        }
        // Safety clamp
        if (left < 8) left = 8;
        if (top < 8) top = 8;

        portal.style.top = top + 'px';
        portal.style.left = left + 'px';
        portal.style.right = 'auto';

        // Force reflow then animate in
        portal.offsetHeight;
        portal.classList.add('show');
    }

    // Toggle dropdown: close any open ones then open the requested dropdown
    function toggleDropdown(toggle) {
        closeAllDropdowns();
        openDropdown(toggle);
    }

    document.addEventListener('click', function (e) {
        var t = _target(e.target);
        if (!t) return;

            // Dropdown toggle click
            var toggle = t.closest('[data-bs-toggle="dropdown"]');
            if (toggle) {
                e.preventDefault();
                e.stopPropagation();

                toggleDropdown(toggle);
                return;
            }

        // Backdrop click → close
        if (t.classList.contains('dropdown-backdrop')) {
            closeAllDropdowns();
            return;
        }

        // Any other click → close dropdowns
        closeAllDropdowns();
    });

    // Close dropdowns on scroll
    window.addEventListener('scroll', function () {
        closeAllDropdowns();
    }, { passive: true });

    // Close dropdowns on Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeAllDropdowns();
            // Also close modals
            document.querySelectorAll('.modal.show').forEach(function (m) {
                hideModal(m);
            });
        }
    });

    // ===== HEADER SEARCH SLIDE =====
    var searchBtn = document.getElementById('headerSearchBtn');
    var searchInput = document.getElementById('headerSearchInput');

    if (searchBtn && searchInput) {
        function doSearch(query) {
            query = query.trim();
            if (query.length > 0) {
                window.location.href = '/admin/products?search=' + encodeURIComponent(query);
            }
        }

        searchBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var isOpen = searchInput.classList.contains('open');
            if (isOpen) {
                if (searchInput.value.trim()) {
                    doSearch(searchInput.value);
                } else {
                    searchInput.classList.remove('open');
                    searchInput.blur();
                }
            } else {
                searchInput.classList.add('open');
                setTimeout(function () { searchInput.focus(); }, 400);
            }
        });

        // Enter → search
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (searchInput.value.trim()) {
                    doSearch(searchInput.value);
                }
            } else if (e.key === 'Escape') {
                searchInput.classList.remove('open');
                searchInput.blur();
            }
        });

        // Close when clicking outside the wrapper
        document.addEventListener('click', function (e) {
            var wrapper = document.querySelector('.header-search-wrapper');
            if (wrapper && !wrapper.contains(e.target) && searchInput && searchInput.classList.contains('open')) {
                searchInput.classList.remove('open');
            }
        });
    }

    // ===== NOTIFICATION & USER DROPDOWN =====
    var notifBtn = document.getElementById('notificationBtn');
    var notifMenu = document.getElementById('notifMenu');
    var userToggle = document.getElementById('userDropdownToggle');
    var userMenu = document.getElementById('userMenu');

    function closeNotifDropdown() {
        if (notifMenu) notifMenu.classList.remove('show');
    }
    function closeUserDropdown() {
        if (userMenu) userMenu.classList.remove('show');
    }
    function closeAllHeaderDropdowns() {
        closeNotifDropdown();
        closeUserDropdown();
    }

    if (notifBtn && notifMenu) {
        notifBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            closeUserDropdown();
            notifMenu.classList.toggle('show');
        });
    }

    if (userToggle && userMenu) {
        userToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            closeNotifDropdown();
            userMenu.classList.toggle('show');
        });
    }

    // Document click: close dropdowns if click is outside
    document.addEventListener('click', function (e) {
        var notifDropdown = document.getElementById('notificationDropdown');
        var userDropdown = document.getElementById('userDropdown');

        if (notifMenu && notifMenu.classList.contains('show')) {
            if (notifDropdown && !notifDropdown.contains(e.target)) {
                closeNotifDropdown();
            }
        }
        if (userMenu && userMenu.classList.contains('show')) {
            if (userDropdown && !userDropdown.contains(e.target)) {
                closeUserDropdown();
            }
        }
    });

    // Close on Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeAllHeaderDropdowns();
            document.querySelectorAll('.modal.show').forEach(function (m) {
                hideModal(m);
            });
        }
    });

    // Close on scroll
    window.addEventListener('scroll', function () {
        closeAllHeaderDropdowns();
    }, { passive: true });

    // ===== TOOLTIPS (data-bs-toggle="tooltip") =====
    document.addEventListener('mouseenter', function (e) {
        var t = _target(e.target);
        if (!t) return;
        var el = t.closest('[data-bs-toggle="tooltip"]');
        if (!el) return;

        var title = el.getAttribute('title') || el.getAttribute('data-bs-original-title') || '';
        if (!title) return;

        if (!el.hasAttribute('data-bs-original-title')) {
            el.setAttribute('data-bs-original-title', title);
            el.removeAttribute('title');
        }

        if (el._tooltipEl) el._tooltipEl.remove();

        var tooltip = document.createElement('div');
        tooltip.className = 'ravaa-tooltip';
        tooltip.textContent = title;
        Object.assign(tooltip.style, {
            position: 'fixed',
            background: '#1a1d21',
            color: '#ffffff',
            padding: '0.3rem 0.55rem',
            borderRadius: '6px',
            fontSize: '0.72rem',
            fontWeight: '500',
            zIndex: '9999',
            pointerEvents: 'none',
            whiteSpace: 'nowrap',
            boxShadow: '0 4px 12px rgba(0,0,0,0.12)',
            animation: 'tooltip-in 0.15s ease'
        });
        document.body.appendChild(tooltip);

        var rect = el.getBoundingClientRect();
        tooltip.style.left = Math.max(4, Math.min(rect.left + rect.width / 2 - tooltip.offsetWidth / 2, window.innerWidth - tooltip.offsetWidth - 4)) + 'px';
        tooltip.style.top = Math.max(4, rect.top - tooltip.offsetHeight - 5) + 'px';

        el._tooltipEl = tooltip;

        el.addEventListener('mouseleave', function () {
            if (el._tooltipEl) {
                el._tooltipEl.remove();
                el._tooltipEl = null;
            }
        }, { once: true });
    });

    // Bootstrap.Tooltip compat
    window.bootstrap.Tooltip = function (el) {
        return {
            _element: el,
            dispose: function () {
                if (el._tooltipEl) {
                    el._tooltipEl.remove();
                    el._tooltipEl = null;
                }
            }
        };
    };

    // ===== TOAST NOTIFICATIONS (modern borderless) =====
    window.Ravaa = window.Ravaa || {};
    window.Ravaa.toast = function (message, type) {
        type = type || 'success';
        var container = document.getElementById('toastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.style.cssText = 'position:fixed;top:1rem;right:1rem;z-index:2000;display:flex;flex-direction:column;gap:0.5rem;';
            document.body.appendChild(container);
        }

        var icons = {
            success: '<i class="bi bi-check-circle-fill"></i>',
            error:   '<i class="bi bi-x-circle-fill"></i>',
            warning: '<i class="bi bi-exclamation-triangle-fill"></i>',
            info:    '<i class="bi bi-info-circle-fill"></i>'
        };

        var toast = document.createElement('div');
        toast.className = 'toast toast-' + type;
        toast.innerHTML = (icons[type] || icons.info) + '<span>' + message + '</span>';

        container.appendChild(toast);

        setTimeout(function () {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            toast.style.transition = 'opacity 0.3s, transform 0.3s';
            setTimeout(function () { toast.remove(); }, 300);
        }, 3500);
    };

    // ===== CONFIRM DIALOG (macOS style) =====
    window.Ravaa.confirm = function (title, text, icon) {
        return new Promise(function (resolve) {
            icon = icon || 'warning';
            // Ensure any open dropdowns are closed before showing confirm dialog
            closeAllDropdowns();
            var overlay2 = document.createElement('div');
            overlay2.style.cssText = 'position:fixed;inset:0;z-index:9998;background:rgba(0,0,0,0.25);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;padding:1rem;';

            var box = document.createElement('div');
            box.className = 'ravaa-dialog';

            var iconHtml = '';
            var iconLabels = {
                warning: { cls: 'warning', icon: 'bi-exclamation-triangle' },
                success: { cls: 'success', icon: 'bi-check-circle' },
                error:   { cls: 'error',   icon: 'bi-x-circle' },
                question:{ cls: 'question',icon: 'bi-question-circle' },
                info:    { cls: 'info',    icon: 'bi-info-circle' }
            };
            var ic = iconLabels[icon] || iconLabels.warning;
            iconHtml = '<div class="ravaa-dialog-icon ' + ic.cls + '"><i class="bi ' + ic.icon + '"></i></div>';

            // Map icon to confirm button class (semantic colors)
            var btnMap = {
                warning: 'btn-warning',
                success: 'btn-success',
                error:   'btn-danger',
                question:'btn-primary',
                info:    'btn-primary'
            };
            var btnClass = btnMap[icon] || 'btn-primary';

            box.innerHTML = iconHtml +
                '<h4 class="ravaa-dialog-title">' + (title || 'Konfirmasi') + '</h4>' +
                '<p class="ravaa-dialog-text">' + (text || '') + '</p>' +
                '<div class="ravaa-dialog-actions">' +
                '<button class="btn btn-secondary" id="ravaa-confirm-cancel">Batal</button>' +
                '<button class="btn ' + btnClass + '" id="ravaa-confirm-ok">Ya, Lanjutkan</button>' +
                '</div>';

            overlay2.appendChild(box);
            document.body.appendChild(overlay2);

            overlay2.style.opacity = '0';
            requestAnimationFrame(function() {
                overlay2.style.transition = 'opacity 0.12s ease';
                overlay2.style.opacity = '1';
            });

            function dismissConfirm(result) {
                overlay2.style.opacity = '0';
                document.removeEventListener('keydown', onKeyDown);
                setTimeout(function() { overlay2.remove(); }, 120);
                resolve(result);
            }

            function onKeyDown(e) {
                if (e.key === 'Escape') {
                    e.preventDefault();
                    dismissConfirm({ isConfirmed: false });
                }
            }
            document.addEventListener('keydown', onKeyDown);

            document.getElementById('ravaa-confirm-cancel').addEventListener('click', function () {
                dismissConfirm({ isConfirmed: false });
            });
            document.getElementById('ravaa-confirm-ok').addEventListener('click', function () {
                dismissConfirm({ isConfirmed: true });
            });
            overlay2.addEventListener('click', function (e) {
                if (e.target === overlay2) {
                    dismissConfirm({ isConfirmed: false });
                }
            });
        });
    };

    // ===== Ravaa.alert (macOS style) =====
    window.Ravaa.alert = function (title, text, icon) {
        return new Promise(function (resolve) {
            icon = icon || 'info';
            // Ensure any open dropdowns are closed before showing alert dialog
            closeAllDropdowns();
            var overlay2 = document.createElement('div');
            overlay2.style.cssText = 'position:fixed;inset:0;z-index:9998;background:rgba(0,0,0,0.25);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;padding:1rem;';

            var box = document.createElement('div');
            box.className = 'ravaa-dialog';

            var iconLabels = {
                success: { cls: 'success', icon: 'bi-check-circle' },
                error:   { cls: 'error',   icon: 'bi-x-circle' },
                warning: { cls: 'warning', icon: 'bi-exclamation-triangle' },
                info:    { cls: 'info',    icon: 'bi-info-circle' }
            };
            var ic = iconLabels[icon] || iconLabels.info;
            var iconHtml = '<div class="ravaa-dialog-icon ' + ic.cls + '"><i class="bi ' + ic.icon + '"></i></div>';

            // Map icon to OK button class (semantic colors)
            var btnMap = {
                success: 'btn-success',
                error:   'btn-danger',
                warning: 'btn-warning',
                info:    'btn-primary'
            };
            var btnClass = btnMap[icon] || 'btn-primary';

            box.innerHTML = iconHtml +
                '<h4 class="ravaa-dialog-title">' + (title || 'Informasi') + '</h4>' +
                '<p class="ravaa-dialog-text">' + (text || '') + '</p>' +
                '<div class="ravaa-dialog-actions">' +
                '<button class="btn ' + btnClass + '" id="ravaa-alert-ok">Ok, got it!</button>' +
                '</div>';

            overlay2.appendChild(box);
            document.body.appendChild(overlay2);

            overlay2.style.opacity = '0';
            requestAnimationFrame(function() {
                overlay2.style.transition = 'opacity 0.12s ease';
                overlay2.style.opacity = '1';
            });

            function dismissAlert(result) {
                overlay2.style.opacity = '0';
                document.removeEventListener('keydown', onKeyDown);
                setTimeout(function() { overlay2.remove(); }, 120);
                resolve(result);
            }

            function onKeyDown(e) {
                if (e.key === 'Escape') {
                    e.preventDefault();
                    dismissAlert({ isConfirmed: true });
                }
            }
            document.addEventListener('keydown', onKeyDown);

            document.getElementById('ravaa-alert-ok').addEventListener('click', function () {
                dismissAlert({ isConfirmed: true });
            });
            overlay2.addEventListener('click', function (e) {
                if (e.target === overlay2) {
                    dismissAlert({ isConfirmed: true });
                }
            });
        });
    };

    // ===== DELETE ITEM HELPER =====
    window.Ravaa.deleteItem = function (url, title, text) {
        title = title || 'Hapus Data';
        text = text || 'Data yang dihapus tidak dapat dikembalikan.';
        return window.Ravaa.confirm(title, text, 'error').then(function (result) {
            if (result.isConfirmed) {
                // Create a form and submit it as POST with _method=DELETE
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.style.display = 'none';
                var csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                form.appendChild(csrfInput);
                var methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    };

    // ===== PAGE TRANSITION =====
    // Smooth fade-out on sidebar navigation clicks
    document.addEventListener('click', function (e) {
        var link = e.target.closest('.sidebar-nav .nav-link');
        if (!link) return;
        // Skip external links & target="_blank"
        if (link.getAttribute('target') === '_blank') return;
        var href = link.getAttribute('href');
        if (!href || href === '#' || href.startsWith('http') || href.startsWith('//')) return;

        e.preventDefault();
        document.body.classList.add('page-leaving');
        setTimeout(function () {
            window.location.href = href;
        }, 180);
    });
});
