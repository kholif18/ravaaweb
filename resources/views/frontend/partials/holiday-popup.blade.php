@php
    $popupEnabled = ($settings['holiday_popup_enabled'] ?? '0') === '1';
    $startDate = $settings['holiday_start_date'] ?? null;
    $endDate = $settings['holiday_end_date'] ?? null;
    $today = now()->format('Y-m-d');

    $showPopup = $popupEnabled
        && $startDate
        && $endDate
        && $today >= $startDate
        && $today <= $endDate;
@endphp

@if($showPopup)
<div id="holidayPopup" class="holiday-popup-overlay" style="display: none;">
    <div class="holiday-popup-modal">
        {{-- Close button (top-right) --}}
        <button class="holiday-popup-close" id="holidayPopupClose" aria-label="Tutup">
            <i class="fas fa-times"></i>
        </button>

        <div class="holiday-popup-body">
            @if(!empty($settings['holiday_title']))
            <div class="holiday-popup-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h2 class="holiday-popup-title">{{ $settings['holiday_title'] }}</h2>
            @endif

            <div class="holiday-popup-content">
                {!! $settings['holiday_content'] ?? '' !!}
            </div>

            @if($startDate && $endDate)
            <div class="holiday-popup-dates">
                <i class="fas fa-clock"></i>
                {{ \Carbon\Carbon::parse($startDate)->isoFormat('DD MMM YYYY') }}
                &mdash;
                {{ \Carbon\Carbon::parse($endDate)->isoFormat('DD MMM YYYY') }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.holiday-popup-overlay {
    position: fixed;
    inset: 0;
    z-index: 99999;
    background: rgba(0, 0, 0, 0.55);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    animation: holidayFadeIn 0.3s ease-out;
}

@keyframes holidayFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.holiday-popup-modal {
    position: relative;
    background: linear-gradient(145deg, rgba(255,255,255,0.98), rgba(250,250,255,0.98));
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 20px;
    max-width: 640px;
    width: 100%;
    max-height: 85vh;
    overflow-y: auto;
    box-shadow: 0 32px 64px rgba(0,0,0,0.25), 0 8px 24px rgba(0,0,0,0.12);
    animation: holidayModalIn 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes holidayModalIn {
    from {
        opacity: 0;
        transform: scale(0.92) translateY(16px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.holiday-popup-close {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    background: rgba(0,0,0,0.06);
    color: #666;
    font-size: 1.1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    z-index: 2;
}

.holiday-popup-close:hover {
    background: rgba(0,0,0,0.12);
    color: #111;
    transform: rotate(90deg);
}

.holiday-popup-body {
    padding: 40px 36px 36px;
    text-align: center;
}

.holiday-popup-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 16px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #fff;
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
}

.holiday-popup-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e1b4b;
    margin-bottom: 16px;
    line-height: 1.3;
}

.holiday-popup-content {
    font-size: 1rem;
    line-height: 1.7;
    color: #444;
    margin-bottom: 20px;
}

.holiday-popup-content p {
    margin-bottom: 12px;
}

.holiday-popup-content ul,
.holiday-popup-content ol {
    text-align: left;
    display: inline-block;
    margin: 8px auto;
}

.holiday-popup-dates {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 20px;
    background: rgba(99, 102, 241, 0.08);
    border-radius: 100px;
    font-size: 0.9rem;
    font-weight: 500;
    color: #6366f1;
}

@media (max-width: 576px) {
    .holiday-popup-body {
        padding: 32px 20px 28px;
    }
    .holiday-popup-title {
        font-size: 1.25rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var popup = document.getElementById('holidayPopup');
    var closeBtn = document.getElementById('holidayPopupClose');

    // Cek localStorage agar hanya muncul sekali
    if (!localStorage.getItem('holiday_popup_dismissed')) {
        popup.style.display = 'flex';
    }

    function dismissPopup() {
        localStorage.setItem('holiday_popup_dismissed', '1');
        popup.style.opacity = '0';
        popup.style.transition = 'opacity 0.3s ease';
        setTimeout(function() {
            popup.style.display = 'none';
        }, 300);
    }

    closeBtn.addEventListener('click', dismissPopup);

    // Klik overlay (di luar modal) tutup popup
    popup.addEventListener('click', function(e) {
        if (e.target === popup) {
            dismissPopup();
        }
    });

    // Escape key tutup popup
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && popup.style.display === 'flex') {
            dismissPopup();
        }
    });
});
</script>
@endif
