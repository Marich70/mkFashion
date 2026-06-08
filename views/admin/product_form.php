<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= isset($product) ? 'Modifier' : 'Ajouter' ?> un produit - Admin</title>
    <link rel="stylesheet" href="/mkFashion/public/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include ROOT_PATH . '/views/admin/sidebar.php'; ?>
        
        <main class="admin-main">
            <h1><?= isset($product) ? '✏️ Modifier' : '➕ Ajouter' ?> un produit</h1>
            
            <form method="POST" style="background: white; padding: 30px; border-radius: 15px; max-width: 600px;">
                <div style="margin-bottom: 15px;">
                    <label>Nom du produit :</label>
                    <input type="text" name="name" value="<?= $product['name'] ?? '' ?>" required style="width: 100%; padding: 10px; margin-top: 5px;">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label>Description :</label>
                    <textarea name="description" rows="5" style="width: 100%; padding: 10px;"><?= $product['description'] ?? '' ?></textarea>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label>Prix (FCFA) :</label>
                    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?? '' ?>" required style="width: 100%; padding: 10px;">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label>URL de l'image :</label>
                    <input type="text" name="image_url" value="<?= $product['image_url'] ?? '' ?>" style="width: 100%; padding: 10px;">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label>Stock :</label>
                    <input type="number" name="stock" value="<?= $product['stock'] ?? '' ?>" required style="width: 100%; padding: 10px;">
                </div>
                
                <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
                <a href="/mkFashion/public/admin/products" class="btn">❌ Annuler</a>
            </form>
        </main>
    </div>
</body>
</html>