/**
 * Admin JS – RavaaWeb
 * Sidebar toggle, modals, dropdowns, tooltips (Bootstrap-compatible)
 */
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    // ===== SIDEBAR =====
    var sidebarToggle = document.getElementById('sidebarToggle');
    var sidebar = document.getElementById('adminSidebar');
    var overlay = document.getElementById('sidebarOverlay');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function (e) {
            e.preventDefault();
            sidebar.classList.toggle('active');
            if (overlay) overlay.classList.toggle('active');
        });
    }

    if (overlay) {
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sidebar && sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
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
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';

        // Dispatch event for Bootstrap compatibility
        var event = new CustomEvent('shown.bs.modal', { bubbles: true });
        modal.dispatchEvent(event);
    };

    window.hideModal = function (modal) {
        if (!modal || !modal.classList.contains('show')) return;
        modal.classList.remove('show');
        document.body.style.overflow = '';

        // Dispatch event
        var event = new CustomEvent('hidden.bs.modal', { bubbles: true });
        modal.dispatchEvent(event);
    };

    // Bootstrap.Modal compat (for code like bootstrap.Modal.getInstance)
    if (!window.bootstrap) window.bootstrap = {};
    window.bootstrap.Modal = {
        getInstance: function (el) {
            return {
                hide: function () { hideModal(el); },
                show: function () { showModal(el); }
            };
        }
    };

    // ===== DROPDOWNS (data-bs-toggle="dropdown") =====
    document.addEventListener('click', function (e) {
        var t = _target(e.target);
        if (!t) return;
        var toggle = t.closest('[data-bs-toggle="dropdown"]');
        if (toggle) {
            e.preventDefault();
            var dropdown = toggle.nextElementSibling;
            while (dropdown && !dropdown.classList.contains('dropdown-menu')) {
                dropdown = dropdown.nextElementSibling;
            }
            if (dropdown) {
                var isOpen = dropdown.classList.contains('show');
                // Close all other dropdowns
                document.querySelectorAll('.dropdown-menu.show').forEach(function (m) {
                    if (m !== dropdown) m.classList.remove('show');
                });
                if (!isOpen) {
                    dropdown.classList.add('show');
                    // Position
                    var rect = toggle.getBoundingClientRect();
                    dropdown.style.top = rect.bottom + 'px';
                }
            }
        } else {
            // Close dropdowns when clicking outside
            document.querySelectorAll('.dropdown-menu.show').forEach(function (m) {
                m.classList.remove('show');
            });
        }
    });

    // ===== TOOLTIPS (data-bs-toggle="tooltip") =====
    document.addEventListener('mouseenter', function (e) {
        var t = _target(e.target);
        if (!t) return;
        var el = t.closest('[data-bs-toggle="tooltip"]');
        if (!el) return;

        var title = el.getAttribute('title') || el.getAttribute('data-bs-original-title') || '';
        if (!title) return;

        // Preserve original title
        if (!el.hasAttribute('data-bs-original-title')) {
            el.setAttribute('data-bs-original-title', title);
            el.removeAttribute('title');
        }

        // Remove existing tooltip if any
        if (el._tooltipEl) el._tooltipEl.remove();

        var tooltip = document.createElement('div');
        tooltip.className = 'ravaa-tooltip';
        tooltip.textContent = title;
        document.body.appendChild(tooltip);

        var rect = el.getBoundingClientRect();
        tooltip.style.left = Math.max(4, Math.min(rect.left + rect.width / 2 - tooltip.offsetWidth / 2, window.innerWidth - tooltip.offsetWidth - 4)) + 'px';
        tooltip.style.top = Math.max(4, rect.top - tooltip.offsetHeight - 6) + 'px';

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

    // ===== TOAST NOTIFICATIONS =====
    // Ravaa.toast – global helper
    window.Ravaa = window.Ravaa || {};
    window.Ravaa.toast = function (message, type) {
        type = type || 'success';
        var container = document.getElementById('toastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.style.cssText = 'position:fixed;top:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:0.5rem;';
            document.body.appendChild(container);
        }

        var toast = document.createElement('div');
        toast.className = 'toast toast-' + type;
        toast.textContent = message;
        toast.style.cssText = 'padding:0.75rem 1rem;border-radius:0.5rem;border-left:4px solid;font-size:0.85rem;box-shadow:0 8px 24px rgba(0,0,0,0.3);animation:toast-in 0.3s ease;min-width:280px;max-width:420px;';
        if (type === 'success') { toast.style.background = 'rgba(34,197,94,0.15)'; toast.style.borderColor = '#22c55e'; toast.style.color = '#86efac'; }
        else if (type === 'error') { toast.style.background = 'rgba(239,68,68,0.15)'; toast.style.borderColor = '#ef4444'; toast.style.color = '#fca5a5'; }
        else if (type === 'warning') { toast.style.background = 'rgba(245,158,11,0.15)'; toast.style.borderColor = '#f59e0b'; toast.style.color = '#fcd34d'; }
        else if (type === 'info') { toast.style.background = 'rgba(6,182,212,0.15)'; toast.style.borderColor = '#06b6d4'; toast.style.color = '#67e8f9'; }

        container.appendChild(toast);

        setTimeout(function () {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s';
            setTimeout(function () { toast.remove(); }, 300);
        }, 3000);
    };

    // ===== SWEETALERT2-LITE CONFIRM =====
    window.Ravaa.confirm = function (title, text, icon) {
        return new Promise(function (resolve) {
            // Build a simple inline confirm dialog
            var overlay2 = document.createElement('div');
            overlay2.style.cssText = 'position:fixed;inset:0;z-index:9998;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;padding:1rem;';

            var box = document.createElement('div');
            box.style.cssText = 'background:rgba(15,23,42,0.95);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.08);border-radius:12px;padding:1.5rem;min-width:320px;max-width:440px;box-shadow:0 8px 40px rgba(0,0,0,0.4);';

            box.innerHTML = '<h4 style="margin:0 0 0.5rem;font-weight:600;color:#e2e8f0;">' + (title || 'Konfirmasi') + '</h4>' +
                '<p style="margin:0 0 1.25rem;color:#94a3b8;font-size:0.85rem;">' + (text || '') + '</p>' +
                '<div style="display:flex;justify-content:flex-end;gap:0.5rem;">' +
                '<button class="btn btn-light" id="ravaa-confirm-cancel">Batal</button>' +
                '<button class="btn btn-primary" id="ravaa-confirm-ok">Ya</button>' +
                '</div>';

            overlay2.appendChild(box);
            document.body.appendChild(overlay2);

            document.getElementById('ravaa-confirm-cancel').addEventListener('click', function () {
                overlay2.remove();
                resolve({ isConfirmed: false });
            });
            document.getElementById('ravaa-confirm-ok').addEventListener('click', function () {
                overlay2.remove();
                resolve({ isConfirmed: true });
            });
            overlay2.addEventListener('click', function (e) {
                if (e.target === overlay2) {
                    overlay2.remove();
                    resolve({ isConfirmed: false });
                }
            });
        });
    };
});
