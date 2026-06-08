<?php
// ===== RÉCUPÉRATION DU STATUT DEPUIS LA BDD =====
require_once ROOT_PATH . '/config/database.php';
$db = new Database();
$conn = $db->getConnection();

$statusQuery = "SELECT status, created_at FROM orders WHERE id = " . intval($id);
$statusStmt = $conn->query($statusQuery);
$orderData = $statusStmt->fetch(PDO::FETCH_ASSOC);

$orderStatus = $orderData['status'] ?? 'pending';
$orderDate = $orderData['created_at'] ?? date('Y-m-d H:i:s');
// ===== FIN RÉCUPÉRATION =====
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande #<?= $id ?> - MK Fashion</title>
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

        .detail-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            text-decoration: none;
            margin-bottom: 30px;
            font-weight: 500;
        }

        .order-header-card {
            background: white;
            border-radius: 25px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .order-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .order-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: #1a1a2e;
        }

        .order-number small {
            font-size: 0.9rem;
            font-weight: 400;
            color: #666;
        }

        .status-group {
            display: flex;
            gap: 15px;
        }

        .status-badge {
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-paid { background: #d4edda; color: #155724; }
        .status-shipped { background: #cce5ff; color: #004085; }
        .status-delivered { background: #d1ecf1; color: #0c5460; }

        .payment-badge {
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .payment-paid { background: #27ae60; color: white; }
        .payment-pending { background: #f39c12; color: white; }

        .timeline {
            display: flex;
            justify-content: space-between;
            margin: 40px 0;
            position: relative;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 25px;
            left: 0;
            right: 0;
            height: 3px;
            background: #e0e0e0;
            z-index: 1;
        }

        .timeline-step {
            text-align: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }

        .step-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            border: 3px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-weight: bold;
            transition: all 0.3s;
        }

        .timeline-step.completed .step-circle {
            background: #27ae60;
            border-color: #27ae60;
            color: white;
        }

        .timeline-step.active .step-circle {
            border-color: #667eea;
            background: #667eea;
            color: white;
            transform: scale(1.1);
        }

        .step-label {
            font-weight: 600;
            color: #333;
        }

        .step-date {
            font-size: 0.7rem;
            color: #999;
            margin-top: 5px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }

        .info-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
        }

        .info-card h4 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .info-card p {
            margin: 8px 0;
            color: #555;
        }

        .products-section {
            background: white;
            border-radius: 25px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .products-section h3 {
            margin-bottom: 25px;
            color: #1a1a2e;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
        }

        .product-table th {
            text-align: left;
            padding: 15px 0;
            border-bottom: 2px solid #f0f0f0;
            color: #666;
            font-weight: 600;
        }

        .product-table td {
            padding: 20px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-info img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 12px;
        }

        .product-name {
            font-weight: 600;
            color: #333;
        }

        .total-row {
            background: #f8f9fa;
        }

        .total-row td {
            padding: 20px;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .total-row td:last-child {
            color: #667eea;
            font-size: 1.4rem;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-pay {
            background: #27ae60;
            color: white;
        }

        .btn-outline {
            border: 2px solid #667eea;
            color: #667eea;
            background: transparent;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .tracking-section {
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .tracking-code {
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 12px;
            display: inline-block;
            margin-top: 15px;
        }

        footer {
            background: #1a1a2e;
            color: #999;
            text-align: center;
            padding: 40px;
            margin-top: 60px;
        }

        @media (max-width: 768px) {
            .timeline { flex-direction: column; gap: 20px; }
            .timeline::before { display: none; }
            .product-table { display: block; overflow-x: auto; }
            .order-title { flex-direction: column; align-items: flex-start; }
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

<div class="detail-container">
    <a href="/mkFashion/public/account/orders" class="back-link">
        <i class="fas fa-arrow-left"></i> Retour à mes commandes
    </a>

    <?php
    // Calcul du total
    $total = 0;
    foreach ($orderDetails as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    
    // Déterminer les étapes de la timeline (utilise $orderStatus maintenant)
    $steps = ['pending' => 1, 'paid' => 2, 'shipped' => 3, 'delivered' => 4];
    $currentStep = $steps[$orderStatus] ?? 1;
    ?>

    <div class="order-header-card">
        <div class="order-title">
            <div class="order-number">
                Commande #<?= $id ?>
                <small>passée le <?= date('d/m/Y à H:i', strtotime($orderDate)) ?></small>
            </div>
            <div class="status-group">
                <span class="status-badge status-<?= $orderStatus ?>">
                    <?php 
                        $statusText = [
                            'pending' => '⏳ En attente',
                            'paid' => '✅ Payée',
                            'shipped' => '📦 Expédiée',
                            'delivered' => '🎁 Livrée'
                        ];
                        echo $statusText[$orderStatus] ?? $orderStatus;
                    ?>
                </span>
                <span class="payment-badge <?= ($payment && $payment['status'] == 'paid') ? 'payment-paid' : 'payment-pending' ?>">
                    <?= ($payment && $payment['status'] == 'paid') ? '💳 Payé' : '⏳ En attente de paiement' ?>
                </span>
            </div>
        </div>

        <!-- TIMELINE SUIVI -->
        <div class="timeline">
            <div class="timeline-step <?= $currentStep >= 1 ? 'completed' : '' ?> <?= $currentStep == 1 ? 'active' : '' ?>">
                <div class="step-circle">1</div>
                <div class="step-label">Commande validée</div>
                <div class="step-date"><?= date('d/m/Y', strtotime($orderDate)) ?></div>
            </div>
            <div class="timeline-step <?= $currentStep >= 2 ? 'completed' : '' ?> <?= $currentStep == 2 ? 'active' : '' ?>">
                <div class="step-circle">2</div>
                <div class="step-label">Paiement confirmé</div>
                <div class="step-date"><?= ($payment && $payment['paid_at']) ? date('d/m/Y', strtotime($payment['paid_at'])) : 'En attente' ?></div>
            </div>
            <div class="timeline-step <?= $currentStep >= 3 ? 'completed' : '' ?> <?= $currentStep == 3 ? 'active' : '' ?>">
                <div class="step-circle">3</div>
                <div class="step-label">Expédition</div>
                <div class="step-date"><?= $currentStep >= 3 ? 'Expédiée' : 'À venir' ?></div>
            </div>
            <div class="timeline-step <?= $currentStep >= 4 ? 'completed' : '' ?> <?= $currentStep == 4 ? 'active' : '' ?>">
                <div class="step-circle">4</div>
                <div class="step-label">Livraison</div>
                <div class="step-date"><?= $currentStep >= 4 ? 'Livrée' : 'À venir' ?></div>
            </div>
        </div>

        <!-- INFOS LIVRAISON & FACTURATION -->
        <div class="info-grid">
            <div class="info-card">
                <h4><i class="fas fa-truck"></i> Adresse de livraison</h4>
                <p><?= htmlspecialchars($_SESSION['user_name'] ?? 'Client') ?></p>
                <p>123 Rue de la Mode</p>
                <p>75001 Paris, France</p>
            </div>
            <div class="info-card">
                <h4><i class="fas fa-file-invoice"></i> Adresse de facturation</h4>
                <p><?= htmlspecialchars($_SESSION['user_name'] ?? 'Client') ?></p>
                <p>123 Rue de la Mode</p>
                <p>75001 Paris, France</p>
            </div>
            <div class="info-card">
                <h4><i class="fas fa-credit-card"></i> Mode de paiement</h4>
                <p>Carte bancaire</p>
                <p>**** **** **** 4242</p>
            </div>
        </div>
    </div>

    <!-- PRODUITS COMMANDÉS -->
    <div class="products-section">
        <h3>🛍️ Articles commandés</h3>
        <table class="product-table">
            <thead>
                <tr><th>Produit</th><th>Prix unitaire</th><th>Quantité</th><th>Total</th></tr>
            </thead>
            <tbody>
                <?php foreach ($orderDetails as $item): 
                    $itemTotal = $item['price'] * $item['quantity'];
                ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="<?= $item['image_url'] ?>" alt="<?= $item['name'] ?>">
                            <div>
                                <div class="product-name"><?= htmlspecialchars($item['name']) ?></div>
                                <small style="color: #999;">Réf: MK-<?= str_pad($item['product_id'], 5, '0', STR_PAD_LEFT) ?></small>
                            </div>
                        </div>
                    </td>
                    <td><?= number_format($item['price'], 2) ?> €</td>
                    <td><?= $item['quantity'] ?></td>
                    <td><strong><?= number_format($itemTotal, 2) ?> €</strong></td>
                </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="3" align="right"><strong>Total TTC</strong></td>
                    <td><strong><?= number_format($total, 2) ?> €</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- SUIVI LIVRAISON -->
    <?php if ($orderStatus == 'shipped' || $orderStatus == 'delivered'): ?>
    <div class="tracking-section">
        <h3>📬 Suivi de livraison</h3>
        <p>Votre colis a été expédié ! Vous pouvez suivre votre livraison avec le numéro ci-dessous :</p>
        <div class="tracking-code">
            <i class="fas fa-box"></i> Numéro de suivi : <strong>MK<?= str_pad($id, 8, '0', STR_PAD_LEFT) ?>FR</strong>
            <button class="btn-outline" style="margin-left: 15px; padding: 5px 15px;" onclick="copyTracking()">Copier</button>
        </div>
        <div style="margin-top: 20px;">
            <div style="background: #f8f9fa; border-radius: 12px; padding: 15px;">
                <p><i class="fas fa-map-marker-alt"></i> <strong>Statut actuel :</strong> 
                <?= $orderStatus == 'delivered' ? 'Livré' : 'En cours de livraison' ?></p>
                <p><i class="fas fa-calendar"></i> <strong>Estimation de livraison :</strong> 
                <?= $orderStatus == 'delivered' ? 'Livré le ' . date('d/m/Y') : 'Entre le ' . date('d/m/Y', strtotime('+2 days')) . ' et le ' . date('d/m/Y', strtotime('+5 days')) ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- BOUTONS D'ACTION -->
    <div class="action-buttons">
        <?php if ((!$payment || $payment['status'] != 'paid') && $orderStatus == 'pending'): ?>
            <a href="/mkFashion/public/account/pay/<?= $id ?>" class="btn btn-pay">
                💳 Payer maintenant
            </a>
        <?php endif; ?>
        
        <?php if ($orderStatus == 'delivered'): ?>
            <button class="btn btn-outline" onclick="showReturnRequest()">
                🔄 Demander un retour
            </button>
        <?php endif; ?>
        
        <a href="/mkFashion/public/" class="btn btn-primary">
            🛍️ Continuer mes achats
        </a>
    </div>
</div>

<footer>
    <p>&copy; 2024 MK Fashion - Tous droits réservés</p>
</footer>

<script>
function copyTracking() {
    navigator.clipboard.writeText('MK<?= str_pad($id, 8, '0', STR_PAD_LEFT) ?>FR');
    alert('Numéro de suivi copié !');
}

function showReturnRequest() {
    alert('📦 Demande de retour\n\nNotre service client va vous contacter sous 48h pour traiter votre retour.');
}
</script>
</body>
</html>