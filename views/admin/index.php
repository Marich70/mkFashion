<!DOCTYPE html>
<html>
<head>
    <title>Admin - Produits</title>
    <link rel="stylesheet" href="/mkFashion/public/css/style.css">
</head>
<body>
    <h1>👑 Admin - Gestion des produits</h1>
    <a href="/mkFashion/public/admin/create" class="btn">➕ Ajouter un produit</a>
    <a href="/mkFashion/public/" class="btn">🏠 Retour boutique</a>

    <table class="cart-table">
        <thead>
            <tr><th>ID</th><th>Image</th><th>Nom</th><th>Prix</th><th>Stock</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach ($products as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><img src="<?= $p['image_url'] ?>" width="40"></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= $p['price'] ?> €</td>
            <td><?= $p['stock'] ?></td>
            <td>
                <a href="/mkFashion/public/admin/edit/<?= $p['id'] ?>">✏️ Modifier</a>
                <a href="/mkFashion/public/admin/delete/<?= $p['id'] ?>" onclick="return confirm('Supprimer ?')">🗑️ Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>