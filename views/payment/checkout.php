<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement sécurisé - MK Fashion</title>
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
            padding: 40px 20px;
        }

        .checkout-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* HEADER */
        .checkout-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .checkout-header h1 {
            color: white;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .checkout-header p {
            color: rgba(255,255,255,0.8);
        }

        /* PROGRESS BAR */
        .progress-steps {
            display: flex;
            justify-content: center;
            margin-bottom: 40px;
            gap: 20px;
            flex-wrap: wrap;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.2);
            padding: 10px 20px;
            border-radius: 50px;
            color: white;
        }

        .step.active {
            background: white;
            color: #667eea;
        }

        .step-number {
            width: 30px;
            height: 30px;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .step.active .step-number {
            background: #667eea;
            color: white;
        }

        /* MAIN CONTENT */
        .checkout-content {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
        }

        /* PAYMENT FORM */
        .payment-form {
            background: white;
            border-radius: 30px;
            padding: 35px;
        }

        .payment-form h2 {
            margin-bottom: 25px;
            color: #1a1a2e;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        .card-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        /* ORDER SUMMARY */
        .order-summary {
            background: white;
            border-radius: 30px;
            padding: 35px;
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .order-summary h3 {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .summary-items {
            margin-bottom: 20px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .summary-total {
            padding-top: 15px;
            margin-top: 15px;
            border-top: 2px solid #f0f0f0;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .summary-total span:last-child {
            color: #667eea;
            font-size: 1.4rem;
        }

        .btn-pay {
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

        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(39,174,96,0.3);
        }

        .payment-methods {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }

        .payment-methods i {
            font-size: 2rem;
            color: #999;
        }

        @media (max-width: 968px) {
            .checkout-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="checkout-container">
    <div class="checkout-header">
        <h1>💳 Paiement sécurisé</h1>
        <p>Commandez en toute confiance avec notre système de paiement 100% sécurisé</p>
    </div>

    <div class="progress-steps">
        <div class="step active">
            <div class="step-number">1</div>
            <span>Panier</span>
        </div>
        <div class="step active">
            <div class="step-number">2</div>
            <span>Livraison</span>
        </div>
        <div class="step active">
            <div class="step-number">3</div>
            <span>Paiement</span>
        </div>
        <div class="step">
            <div class="step-number">4</div>
            <span>Confirmation</span>
        </div>
    </div>

    <div class="checkout-content">
        <!-- FORMULAIRE DE PAIEMENT -->
        <div class="payment-form">
            <h2>🛡️ Informations de paiement</h2>
            
            <div class="form-group">
                <label>Nom sur la carte</label>
                <input type="text" id="cardName" placeholder="John Doe" value="<?= $_SESSION['user_name'] ?? '' ?>">
            </div>

            <div class="form-group">
                <label>Numéro de carte</label>
                <input type="text" id="cardNumber" placeholder="4242 4242 4242 4242" maxlength="19">
            </div>

            <div class="card-row">
                <div class="form-group">
                    <label>Date d'expiration</label>
                    <input type="text" id="cardExpiry" placeholder="MM/AA">
                </div>
                <div class="form-group">
                    <label>CVV</label>
                    <input type="text" id="cardCvv" placeholder="123" maxlength="3">
                </div>
            </div>

            <div class="payment-methods">
                <i class="fab fa-cc-visa"></i>
                <i class="fab fa-cc-mastercard"></i>
                <i class="fab fa-cc-amex"></i>
                <i class="fab fa-paypal"></i>
                <i class="fab fa-apple-pay"></i>
            </div>

            <button class="btn-pay" onclick="simulatePayment()">
                💳 Payer <?= number_format($total, 2) ?> €
            </button>
            
            <p style="text-align: center; margin-top: 20px; font-size: 0.8rem; color: #999;">
                🔒 Paiement 100% sécurisé (Mode démonstration)
            </p>
        </div>

        <!-- RÉCAPITULATIF COMMANDE -->
        <div class="order-summary">
            <h3>📦 Récapitulatif</h3>
            <div class="summary-items">
                <?php foreach ($orderDetails as $item): ?>
                    <div class="summary-item">
                        <span><?= htmlspecialchars($item['name']) ?> x <?= $item['quantity'] ?></span>
                        <span><?= number_format($item['price'] * $item['quantity'], 2) ?> €</span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="summary-item">
                <span>Livraison</span>
                <span>Offerte</span>
            </div>
            <div class="summary-total">
                <span>Total</span>
                <span><?= number_format($total, 2) ?> €</span>
            </div>
        </div>
    </div>
</div>

<script>
// Formatage carte bancaire
document.getElementById('cardNumber').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\s/g, '');
    if (value.length > 16) value = value.slice(0, 16);
    let formatted = '';
    for (let i = 0; i < value.length; i++) {
        if (i > 0 && i % 4 === 0) formatted += ' ';
        formatted += value[i];
    }
    e.target.value = formatted;
});

document.getElementById('cardExpiry').addEventListener('input', function(e) {
    let value = e.target.value.replace('/', '');
    if (value.length > 4) value = value.slice(0, 4);
    if (value.length > 2) {
        value = value.slice(0, 2) + '/' + value.slice(2);
    }
    e.target.value = value;
});

function simulatePayment() {
    // Validation simple
    const cardName = document.getElementById('cardName').value;
    const cardNumber = document.getElementById('cardNumber').value.replace(/\s/g, '');
    const cardExpiry = document.getElementById('cardExpiry').value;
    const cardCvv = document.getElementById('cardCvv').value;
    
    if (!cardName || !cardNumber || !cardExpiry || !cardCvv) {
        alert('❌ Veuillez remplir tous les champs');
        return;
    }
    
    if (cardNumber.length !== 16) {
        alert('❌ Numéro de carte invalide (16 chiffres)');
        return;
    }
    
    // Simulation de traitement
    const btn = document.querySelector('.btn-pay');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement en cours...';
    btn.disabled = true;
    
    setTimeout(() => {
        window.location.href = `/mkFashion/public/payment/success?session_id=<?= $session_id ?>`;
    }, 2000);
}
</script>
</body>
</html>