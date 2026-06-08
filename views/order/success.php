<?php
// Récupérer les détails de la commande si non passés
if (!isset($orderDetails) && isset($order_id)) {
    require_once ROOT_PATH . '/models/Order.php';
    $orderModel = new Order();
    $orderDetails = $orderModel->getOrderDetails($order_id);
    
    // Récupérer le statut de la commande
    require_once ROOT_PATH . '/config/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->prepare("SELECT status, created_at, total_price FROM orders WHERE id = ?");
    $stmt->execute([$order_id]);
    $orderInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $orderStatus = $orderInfo['status'] ?? 'pending';
    $orderDate = $orderInfo['created_at'] ?? date('Y-m-d H:i:s');
    $orderTotal = $orderInfo['total_price'] ?? 0;
}

// Calcul du total si non fait
if (!isset($total) && isset($orderDetails)) {
    $total = 0;
    foreach ($orderDetails as $item) {
        $total += $item['price'] * $item['quantity'];
    }
}

// S'assurer que $orderDate est défini
if (!isset($orderDate) || empty($orderDate)) {
    $orderDate = date('Y-m-d H:i:s');
}

// Récupérer l'email de l'utilisateur
$userEmail = $_SESSION['user_email'] ?? 'client@mkfashion.com';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande confirmée - MK Fashion</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* CONFETTI ANIMATION */
        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            position: absolute;
            animation: confettiFall 3s linear forwards;
            z-index: 9999;
        }

        @keyframes confettiFall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }

        .success-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .success-card {
            background: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-header {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            text-align: center;
            padding: 50px 30px;
        }

        .success-icon {
            font-size: 5rem;
            margin-bottom: 20px;
            animation: checkmark 0.5s ease-in-out;
        }

        @keyframes checkmark {
            0% { transform: scale(0); opacity: 0; }
            80% { transform: scale(1.2); }
            100% { transform: scale(1); opacity: 1; }
        }

        .success-header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .order-number {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-top: 15px;
            padding: 8px 20px;
            background: rgba(255,255,255,0.2);
            display: inline-block;
            border-radius: 50px;
        }

        .order-info-section {
            padding: 30px;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
        }

        .info-item {
            text-align: center;
        }

        .info-icon {
            font-size: 2rem;
            color: #667eea;
            margin-bottom: 10px;
        }

        .info-label {
            color: #999;
            font-size: 0.85rem;
            margin-bottom: 5px;
        }

        .info-value {
            font-weight: 700;
            color: #333;
            font-size: 1.1rem;
        }

        .products-section {
            padding: 30px;
            border-bottom: 1px solid #f0f0f0;
        }

        .products-section h3 {
            margin-bottom: 20px;
            color: #1a1a2e;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
        }

        .product-table th {
            text-align: left;
            padding: 12px 0;
            border-bottom: 2px solid #f0f0f0;
            color: #666;
            font-weight: 600;
        }

        .product-table td {
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-info img {
            width: 60px;
            height: 60px;
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

        .timeline-section {
            padding: 30px;
            border-bottom: 1px solid #f0f0f0;
            background: #f8f9fa;
        }

        .timeline {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 20px 0;
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

        .step-label {
            font-weight: 600;
            color: #333;
            font-size: 0.85rem;
        }

        .action-buttons {
            padding: 30px;
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 14px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
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

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .share-section {
            padding: 20px 30px 30px;
            text-align: center;
            background: #f8f9fa;
            border-top: 1px solid #f0f0f0;
        }

        .share-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 15px;
        }

        .share-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: transform 0.3s;
        }

        .share-btn:hover {
            transform: translateY(-3px);
        }

        .share-whatsapp { background: #25D366; }
        .share-twitter { background: #1DA1F2; }
        .share-facebook { background: #1877F2; }
        .share-mail { background: #666; }

        footer {
            text-align: center;
            padding: 30px;
            color: rgba(255,255,255,0.7);
        }

        @media (max-width: 768px) {
            .timeline { flex-direction: column; gap: 20px; }
            .timeline::before { display: none; }
            .product-table { display: block; overflow-x: auto; }
        }
    </style>
</head>
<body>

<div class="success-container">
    <div class="success-card">
        <div class="success-header">
            <div class="success-icon">🎉</div>
            <h1>Merci pour votre commande !</h1>
            <p>Votre commande a été confirmée avec succès</p>
            <div class="order-number">
                <i class="fas fa-hashtag"></i> Commande #<?= $order_id ?>
            </div>
        </div>

        <div class="order-info-section">
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-calendar"></i></div>
                    <div class="info-label">Date de commande</div>
                    <div class="info-value"><?= date('d/m/Y à H:i', strtotime($orderDate)) ?></div>
                </div>
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-euro-sign"></i></div>
                    <div class="info-label">Montant total</div>
                    <div class="info-value"><?= number_format($total, 2) ?> €</div>
                </div>
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-truck"></i></div>
                    <div class="info-label">Livraison</div>
                    <div class="info-value">Offerte</div>
                </div>
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-envelope"></i></div>
                    <div class="info-label">Confirmation envoyée à</div>
                    <div class="info-value"><?= htmlspecialchars($userEmail) ?></div>
                </div>
            </div>
        </div>

        <div class="timeline-section">
            <h3 style="margin-bottom: 30px; text-align: center;">📬 Suivi de votre commande</h3>
            <div class="timeline">
                <div class="timeline-step completed">
                    <div class="step-circle">✓</div>
                    <div class="step-label">Commandée</div>
                </div>
                <div class="timeline-step <?= $orderStatus == 'paid' ? 'completed' : '' ?>">
                    <div class="step-circle">2</div>
                    <div class="step-label">Payée</div>
                </div>
                <div class="timeline-step">
                    <div class="step-circle">3</div>
                    <div class="step-label">Expédiée</div>
                </div>
                <div class="timeline-step">
                    <div class="step-circle">4</div>
                    <div class="step-label">Livrée</div>
                </div>
            </div>
            <p style="text-align: center; color: #666; margin-top: 20px;">
                <i class="fas fa-clock"></i> Vous serez notifié par email à chaque étape
            </p>
        </div>

        <div class="products-section">
            <h3>🛍️ Détail de votre commande</h3>
            <table class="product-table">
                <thead>
                    <tr><th>Produit</th><th>Prix</th><th>Qté</th><th>Total</th></tr>
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
                        <td><?= $item['quantity'] ?> </td>
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

        <div class="action-buttons">
            <a href="/mkFashion/public/account/orderDetail/<?= $order_id ?>" class="btn btn-outline">
                <i class="fas fa-eye"></i> Suivre ma commande
            </a>
            <a href="/mkFashion/public/account/orders" class="btn btn-outline">
                <i class="fas fa-list"></i> Voir toutes mes commandes
            </a>
            <a href="/mkFashion/public/" class="btn btn-primary">
                <i class="fas fa-shopping-bag"></i> Continuer mes achats
            </a>
        </div>

        <div class="share-section">
            <p>Partagez votre achat avec vos amis !</p>
            <div class="share-buttons">
                <a href="https://wa.me/?text=Je viens de commander sur MK Fashion ! 🛍️" target="_blank" class="share-btn share-whatsapp"><i class="fab fa-whatsapp"></i></a>
                <a href="https://twitter.com/intent/tweet?text=Je viens de commander sur MK Fashion ! 🛍️" target="_blank" class="share-btn share-twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=mkfashion.com" target="_blank" class="share-btn share-facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="mailto:?subject=Ma commande MK Fashion&body=Je viens de commander sur MK Fashion !" class="share-btn share-mail"><i class="fas fa-envelope"></i></a>
            </div>
        </div>
    </div>
</div>

<footer>
    <p>Un email de confirmation vous a été envoyé avec les détails de votre commande.</p>
</footer>

<script>
// Confetti animation
function createConfetti() {
    for (let i = 0; i < 100; i++) {
        const confetti = document.createElement('div');
        confetti.className = 'confetti';
        confetti.style.left = Math.random() * 100 + '%';
        confetti.style.animationDelay = Math.random() * 3 + 's';
        confetti.style.backgroundColor = `hsl(${Math.random() * 360}, 70%, 60%)`;
        confetti.style.width = Math.random() * 8 + 4 + 'px';
        confetti.style.height = Math.random() * 8 + 4 + 'px';
        document.body.appendChild(confetti);
        
        setTimeout(() => confetti.remove(), 3000);
    }
}
createConfetti();
</script>
</body>
</html>