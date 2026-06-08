<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Produits - Admin MK Fashion</title>
    <link rel="stylesheet" href="/mkFashion/public/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include ROOT_PATH . '/views/admin/sidebar.php'; ?>
        
        <main class="admin-main">
            <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                <h1>👕 Gestion des produits</h1>
                <a href="/mkFashion/public/admin/createProduct" class="btn btn-primary">➕ Ajouter un produit</a>
            </div>
            
            <?php if (isset($_SESSION['admin_success'])): ?>
                <div class="alert success"><?= $_SESSION['admin_success'] ?></div>
                <?php unset($_SESSION['admin_success']); ?>
            <?php endif; ?>
            
            <table class="data-table">
                <thead>
                    <tr><th>ID</th><th>Image</th><th>Nom</th><th>Prix</th><th>Stock</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><img src="<?= $p['image_url'] ?>" width="50"></td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= number_format($p['price'], 2) ?> FCFA</td>
                        <td style="<?= $p['stock'] < 10 ? 'color: red; font-weight: bold;' : '' ?>">
                            <?= $p['stock'] ?>
                        </td>
                        <td>
                            <a href="/mkFashion/public/admin/editProduct/<?= $p['id'] ?>" class="btn btn-primary">✏️ Modifier</a>
                            <a href="/mkFashion/public/admin/deleteProduct/<?= $p['id'] ?>" class="btn btn-danger" onclick="return confirm('Supprimer ce produit ?')">🗑️ Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>