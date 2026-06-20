@php
    $toastTypes = [
        'success' => [
            'message' => session('success'),
            'color' => '#27ae60',
        ],
        'error' => [
            'message' => session('error'),
            'color' => '#e74c3c',
        ],
        'warning' => [
            'message' => session('warning'),
            'color' => '#f39c12',
        ],
        'info' => [
            'message' => session('info'),
            'color' => '#3490dc',
        ],
    ];

    $toasts = collect($toastTypes)->filter(fn ($toast) => filled($toast['message']));
@endphp

<style>
    #toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 99999;
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: min(380px, calc(100vw - 40px));
        pointer-events: none;
    }

    .quick-toast {
        width: 100%;
        min-width: 340px;
        background: #ffffff;
        color: #333;
        border-left: 5px solid var(--toast-color, #3490dc);
        border-radius: 12px;
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.16);
        overflow: hidden;
        pointer-events: auto;
        animation: quickToastSlideIn 0.35s ease forwards;
    }

    .quick-toast.is-hiding {
        animation: quickToastFadeOut 0.3s ease forwards;
    }

    .quick-toast-header {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f8f9fa;
        padding: 12px 14px;
        border-bottom: 1px solid #eceff1;
    }

    .quick-toast-title {
        color: var(--toast-color, #3490dc);
        font-weight: 700;
        font-size: 14px;
        line-height: 1.2;
        margin-right: auto;
    }

    .quick-toast-time {
        color: #777;
        font-size: 12px;
        white-space: nowrap;
    }

    .quick-toast-close {
        border: none;
        background: transparent;
        color: #555;
        cursor: pointer;
        font-size: 20px;
        line-height: 1;
        padding: 0 2px;
    }

    .quick-toast-close:hover {
        color: #222;
    }

    .quick-toast-body {
        padding: 14px;
        font-size: 14px;
        line-height: 1.5;
        background: #ffffff;
    }

    @media (max-width: 420px) {
        #toast-container {
            right: 12px;
            left: 12px;
            width: auto;
        }

        .quick-toast {
            min-width: 0;
        }
    }

    @keyframes quickToastSlideIn {
        from {
            opacity: 0;
            transform: translateX(32px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes quickToastFadeOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }

        to {
            opacity: 0;
            transform: translateX(32px);
        }
    }
</style>

<div id="toast-container" aria-live="polite" aria-atomic="true">
    @foreach($toasts as $toast)
        <div class="quick-toast" style="--toast-color: {{ $toast['color'] }};">
            <div class="quick-toast-header">
                <strong class="quick-toast-title">Quick Alert!</strong>
                <span class="quick-toast-time">just now</span>
                <button type="button" class="quick-toast-close" aria-label="Close">&times;</button>
            </div>
            <div class="quick-toast-body">
                {{ $toast['message'] }}
            </div>
        </div>
    @endforeach
</div>

<script>
    (() => {
        const container = document.getElementById('toast-container');

        if (!container) {
            return;
        }

        const closeToast = (toast) => {
            if (!toast || toast.classList.contains('is-hiding')) {
                return;
            }

            toast.classList.add('is-hiding');

            setTimeout(() => {
                toast.remove();
            }, 300);
        };

        const activateToast = (toast) => {
            const closeButton = toast.querySelector('.quick-toast-close');

            if (closeButton) {
                closeButton.addEventListener('click', () => closeToast(toast));
            }

            setTimeout(() => closeToast(toast), 4000);
        };

        window.showQuickToast = ({ message, color = '#3490dc' }) => {
            const toast = document.createElement('div');
            toast.className = 'quick-toast';
            toast.style.setProperty('--toast-color', color);
            toast.innerHTML = `
                <div class="quick-toast-header">
                    <strong class="quick-toast-title">Quick Alert!</strong>
                    <span class="quick-toast-time">just now</span>
                    <button type="button" class="quick-toast-close" aria-label="Close">&times;</button>
                </div>
                <div class="quick-toast-body"></div>
            `;

            toast.querySelector('.quick-toast-body').textContent = message;
            container.prepend(toast);
            activateToast(toast);
        };

        container.querySelectorAll('.quick-toast').forEach(activateToast);
    })();
</script>
