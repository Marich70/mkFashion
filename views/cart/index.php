<?php
// Vérifier que les variables existent
if (!isset($cartItems)) {
    $cartItems = [];
    $total = 0;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon panier - MK Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: all 0.3s;
        }

        .nav-links a:hover {
            color: #667eea;
        }

        .cart-icon {
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -10px;
            right: -15px;
            background: #e74c3c;
            color: white;
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 50%;
            min-width: 18px;
            text-align: center;
        }

        .btn-logout {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 6px 16px;
            border-radius: 30px;
        }

        .cart-container {
            max-width: 1300px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .cart-header {
            margin-bottom: 40px;
        }

        .cart-header h1 {
            font-size: 2.5rem;
            color: #1a1a2e;
            font-weight: 700;
        }

        .cart-header p {
            color: #666;
            margin-top: 8px;
        }

        .cart-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 30px;
        }

        /* CART ITEMS */
        .cart-items {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .cart-item {
            display: grid;
            grid-template-columns: auto 1fr auto auto auto;
            align-items: center;
            gap: 20px;
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.3s;
        }

        .cart-item:hover {
            background: #f8f9fa;
        }

        .cart-item-image img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 15px;
        }

        .cart-item-info h3 {
            font-size: 1.1rem;
            margin-bottom: 8px;
            color: #333;
        }

        .cart-item-info .item-ref {
            font-size: 0.75rem;
            color: #999;
        }

        .cart-item-price {
            font-weight: 700;
            color: #667eea;
            font-size: 1.1rem;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-btn {
            width: 35px;
            height: 35px;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1.2rem;
        }

        .quantity-btn:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            padding: 8px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
        }

        .cart-item-total {
            font-weight: 800;
            font-size: 1.2rem;
            color: #333;
        }

        .cart-item-remove {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: #e74c3c;
            transition: transform 0.3s;
        }

        .cart-item-remove:hover {
            transform: scale(1.1);
        }

        /* ORDER SUMMARY */
        .order-summary {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .order-summary h3 {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .summary-row.total {
            border-top: 2px solid #f0f0f0;
            border-bottom: none;
            margin-top: 15px;
            padding-top: 20px;
            font-size: 1.2rem;
            font-weight: 800;
        }

        .summary-row.total span:last-child {
            color: #667eea;
            font-size: 1.5rem;
        }

        .promo-code {
            margin: 20px 0;
            display: flex;
            gap: 10px;
        }

        .promo-code input {
            flex: 1;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
        }

        .promo-code button {
            padding: 12px 20px;
            background: #f0f0f0;
            border: none;
            border-radius: 12px;
            cursor: pointer;
        }

        .btn-checkout {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 20px;
        }

        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(39,174,96,0.3);
        }

        .btn-continue {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #667eea;
            text-decoration: none;
        }

        .empty-cart {
            text-align: center;
            padding: 80px;
            background: white;
            border-radius: 20px;
        }

        .empty-cart i {
            font-size: 5rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-cart h3 {
            margin-bottom: 15px;
        }

        .toast-notification {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 15px 25px;
            border-radius: 12px;
            z-index: 9999;
            animation: slideInRight 0.3s ease;
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        footer {
            background: #1a1a2e;
            color: #999;
            text-align: center;
            padding: 40px;
            margin-top: 60px;
        }

        @media (max-width: 968px) {
            .cart-grid {
                grid-template-columns: 1fr;
            }
            .cart-item {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 15px;
            }
            .cart-item-image {
                justify-self: center;
            }
            .cart-item-quantity {
                justify-self: center;
            }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <div class="logo">🔥 MK FASHION</div>
        <div class="nav-links">
            <a href="/mkFashion/public/">Accueil</a>
            <a href="/mkFashion/public/cart/index" class="cart-icon">
                🛒 Panier
                <span id="cart-count" class="cart-count"><?= count($cartItems) ?></span>
            </a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/mkFashion/public/account/orders">📦 Mes commandes</a>
                <div class="user-menu">
                    <span>👋 <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                        <a href="/mkFashion/public/admin">👑 Admin</a>
                    <?php endif; ?>
                    <a href="/mkFashion/public/auth/logout" class="btn-logout">Déconnexion</a>
                </div>
            <?php else: ?>
                <a href="/mkFashion/public/auth/loginForm">Connexion</a>
                <a href="/mkFashion/public/auth/registerForm">Inscription</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="cart-container">
    <div class="cart-header">
        <h1>🛒 Mon panier</h1>
        <p>Vérifiez vos articles et passez à la caisse</p>
    </div>

    <?php if (isset($_SESSION['cart_success'])): ?>
        <div class="toast-notification" id="successToast">✅ <?= $_SESSION['cart_success'] ?></div>
        <?php unset($_SESSION['cart_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['cart_error'])): ?>
        <div class="toast-notification" style="background: #e74c3c;" id="errorToast">❌ <?= $_SESSION['cart_error'] ?></div>
        <?php unset($_SESSION['cart_error']); ?>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h3>Votre panier est vide</h3>
            <p style="margin-bottom: 20px;">Ajoutez des produits à votre panier pour continuer</p>
            <a href="/mkFashion/public/" class="btn-checkout" style="width: auto; padding: 12px 30px;">🛍️ Découvrir nos produits</a>
        </div>
    <?php else: ?>
        <div class="cart-grid">
            <!-- CART ITEMS -->
            <div class="cart-items">
                <?php foreach ($cartItems as $item): ?>
                    <div class="cart-item" id="cart-item-<?= $item['id'] ?>">
                        <div class="cart-item-image">
                            <img src="<?= $item['image_url'] ?>" alt="<?= $item['name'] ?>">
                        </div>
                        <div class="cart-item-info">
                            <h3><?= htmlspecialchars($item['name']) ?></h3>
                            <div class="item-ref">Réf: MK-<?= str_pad($item['product_id'], 5, '0', STR_PAD_LEFT) ?></div>
                            <div class="item-stock" style="font-size: 0.75rem; color: <?= $item['stock'] < 10 ? '#e74c3c' : '#27ae60' ?>">
                                <?= $item['stock'] > 0 ? '✅ En stock (' . $item['stock'] . ')' : '❌ Rupture' ?>
                            </div>
                        </div>
                        <div class="cart-item-price">
                            <?= number_format($item['price'], 2) ?> FCFA
                        </div>
                        <div class="cart-item-quantity">
                            <button class="quantity-btn" onclick="updateQuantity(<?= $item['id'] ?>, <?= $item['quantity'] - 1 ?>, <?= $item['stock'] ?>)">-</button>
                            <input type="number" id="qty-<?= $item['id'] ?>" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>" class="quantity-input" readonly>
                            <button class="quantity-btn" onclick="updateQuantity(<?= $item['id'] ?>, <?= $item['quantity'] + 1 ?>, <?= $item['stock'] ?>)">+</button>
                        </div>
                        <div class="cart-item-total" id="total-<?= $item['id'] ?>">
                            <?= number_format($item['price'] * $item['quantity'], 2) ?> FCFA
                        </div>
                        <button class="cart-item-remove" onclick="removeItem(<?= $item['id'] ?>)">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- ORDER SUMMARY -->
            <div class="order-summary">
                <h3>📋 Récapitulatif</h3>
                <div class="summary-row">
                    <span>Sous-total</span>
                    <span id="subtotal"><?= number_format($total, 2) ?> FCFA</span>
                </div>
                <div class="summary-row">
                    <span>Livraison</span>
                    <span>Offerte</span>
                </div>
                <div class="promo-code">
                    <input type="text" placeholder="Code promo" id="promoCode">
                    <button onclick="applyPromo()">Appliquer</button>
                </div>
                <div class="summary-row total">
                    <span>Total TTC</span>
                    <span id="grandTotal"><?= number_format($total, 2) ?> FCFA</span>
                </div>
                <a href="/mkFashion/public/order/checkout" class="btn-checkout">
                    ✅ Valider ma commande
                </a>
                <a href="/mkFashion/public/" class="btn-continue">
                    <i class="fas fa-arrow-left"></i> Continuer mes achats
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; 2024 MK Fashion - Tous droits réservés</p>
</footer>

<script>
function updateQuantity(cartId, newQty, maxStock) {
    if (newQty < 1) {
        removeItem(cartId);
        return;
    }
    if (newQty > maxStock) {
        showToast('Stock insuffisant !', 'error');
        return;
    }
    
    fetch('/mkFashion/public/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `cart_id=${cartId}&quantity=${newQty}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function removeItem(cartId) {
    if (confirm('Supprimer cet article du panier ?')) {
        fetch('/mkFashion/public/cart/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `cart_id=${cartId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function applyPromo() {
    const code = document.getElementById('promoCode').value;
    if (code === 'PROMO10') {
        let total = <?= $total ?>;
        let newTotal = total * 0.9;
        document.getElementById('subtotal').innerHTML = newTotal.toFixed(2) + ' FCFA';
        document.getElementById('grandTotal').innerHTML = newTotal.toFixed(2) + ' FCFA';
        showToast('Code promo appliqué ! -10%', 'success');
    } else if (code === 'FREESHIP') {
        showToast('Livraison offerte déjà appliquée', 'success');
    } else {
        showToast('Code promo invalide', 'error');
    }
}

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    if (type === 'error') toast.style.background = '#e74c3c';
    toast.innerHTML = type === 'success' ? `✅ ${message}` : `❌ ${message}`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// Supprimer les toasts automatiquement après 3 secondes
setTimeout(() => {
    const toast = document.getElementById('successToast') || document.getElementById('errorToast');
    if (toast) toast.remove();
}, 3000);
</script>
</body>
</html>