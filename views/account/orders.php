<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes commandes - MK Fashion</title>
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

        /* NAVBAR */
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

        /* MAIN CONTAINER */
        .orders-container {
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

        /* STATS CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #667eea;
        }

        .stat-label {
            color: #666;
            margin-top: 5px;
        }

        /* ORDER TABS */
        .order-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .tab-btn {
            padding: 10px 25px;
            border: none;
            background: none;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            border-radius: 30px;
            transition: all 0.3s;
            color: #666;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
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
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }

        .order-card:hover {
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .order-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            border-bottom: 1px solid #eee;
        }

        .order-info {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .order-info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #555;
            font-size: 0.9rem;
        }

        .order-info-item i {
            color: #667eea;
            width: 20px;
        }

        .order-status {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .status-badge {
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-paid { background: #d4edda; color: #155724; }
        .status-shipped { background: #cce5ff; color: #004085; }
        .status-delivered { background: #d1ecf1; color: #0c5460; }

        .payment-badge {
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .payment-paid { background: #27ae60; color: white; }
        .payment-pending { background: #f39c12; color: white; }

        .order-body {
            padding: 25px;
        }

        .order-products {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .order-product-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 12px;
        }

        .order-product-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 10px;
        }

        .order-product-details {
            font-size: 0.85rem;
        }

        .order-product-name {
            font-weight: 600;
            color: #333;
        }

        .order-total {
            text-align: right;
            padding-top: 15px;
            border-top: 1px solid #eee;
            font-size: 1.1rem;
        }

        .order-total strong {
            font-size: 1.3rem;
            color: #667eea;
        }

        .order-footer {
            padding: 15px 25px;
            background: #f8f9fa;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .btn {
            padding: 10px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
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

        .btn-pay {
            background: #27ae60;
            color: white;
        }

        .btn-pay:hover, .btn-primary:hover, .btn-outline:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
            .order-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .stats-grid {
                grid-template-columns: 1fr 1fr;
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

<?php
if (!class_exists('Payment')) {
    require_once ROOT_PATH . '/models/Payment.php';
}
?>

<div class="orders-container">
    <div class="page-header">
        <h1>📦 Mes commandes</h1>
        <p>Suivez l'état de vos achats et gérez vos retours</p>
    </div>

    <?php if (isset($_SESSION['payment_success'])): ?>
        <div class="alert success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
            ✅ <?= $_SESSION['payment_success'] ?>
        </div>
        <?php unset($_SESSION['payment_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['payment_error'])): ?>
        <div class="alert error" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
            ❌ <?= $_SESSION['payment_error'] ?>
        </div>
        <?php unset($_SESSION['payment_error']); ?>
    <?php endif; ?>

    <?php
    // Calcul des stats
    $total_spent = 0;
    $total_orders = count($orders);
    $pending_payment = 0;
    
    foreach ($orders as $order) {
        $total_spent += $order['total_price'];
        $paymentModel = new Payment();
        $payment = $paymentModel->getPaymentStatus($order['id']);
        if (!$payment || $payment['status'] != 'paid') {
            $pending_payment++;
        }
    }
    ?>

    <!-- STATS CARDS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-value"><?= $total_orders ?></div>
            <div class="stat-label">Commandes passées</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-value"><?= number_format($total_spent, 2) ?> €</div>
            <div class="stat-label">Total dépensé</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⏳</div>
            <div class="stat-value"><?= $pending_payment ?></div>
            <div class="stat-label">En attente de paiement</div>
        </div>
    </div>

    <!-- ORDER TABS -->
    <div class="order-tabs">
        <button class="tab-btn active" data-tab="all">Toutes</button>
        <button class="tab-btn" data-tab="pending">En attente</button>
        <button class="tab-btn" data-tab="paid">Payées</button>
        <button class="tab-btn" data-tab="delivered">Livrées</button>
    </div>

    <?php if (empty($orders)): ?>
        <div class="empty-orders">
            <i class="fas fa-shopping-bag"></i>
            <h3>Vous n'avez pas encore de commande</h3>
            <p style="margin: 15px 0;">Découvrez notre collection et faites votre première commande !</p>
            <a href="/mkFashion/public/" class="btn btn-primary">🛍️ Découvrir les produits</a>
        </div>
    <?php else: ?>
        <div class="orders-list" id="orders-list">
            <?php foreach ($orders as $order): 
                $paymentModel = new Payment();
                $payment = $paymentModel->getPaymentStatus($order['id']);
                $isPaid = ($payment && $payment['status'] == 'paid');
            ?>
                <div class="order-card" data-status="<?= $order['status'] ?>">
                    <div class="order-header">
                        <div class="order-info">
                            <div class="order-info-item">
                                <i class="fas fa-hashtag"></i>
                                <span>Commande #<?= $order['id'] ?></span>
                            </div>
                            <div class="order-info-item">
                                <i class="fas fa-calendar"></i>
                                <span><?= date('d/m/Y à H:i', strtotime($order['created_at'])) ?></span>
                            </div>
                            <div class="order-info-item">
                                <i class="fas fa-euro-sign"></i>
                                <span><?= number_format($order['total_price'], 2) ?> €</span>
                            </div>
                        </div>
                        <div class="order-status">
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
                            <span class="payment-badge <?= $isPaid ? 'payment-paid' : 'payment-pending' ?>">
                                <?= $isPaid ? '💳 Payé' : '⏳ Non payé' ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="order-body">
                        <div class="order-products">
                            <?php 
                            $orderModelDetail = new Order();
                            $items = $orderModelDetail->getOrderDetails($order['id']);
                            $itemCount = 0;
                            foreach ($items as $item):
                                if ($itemCount >= 2) break;
                                $itemCount++;
                            ?>
                                <div class="order-product-item">
                                    <img src="<?= $item['image_url'] ?>" alt="<?= $item['name'] ?>">
                                    <div class="order-product-details">
                                        <div class="order-product-name"><?= htmlspecialchars($item['name']) ?></div>
                                        <div><?= $item['quantity'] ?> x <?= number_format($item['price'], 2) ?> €</div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php if (count($items) > 2): ?>
                                <div class="order-product-item">
                                    <div>+<?= count($items) - 2 ?> autre(s) article(s)</div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="order-total">
                            Total : <strong><?= number_format($order['total_price'], 2) ?> €</strong>
                        </div>
                    </div>
                    
                    <div class="order-footer">
                        <a href="/mkFashion/public/account/orderDetail/<?= $order['id'] ?>" class="btn btn-outline">
                            📋 Voir détails
                        </a>
                        <?php if (!$isPaid && $order['status'] == 'pending'): ?>
                            <a href="/mkFashion/public/account/pay/<?= $order['id'] ?>" class="btn btn-pay">
                                💳 Payer maintenant
                            </a>
                        <?php endif; ?>
                        <?php if ($order['status'] == 'delivered'): ?>
                            <button class="btn btn-outline" onclick="showReturnModal(<?= $order['id'] ?>)">
                                🔄 Faire un retour
                            </button>
                        <?php endif; ?>
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
// Tabs filtering
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const tab = this.dataset.tab;
        const orders = document.querySelectorAll('.order-card');
        
        orders.forEach(order => {
            if (tab === 'all') {
                order.style.display = 'block';
            } else if (tab === 'pending') {
                const status = order.querySelector('.status-badge').textContent;
                order.style.display = status.includes('attente') ? 'block' : 'none';
            } else if (tab === 'paid') {
                const payment = order.querySelector('.payment-badge').textContent;
                order.style.display = payment.includes('Payé') ? 'block' : 'none';
            } else if (tab === 'delivered') {
                const status = order.querySelector('.status-badge').textContent;
                order.style.display = status.includes('Livrée') ? 'block' : 'none';
            }
        });
    });
});

function showReturnModal(orderId) {
    alert('Fonctionnalité de retour bientôt disponible. Contactez notre service client.');
}
</script>
</body>
</html>