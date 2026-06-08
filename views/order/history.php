<?php
// Récupérer les commandes si non passées
if (!isset($orders) && isset($_SESSION['user_id'])) {
    require_once ROOT_PATH . '/models/Order.php';
    $orderModel = new Order();
    $orders = $orderModel->getUserOrders($_SESSION['user_id']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des commandes - MK Fashion</title>
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

        .btn-logout {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 6px 16px;
            border-radius: 30px;
        }

        .history-container {
            max-width: 1300px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .page-header {
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-size: 2.5rem;
            color: #1a1a2e;
            font-weight: 700;
        }

        .page-header p {
            color: #666;
            margin-top: 8px;
        }

        /* STATS BANNER */
        .stats-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 25px;
            padding: 30px;
            margin-bottom: 40px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
            color: white;
        }

        .stat-banner-item {
            text-align: center;
        }

        .stat-banner-value {
            font-size: 2rem;
            font-weight: 800;
        }

        .stat-banner-label {
            opacity: 0.9;
            margin-top: 5px;
        }

        /* ORDER CARDS */
        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .order-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }

        .order-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .order-header {
            padding: 20px 25px;
            background: #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            border-bottom: 1px solid #eee;
        }

        .order-header-left {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .order-header-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #555;
            font-size: 0.9rem;
        }

        .order-header-item i {
            color: #667eea;
        }

        .status-badge {
            padding: 5px 15px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-paid { background: #d4edda; color: #155724; }
        .status-shipped { background: #cce5ff; color: #004085; }
        .status-delivered { background: #d1ecf1; color: #0c5460; }

        .order-body {
            padding: 20px 25px;
        }

        .order-products {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .product-mini {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f8f9fa;
            padding: 8px 15px;
            border-radius: 12px;
        }

        .product-mini img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 8px;
        }

        .order-footer {
            padding: 15px 25px;
            background: #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .order-total {
            font-size: 1.1rem;
        }

        .order-total strong {
            font-size: 1.3rem;
            color: #667eea;
        }

        .btn {
            padding: 8px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-outline {
            border: 2px solid #667eea;
            color: #667eea;
            background: transparent;
        }

        .btn-sm {
            padding: 6px 15px;
            font-size: 0.85rem;
        }

        .btn-pay {
            background: #27ae60;
            color: white;
            border: none;
        }

        .empty-orders {
            text-align: center;
            padding: 80px;
            background: white;
            border-radius: 20px;
        }

        .empty-orders i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        footer {
            background: #1a1a2e;
            color: #999;
            text-align: center;
            padding: 40px;
            margin-top: 60px;
        }

        @media (max-width: 768px) {
            .order-header { flex-direction: column; align-items: flex-start; }
            .order-footer { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <div class="logo">🔥 MK FASHION</div>
        <div class="nav-links">
            <a href="/mkFashion/public/">Accueil</a>
            <a href="/mkFashion/public/cart/index">🛒 Panier</a>
            <a href="/mkFashion/public/account/orders" style="color: #667eea;">📦 Mes commandes</a>
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
                <a href="/mkFashion/public/auth/registerForm">Inscription</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="history-container">
    <div class="page-header">
        <h1>📦 Historique des commandes</h1>
        <p>Retrouvez toutes vos commandes et suivez leur évolution</p>
    </div>

    <?php
    // Calcul des stats
    $totalSpent = 0;
    $totalOrders = count($orders);
    $pendingOrders = 0;
    $deliveredOrders = 0;
    
    foreach ($orders as $order) {
        $totalSpent += $order['total_price'];
        if ($order['status'] == 'pending') $pendingOrders++;
        if ($order['status'] == 'delivered') $deliveredOrders++;
    }
    ?>

    <!-- STATS BANNER -->
    <div class="stats-banner">
        <div class="stat-banner-item">
            <div class="stat-banner-value"><?= $totalOrders ?></div>
            <div class="stat-banner-label">Commandes</div>
        </div>
        <div class="stat-banner-item">
            <div class="stat-banner-value"><?= number_format($totalSpent, 2) ?> €</div>
            <div class="stat-banner-label">Total dépensé</div>
        </div>
        <div class="stat-banner-item">
            <div class="stat-banner-value"><?= $pendingOrders ?></div>
            <div class="stat-banner-label">En cours</div>
        </div>
        <div class="stat-banner-item">
            <div class="stat-banner-value"><?= $deliveredOrders ?></div>
            <div class="stat-banner-label">Livrées</div>
        </div>
    </div>

    <?php if (empty($orders)): ?>
        <div class="empty-orders">
            <i class="fas fa-shopping-bag"></i>
            <h3>Vous n'avez pas encore de commande</h3>
            <p style="margin: 15px 0;">Découvrez notre collection et faites votre première commande !</p>
            <a href="/mkFashion/public/" class="btn btn-primary">🛍️ Découvrir les produits</a>
        </div>
    <?php else: ?>
        <div class="orders-list">
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-header-left">
                            <div class="order-header-item">
                                <i class="fas fa-hashtag"></i>
                                <span>Commande #<?= $order['id'] ?></span>
                            </div>
                            <div class="order-header-item">
                                <i class="fas fa-calendar"></i>
                                <span><?= date('d/m/Y', strtotime($order['created_at'])) ?></span>
                            </div>
                            <div class="order-header-item">
                                <i class="fas fa-euro-sign"></i>
                                <span><?= number_format($order['total_price'], 2) ?> €</span>
                            </div>
                        </div>
                        <div>
                            <span class="status-badge status-<?= $order['status'] ?>">
                                <?php 
                                    $statusText = [
                                        'pending' => '⏳ En attente',
                                        'paid' => '✅ Payée',
                                        'shipped' => '📦 Expédiée',
                                        'delivered' => '🎁 Livrée'
                                    ];
                                    echo $statusText[$order['status']] ?? $order['status'];
                                ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="order-body">
                        <div class="order-products">
                            <?php 
                            $orderModelDetail = new Order();
                            $items = $orderModelDetail->getOrderDetails($order['id']);
                            $displayed = 0;
                            foreach ($items as $item):
                                if ($displayed >= 3) break;
                                $displayed++;
                            ?>
                                <div class="product-mini">
                                    <img src="<?= $item['image_url'] ?>" alt="<?= $item['name'] ?>">
                                    <div>
                                        <div style="font-weight: 500; font-size: 0.85rem;"><?= htmlspecialchars($item['name']) ?></div>
                                        <div style="font-size: 0.75rem; color: #999;">x<?= $item['quantity'] ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php if (count($items) > 3): ?>
                                <div class="product-mini">
                                    <div>+<?= count($items) - 3 ?> autre(s) article(s)</div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="order-footer">
                        <div class="order-total">
                            Total : <strong><?= number_format($order['total_price'], 2) ?> €</strong>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <a href="/mkFashion/public/order/success?order_id=<?= $order['id'] ?>" class="btn btn-outline btn-sm">
                                <i class="fas fa-eye"></i> Détails
                            </a>
                            <?php if ($order['status'] == 'pending'): ?>
                                <a href="/mkFashion/public/account/pay/<?= $order['id'] ?>" class="btn btn-pay btn-sm">
                                    <i class="fas fa-credit-card"></i> Payer
                                </a>
                            <?php endif; ?>
                            <?php if ($order['status'] == 'shipped' || $order['status'] == 'delivered'): ?>
                                <button class="btn btn-outline btn-sm" onclick="trackOrder(<?= $order['id'] ?>)">
                                    <i class="fas fa-truck"></i> Suivre
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; 2024 MK Fashion - Tous droits réservés</p>
</footer>

<script>
function trackOrder(orderId) {
    alert('📦 Suivi de livraison\n\nVotre colis est en cours d\'acheminement.\nNuméro de suivi : MK' + String(orderId).padStart(8, '0') + 'FR');
}
</script>
</body>
</html>