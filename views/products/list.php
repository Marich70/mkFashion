<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MK Fashion - Streetwear Collection</title>
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
        
        /* ===== NAVBAR LUXE ===== */
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
            letter-spacing: -1px;
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
            font-size: 0.95rem;
        }
        
        .nav-links a:hover {
            color: #667eea;
            transform: translateY(-2px);
        }
        
        .cart-icon {
            position: relative;
            font-size: 1.3rem;
        }
        
        .cart-badge {
            display: inline-block;
        }
        
        .cart-count {
            position: absolute;
            top: -10px;
            right: -15px;
            background: #e74c3c;
            color: white;
            font-size: 11px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 50%;
            min-width: 18px;
            text-align: center;
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
            font-size: 0.85rem;
            transition: all 0.3s;
        }
        
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231,76,60,0.3);
        }
        
        .btn-inscription {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 22px;
            border-radius: 30px;
        }
        
        /* ===== HERO SECTION ===== */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 80px 20px;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 20s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(10%, 10%); }
        }
        
        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            font-weight: 800;
            position: relative;
            z-index: 1;
        }
        
        .hero p {
            font-size: 1.3rem;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }
        
        /* ===== PRODUCTS GRID ===== */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 60px 2rem;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 50px;
            color: #1a1a2e;
            font-weight: 700;
            position: relative;
        }
        
        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 15px auto 0;
            border-radius: 2px;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 35px;
        }
        
        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 45px rgba(0,0,0,0.15);
        }
        
        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #27ae60;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 2;
        }
        
        .product-badge.soldout {
            background: #e74c3c;
        }
        
        .product-image {
            width: 100%;
            height: 350px;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .product-card:hover .product-image {
            transform: scale(1.05);
        }
        
        .product-info {
            padding: 25px;
            background: white;
        }
        
        .product-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #1a1a2e;
        }
        
        .product-price {
            font-size: 1.4rem;
            color: #667eea;
            font-weight: 800;
            margin: 12px 0;
        }
        
        .product-price old {
            font-size: 0.9rem;
            color: #999;
            text-decoration: line-through;
            margin-left: 8px;
        }
        
        .product-description {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        
        .btn-detail {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: center;
        }
        
        .btn-detail:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(102,126,234,0.4);
        }
        
        /* ===== FILTRES ===== */
        .filters {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .filter-group {
            display: flex;
            gap: 10px;
        }
        
        .filter-btn {
            padding: 8px 20px;
            border: 2px solid #e0e0e0;
            background: white;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .filter-btn.active, .filter-btn:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }
        
        .sort-select {
            padding: 8px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 30px;
            background: white;
            font-weight: 500;
            cursor: pointer;
        }
        
        /* ===== TOAST NOTIFICATION ===== */
        .toast-notification {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInRight 0.3s ease;
            font-family: 'Inter', sans-serif;
        }
        
        .toast-notification.success {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        }
        
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .empty-products {
            text-align: center;
            padding: 80px;
            background: white;
            border-radius: 20px;
        }
        
        footer {
            background: #1a1a2e;
            color: #999;
            text-align: center;
            padding: 40px;
            margin-top: 60px;
        }
        
        @media (max-width: 768px) {
            .hero h1 { font-size: 2rem; }
            .products-grid { grid-template-columns: 1fr; }
            .filters { flex-direction: column; }
        }
    </style>
</head>
<body>

<!-- NAVBAR LUXE -->
<nav class="navbar">
    <div class="nav-container">
        <div class="logo">🔥 MK FASHION</div>
        <div class="nav-links">
            <a href="/mkFashion/public/">Accueil</a>
            <a href="/mkFashion/public/cart/index" class="cart-icon cart-badge">
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

<!-- HERO SECTION -->
<section class="hero-v2">
    <div class="hero-v2-bg">
        <div class="hero-v2-overlay"></div>
    </div>
    
    <div class="hero-v2-container">
        <div class="hero-v2-content">
            <span class="hero-v2-badge">
                <i class="fas fa-fire"></i> LIMITED EDITION
            </span>
            <h1 class="hero-v2-title">
                Nouvelle Collection <br>
                <span class="hero-v2-gradient">Streetwear 2026</span>
            </h1>
            <p class="hero-v2-description">
                Découvrez les pièces exclusives de la saison. Design unique, qualité premium.<br>
                🚚 Livraison offerte dès 25 000 FCFA d'achat
            </p>
            <div class="hero-v2-buttons">
                <a href="#products" class="hero-v2-btn-primary">
                    <span>🛍️ Découvrir la collection</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="/mkFashion/public/cart/index" class="hero-v2-btn-secondary">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Voir mon panier</span>
                </a>
            </div>
            <div class="hero-v2-stats">
                <div class="hero-v2-stat">
                    <div class="hero-v2-stat-number">50+</div>
                    <div class="hero-v2-stat-text">Produits exclusifs</div>
                </div>
                <div class="hero-v2-stat">
                    <div class="hero-v2-stat-number">24/7</div>
                    <div class="hero-v2-stat-text">Support client</div>
                </div>
                <div class="hero-v2-stat">
                    <div class="hero-v2-stat-number">100%</div>
                    <div class="hero-v2-stat-text">Satisfait ou remboursé</div>
                </div>
            </div>
        </div>
        
        <div class="hero-v2-image">
            <div class="hero-v2-card hero-v2-card-1">
                <i class="fas fa-tshirt"></i>
                <div>
                    <span>Nouvelle arrivage</span>
                    <strong>-30%</strong>
                </div>
            </div>
            <div class="hero-v2-card hero-v2-card-2">
                <i class="fas fa-truck-fast"></i>
                <div>
                    <span>Livraison</span>
                    <strong>Offerte</strong>
                </div>
            </div>
            <div class="hero-v2-card hero-v2-card-3">
                <i class="fas fa-star"></i>
                <div>
                    <span>Note client</span>
                    <strong>4.9/5</strong>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PRODUCTS SECTION -->
<div class="container">
    <div class="filters">
        <div class="filter-group">
            <button class="filter-btn active" data-filter="all">Tous</button>
            <button class="filter-btn" data-filter="tshirt">T-shirts</button>
            <button class="filter-btn" data-filter="hoodie">Hoodies</button>
            <button class="filter-btn" data-filter="jean">Jeans</button>
        </div>
        <select class="sort-select" id="sort-price">
            <option value="default">Trier par</option>
            <option value="price-asc">Prix croissant</option>
            <option value="price-desc">Prix décroissant</option>
        </select>
    </div>
    
    <h2 class="section-title">Nos Produits</h2>
    
    <?php if (empty($products)): ?>
        <div class="empty-products">
            <p>⚠️ Aucun produit disponible pour le moment.</p>
        </div>
    <?php else: ?>
        <div class="products-grid" id="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card" data-name="<?= strtolower($product['name']) ?>" data-price="<?= $product['price'] ?>">
                    <?php if ($product['stock'] > 0 && $product['stock'] < 10): ?>
                        <div class="product-badge">⚠️ Plus que <?= $product['stock'] ?> en stock</div>
                    <?php elseif ($product['stock'] <= 0): ?>
                        <div class="product-badge soldout">Épuisé</div>
                    <?php endif; ?>
                    <img src="<?= $product['image_url'] ?>" alt="<?= $product['name'] ?>" class="product-image">
                    <div class="product-info">
                        <h3 class="product-title"><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="product-description"><?= substr(htmlspecialchars($product['description']), 0, 60) ?>...</p>
                        <div class="product-price">
                            <?= number_format($product['price'], 2) ?> FCFA
                        </div>
                        <a href="/mkFashion/public/product/detail/<?= $product['id'] ?>" class="btn-detail">
                            Voir détails
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; 2026 MK Fashion - Tous droits réservés</p>
    <p style="margin-top: 10px; opacity: 0.7;">Le streetwear qui déchire sa mère 🔥</p>
</footer>

<script>
// Filtres et tri
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const sortSelect = document.getElementById('sort-price');
    const productsGrid = document.getElementById('products-grid');
    
    if (productsGrid) {
        const productCards = Array.from(productsGrid.children);
        
        function filterAndSort() {
            let filteredCards = [...productCards];
            
            // Filtrer
            const activeFilter = document.querySelector('.filter-btn.active')?.dataset.filter || 'all';
            if (activeFilter !== 'all') {
                filteredCards = filteredCards.filter(card => {
                    const name = card.dataset.name || '';
                    return name.includes(activeFilter);
                });
            }
            
            // Trier
            const sortValue = sortSelect?.value;
            if (sortValue === 'price-asc') {
                filteredCards.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
            } else if (sortValue === 'price-desc') {
                filteredCards.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
            }
            
            // Réafficher
            productsGrid.innerHTML = '';
            filteredCards.forEach(card => productsGrid.appendChild(card));
        }
        
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                filterAndSort();
            });
        });
        
        if (sortSelect) {
            sortSelect.addEventListener('change', filterAndSort);
        }
    }
    
    // Update cart count
    updateCartCount();
});

function updateCartCount() {
    fetch('/mkFashion/public/cart/getCount', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
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
</script>
</body>
</html>