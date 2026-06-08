// ===== PANIER AJAX =====
document.addEventListener('DOMContentLoaded', function () {

    // Récupérer et afficher le compteur panier au chargement
    updateCartCount();

    // Ajouter au panier sans refresh
    const addToCartForms = document.querySelectorAll('.add-to-cart-ajax');
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/mkFashion/public/cart/add', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                        updateCartCount();
                        animateCartIcon();
                    } else {
                        showToast(data.error, 'error');
                    }
                })
                .catch(error => {
                    showToast('Erreur lors de l\'ajout', 'error');
                });
        });
    });

    // Mettre à jour quantité panier
    const quantityInputs = document.querySelectorAll('.cart-quantity');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function () {
            const cartId = this.dataset.cartId;
            const quantity = this.value;

            fetch('/mkFashion/public/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `cart_id=${cartId}&quantity=${quantity}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Recharge pour mettre à jour les totaux
                    }
                });
        });
    });
});

// Mettre à jour le compteur panier
function updateCartCount() {
    fetch('/mkFashion/public/cart/getCount', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            const cartCountElement = document.getElementById('cart-count');
            if (cartCountElement) {
                const count = data.count || 0;
                cartCountElement.textContent = count;
                cartCountElement.style.display = count > 0 ? 'inline-block' : 'none';
            }
        });
}

// Animer l'icône panier
function animateCartIcon() {
    const cartIcon = document.querySelector('.cart-icon');
    if (cartIcon) {
        cartIcon.classList.add('animate');
        setTimeout(() => {
            cartIcon.classList.remove('animate');
        }, 300);
    }
}

// Afficher une notification toast
function showToast(message, type = 'success') {
    // Supprimer les anciens toasts
    const oldToast = document.querySelector('.toast-notification');
    if (oldToast) oldToast.remove();

    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    toast.innerHTML = `
        <span>${type === 'success' ? '✅' : '❌'}</span>
        <span>${message}</span>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// Afficher modal de confirmation commande
function showOrderModal(total, itemsCount) {
    const modal = document.getElementById('orderModal');
    const modalTotal = document.getElementById('modalTotal');
    const modalItems = document.getElementById('modalItems');

    if (modal && modalTotal && modalItems) {
        modalTotal.textContent = total + ' €';
        modalItems.textContent = itemsCount;
        modal.classList.add('active');
    }
}

function closeModal() {
    const modal = document.getElementById('orderModal');
    if (modal) modal.classList.remove('active');
}

function confirmOrder() {
    window.location.href = '/mkFashion/public/order/checkout';
}