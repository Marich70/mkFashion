<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail commande #<?= $id ?> - Admin</title>
    <link rel="stylesheet" href="/mkFashion/public/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include ROOT_PATH . '/views/admin/sidebar.php'; ?>
        
        <main class="admin-main">
            <h1>📦 Détail de la commande #<?= $id ?></h1>
            
            <table class="data-table">
                <thead>
                    <tr><th>Produit</th><th>Image</th><th>Quantité</th><th>Prix unitaire</th><th>Total</th></tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach ($orderDetails as $item): 
                        $itemTotal = $item['price'] * $item['quantity'];
                        $total += $itemTotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><img src="<?= $item['image_url'] ?>" width="50"></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price'], 2) ?> €</td>
                        <td><?= number_format($itemTotal, 2) ?> €</td>
                    </tr>
                    <?php endforeach; ?>
                    <tr style="background: #f0f0f0; font-weight: bold;">
                        <td colspan="4" align="right">Total :</td>
                        <td><?= number_format($total, 2) ?> €</td>
                    </tr>
                </tbody>
            </table>
            
            <br>
            <a href="/mkFashion/public/admin/orders" class="btn btn-primary">⬅️ Retour aux commandes</a>
        </main>
    </div>
</body>
</html>