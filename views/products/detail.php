<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> - MK Fashion</title>
    <link rel="stylesheet" href="/mkFashion/public/css/style.css">
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
            background: #f8f9fa;
        }
        
        .navbar {
            background: rgba(255,255,255,0.98);
            backdrop-filter: blur(10px);
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
        }
        
        .user-menu {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .btn-logout {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 6px 16px;
            border-radius: 30px;
            text-decoration: none;
        }
        
        /* ===== PRODUCT DETAIL LUXE ===== */
        .product-detail {
            max-width: 1400px;
            margin: 60px auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            padding: 40px;
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.08);
        }
        
        .product-gallery {
            position: relative;
        }
        
        .product-gallery img {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .product-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #27ae60;
            color: white;
            padding: 8px 18px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .product-info h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #1a1a2e;
            font-weight: 800;
        }
        
        .product-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .stars {
            color: #f39c12;
            letter-spacing: 2px;
        }
        
        .product-description {
            color: #555;
            line-height: 1.7;
            margin: 25px 0;
            font-size: 1rem;
        }
        
        .product-price {
            font-size: 2.5rem;
            color: #667eea;
            font-weight: 800;
            margin: 20px 0;
        }
        
        .product-stock {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            margin: 15px 0;
        }
        
        .stock-instock {
            background: #d4edda;
            color: #155724;
        }
        
        .stock-low {
            background: #fff3cd;
            color: #856404;
        }
        
        .stock-out {
            background: #f8d7da;
            color: #721c24;
        }
        
        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 30px 0;
        }
        
        .quantity-input {
            width: 80px;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1rem;
            text-align: center;
        }
        
        .add-to-cart {
            padding: 15px 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 40px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .add-to-cart:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 25px rgba(102,126,234,0.4);
        }
        
        .product-meta {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #eee;
            display: flex;
            gap: 30px;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #666;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 30px;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .toast-notification {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 15px 25px;
            border-radius: 12px;
            animation: slideInRight 0.3s ease;
            z-index: 9999;
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
            .product-detail {
                grid-template-columns: 1fr;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-container">
        <div class="logo">🔥 MK FASHION</div>
        <div class="nav-links">
            <a href="/mkFashion/public/">Accueil</a>
            <a href="/mkFashion/public/cart/index" class="cart-icon">
                🛒 Panier
                <span id="cart-count" class="cart-count" style="display: none;">0</span>
            </a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/mkFashion/public/account/orders">📦 Mes commandes</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-menu">
                    <span>👋 <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                        <a href="/mkFashion/public/admin">👑 Admin</a>
                    <?php endif; ?>
                    <a href="/mkFashion/public/auth/logout" class="btn-logout">Déconnexion</a>
                </div>
            <?php else: ?>
                <a href="/mkFashion/public/auth/loginForm">Connexion</a>
                <a href="/mkFashion/public/auth/registerForm" class="btn-inscription">Inscription</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- PRODUCT DETAIL -->
<div class="product-detail">
    <div class="product-gallery">
        <?php if ($product['stock'] > 0 && $product['stock'] < 10): ?>
            <div class="product-badge">⚠️ Plus que <?= $product['stock'] ?> en stock</div>
        <?php elseif ($product['stock'] <= 0): ?>
            <div class="product-badge" style="background: #e74c3c;">Épuisé</div>
        <?php endif; ?>
        <img src="<?= $product['image_url'] ?>" alt="<?= $product['name'] ?>">
    </div>
    
    <div class="product-info">
        <div class="product-rating">
            <div class="stars">★★★★★</div>
            <span>(128 avis)</span>
        </div>
        
        <h1><?= htmlspecialchars($product['name']) ?></h1>
        
        <div class="product-description">
            <?= nl2br(htmlspecialchars($product['description'])) ?>
        </div>
        
        <div class="product-price">
            <?= number_format($product['price'], 2) ?> FCFA
            <small style="font-size: 0.9rem; color: #999;">TTC</small>
        </div>
        
        <?php 
        $stockClass = '';
        $stockText = '';
        if ($product['stock'] > 10) {
            $stockClass = 'stock-instock';
            $stockText = '✅ En stock (' . $product['stock'] . ' unités)';
        } elseif ($product['stock'] > 0) {
            $stockClass = 'stock-low';
            $stockText = '⚠️ Stock faible : ' . $product['stock'] . ' unités';
        } else {
            $stockClass = 'stock-out';
            $stockText = '❌ Rupture de stock';
        }
        ?>
        <div class="product-stock <?= $stockClass ?>">
            <?= $stockText ?>
        </div>
        
        <?php if (isset($_SESSION['user_id']) && $product['stock'] > 0): ?>
            <div class="quantity-selector">
                <form method="POST" action="/mkFashion/public/cart/add" class="add-to-cart-ajax" style="display: flex; gap: 15px; align-items: center;">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" class="quantity-input">
                    <button type="submit" class="add-to-cart">
                        <i class="fas fa-shopping-cart"></i> Ajouter au panier
                    </button>
                </form>
            </div>
        <?php elseif (!isset($_SESSION['user_id'])): ?>
            <p style="margin: 20px 0;">
                🔐 <a href="/mkFashion/public/auth/loginForm" style="color: #667eea; font-weight: 600;">Connecte-toi</a> pour acheter ce produit
            </p>
        <?php endif; ?>
        
        <div class="product-meta">
            <div class="meta-item">
                <i class="fas fa-truck"></i>
                <span>Livraison offerte dès 25 000 FCFA</span>
            </div>
            <div class="meta-item">
                <i class="fas fa-undo"></i>
                <span>Retour sous 30 jours</span>
            </div>
            <div class="meta-item">
                <i class="fas fa-lock"></i>
                <span>Paiement sécurisé</span>
            </div>
        </div>
        
        <a href="/mkFashion/public/" class="back-link">
            ← Retour à la boutique
        </a>
    </div>
</div>

<footer>
    <p>&copy; 2026 MK Fashion - Tous droits réservés</p>
</footer>

<script>
// AJAX Add to cart
document.querySelectorAll('.add-to-cart-ajax').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch('/mkFashion/public/cart/add', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                updateCartCount();
            } else {
                showToast(data.error, 'error');
            }
        });
    });
});

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.innerHTML = `✅ ${message}`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

function updateCartCount() {
    fetch('/mkFashion/public/cart/getCount', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        const el = document.getElementById('cart-count');
        if (el) {
            el.textContent = data.count || 0;
            el.style.display = data.count > 0 ? 'inline-block' : 'none';
        }
    });
}

updateCartCount();
</script>
</body>
</html>