<?php
// Vérifier que les stats existent
if (!isset($stats)) {
    $stats = [
        'total_products' => 0,
        'total_users' => 0,
        'total_orders' => 0,
        'total_revenue' => 0,
        'pending_orders' => 0,
        'low_stock' => 0
    ];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - MK Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0f0f1a;
            overflow-x: hidden;
        }

        /* SIDEBAR */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s;
            z-index: 100;
        }

        .sidebar-header {
            padding: 30px 25px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-logo {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-nav {
            padding: 30px 0;
        }

        .nav-item {
            padding: 12px 25px;
            margin: 5px 0;
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .nav-item:hover, .nav-item.active {
            background: rgba(102,126,234,0.2);
            color: white;
            border-left-color: #667eea;
        }

        .nav-item i {
            width: 24px;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
        }

        /* TOP BAR */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 15px 25px;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .page-title h1 {
            font-size: 1.5rem;
            color: #1a1a2e;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .admin-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }

        /* STATS GRID */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .stat-info h3 {
            font-size: 0.85rem;
            color: #999;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #1a1a2e;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
        }

        /* CHARTS SECTION */
        .charts-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
        }

        .chart-card h3 {
            margin-bottom: 20px;
            color: #1a1a2e;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        /* RECENT ORDERS */
        .recent-section {
            background: white;
            border-radius: 20px;
            padding: 25px;
        }

        .recent-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .recent-header h3 {
            color: #1a1a2e;
        }

        .recent-table {
            width: 100%;
            border-collapse: collapse;
        }

        .recent-table th, .recent-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        .recent-table th {
            color: #999;
            font-weight: 600;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-paid { background: #d4edda; color: #155724; }
        .status-shipped { background: #cce5ff; color: #004085; }
        .status-delivered { background: #d1ecf1; color: #0c5460; }

        .btn-view {
            padding: 6px 15px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.75rem;
        }

        /* LOW STOCK ALERT */
        .alert-card {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .alert-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .alert-icon {
            font-size: 2rem;
        }

        .alert-text h4 {
            color: #856404;
            margin-bottom: 5px;
        }

        .alert-text p {
            color: #856404;
            opacity: 0.8;
        }

        @media (max-width: 968px) {
            .sidebar {
                width: 80px;
            }
            .sidebar .sidebar-logo, .sidebar .nav-item span {
                display: none;
            }
            .main-content {
                margin-left: 80px;
            }
            .charts-section {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="admin-wrapper">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">🔥 MK</div>
        </div>
        <nav class="sidebar-nav">
            <a href="/mkFashion/public/admin" class="nav-item active">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="/mkFashion/public/admin/products" class="nav-item">
                <i class="fas fa-tshirt"></i>
                <span>Produits</span>
            </a>
            <a href="/mkFashion/public/admin/orders" class="nav-item">
                <i class="fas fa-truck"></i>
                <span>Commandes</span>
            </a>
            <a href="/mkFashion/public/admin/users" class="nav-item">
                <i class="fas fa-users"></i>
                <span>Utilisateurs</span>
            </a>
            <a href="/mkFashion/public/" class="nav-item">
                <i class="fas fa-store"></i>
                <span>Boutique</span>
            </a>
            <a href="/mkFashion/public/auth/logout" class="nav-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Déconnexion</span>
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h1>Dashboard</h1>
            </div>
            <div class="admin-info">
                <span>👋 <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></span>
                <div class="admin-avatar">
                    <?= strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)) ?>
                </div>
            </div>
        </div>

        <!-- ALERT LOW STOCK -->
        <?php if ($stats['low_stock'] > 0): ?>
        <div class="alert-card">
            <div class="alert-content">
                <div class="alert-icon">⚠️</div>
                <div class="alert-text">
                    <h4>Stock faible détecté !</h4>
                    <p><?= $stats['low_stock'] ?> produit(s) ont un stock inférieur à 10 unités</p>
                </div>
            </div>
            <a href="/mkFashion/public/admin/products" class="btn-view">Voir les produits</a>
        </div>
        <?php endif; ?>

        <!-- STATS CARDS -->
        <div class="stats-grid">
            <div class="stat-card" onclick="location.href='/mkFashion/public/admin/products'">
                <div class="stat-info">
                    <h3>Total Produits</h3>
                    <div class="stat-value"><?= $stats['total_products'] ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-tshirt"></i>
                </div>
            </div>
            <div class="stat-card" onclick="location.href='/mkFashion/public/admin/users'">
                <div class="stat-info">
                    <h3>Total Clients</h3>
                    <div class="stat-value"><?= $stats['total_users'] ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-card" onclick="location.href='/mkFashion/public/admin/orders'">
                <div class="stat-info">
                    <h3>Commandes</h3>
                    <div class="stat-value"><?= $stats['total_orders'] ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Chiffre d'affaires</h3>
                    <div class="stat-value"><?= number_format($stats['total_revenue'], 2) ?> FCFA</div>
                </div>
                <div class="stat-icon">
                    <!-- <i class="fas fa-euro-sign"></i> -->
                </div>
            </div>
        </div>

        <!-- CHARTS -->
        <div class="charts-section">
            <div class="chart-card">
                <h3>📊 Évolution des ventes (30 jours)</h3>
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <h3>🥧 Répartition des commandes</h3>
                <div class="chart-container">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>

        <!-- RECENT ORDERS -->
        <div class="recent-section">
            <div class="recent-header">
                <h3>📦 Dernières commandes</h3>
                <a href="/mkFashion/public/admin/orders" class="btn-view">Voir tout</a>
            </div>
            <table class="recent-table">
                <thead>
                    <tr><th>ID</th><th>Client</th><th>Date</th><th>Total</th><th>Statut</th><th>Action</th></tr>
                </thead>
                <tbody id="recentOrders">
                    <tr><td colspan="6" style="text-align: center;">Chargement...</td></tr>
                </tbody>
            </table>
        </div>
    </main>
</div>

<script>
// Sales Chart
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'],
        datasets: [{
            label: 'Ventes (FCFA)',
            data: [1250, 1890, 2100, 2450],
            borderColor: '#667eea',
            backgroundColor: 'rgba(102,126,234,0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } }
    }
});

// Orders Distribution Chart
const ctx2 = document.getElementById('ordersChart').getContext('2d');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Payées', 'En attente', 'Expédiées', 'Livrées'],
        datasets: [{
            data: [45, 20, 15, 20],
            backgroundColor: ['#27ae60', '#f39c12', '#3498db', '#2ecc71']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Fetch recent orders
fetch('/mkFashion/public/api/recent-orders')
    .then(res => res.json())
    .then(data => {
        const tbody = document.getElementById('recentOrders');
        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">Aucune commande</td></tr>';
            return;
        }
        tbody.innerHTML = data.map(order => `
            <tr>
                <td>#${order.id}</td>
                <td>${order.user_name}</td>
                <td>${order.created_at}</td>
                <td>${order.total_price} FCFA</td>
                <td><span class="status-badge status-${order.status}">${order.status}</span></td>
                <td><a href="/mkFashion/public/admin/orderDetail/${order.id}" class="btn-view">Voir</a></td>
            </tr>
        `).join('');
    });
</script>
</body>
</html>