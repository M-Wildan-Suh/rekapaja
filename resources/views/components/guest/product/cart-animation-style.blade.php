<style>
    @keyframes cart-feedback-bounce {
        0% {
            transform: scale(1);
        }
        30% {
            transform: scale(1.14) rotate(-6deg);
        }
        60% {
            transform: scale(0.96) rotate(4deg);
        }
        100% {
            transform: scale(1) rotate(0deg);
        }
    }

    @keyframes cart-feedback-badge {
        0% {
            transform: scale(1);
        }
        35% {
            transform: scale(1.24);
        }
        100% {
            transform: scale(1);
        }
    }

    @keyframes cart-feedback-glow {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0), 0 0 0 0 rgba(255, 255, 255, 0);
            filter: brightness(1);
        }
        30% {
            box-shadow: 0 0 0 6px rgba(255, 255, 255, 0.22), 0 0 28px 8px rgba(255, 255, 255, 0.28);
            filter: brightness(1.12);
        }
        65% {
            box-shadow: 0 0 0 11px rgba(255, 255, 255, 0.1), 0 0 20px 4px rgba(255, 255, 255, 0.16);
            filter: brightness(1.05);
        }
        100% {
            box-shadow: 0 0 0 14px rgba(255, 255, 255, 0), 0 0 0 0 rgba(255, 255, 255, 0);
            filter: brightness(1);
        }
    }

    .cart-feedback {
        animation: cart-feedback-bounce 0.45s cubic-bezier(0.22, 1, 0.36, 1), cart-feedback-glow 0.6s ease-out;
        transform-origin: center;
    }

    .cart-feedback-icon {
        animation: cart-feedback-bounce 0.45s cubic-bezier(0.22, 1, 0.36, 1);
        transform-origin: center;
    }

    .cart-feedback-badge {
        animation: cart-feedback-badge 0.45s cubic-bezier(0.22, 1, 0.36, 1);
        transform-origin: center;
    }
</style>
