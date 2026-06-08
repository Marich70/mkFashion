<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commandes - Admin MK Fashion</title>
    <link rel="stylesheet" href="/mkFashion/public/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include ROOT_PATH . '/views/admin/sidebar.php'; ?>
        
        <main class="admin-main">
            <h1>📦 Gestion des commandes</h1>
            
            <table class="data-table">
                <thead>
                    <tr><th>ID</th><th>Client</th><th>Total</th><th>Date</th><th>Statut</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= $order['id'] ?></td>
                        <td><?= htmlspecialchars($order['user_name']) ?><br><small><?= $order['email'] ?></small></td>
                        <td><?= number_format($order['total_price'], 2) ?> €</td>
                        <td><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                        <td>
                            <form method="POST" action="/mkFashion/public/admin/updateOrderStatus" style="display: inline;">
                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                <select name="status" onchange="this.form.submit()">
                                    <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>⏳ En attente</option>
                                    <option value="paid" <?= $order['status'] == 'paid' ? 'selected' : '' ?>>✅ Payée</option>
                                    <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>📦 Expédiée</option>
                                    <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : '' ?>>🎁 Livrée</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="/mkFashion/public/admin/orderDetail/<?= $order['id'] ?>" class="btn btn-primary">Voir détails</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>